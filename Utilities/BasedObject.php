<?php

abstract class BasedObject
{
    /**
    *@type int
    */
    public $id;
    private $db_table;
    private $db_fields;
    private $id_column="id";

    public final function __construct(){
        $classname=$this->getClass();
        $this->db_table=$this->getTable();   
        $this->getFields();
    }

    public final function getClass(){
        return get_class($this);
    }

    public static final function get($id){
        $dbname=DBNAME;
        $classname=static::class;
        $reflection  = new ReflectionClass($classname);
        $object = $reflection->newInstance();
        $object->db_table=$object->getTable();
        $object->db_fields=$object->getFields();
        $id_column=$object->id_column;
        $sql="SELECT * FROM `".$dbname."`.`".$object->db_table."` WHERE ".$id_column."=?";
        $result=Database::selectOne($sql,$id);
        foreach ($result as $property => $value) {
            foreach ($object->db_fields as $field) {
                if($property==$field->name && !$field->is_salted && !$field->is_object){
                    $propertyName=$field->property;
                    $object->$propertyName=$value;
                }
            }
        }
        return $object;
    }

    public final function save(){
        $dbname=DBNAME;        
        $this->db_table=$this->getTable();
        $this->db_fields=$this->getFields();
        $sql="SELECT COUNT(".$this->id_column.") AS result FROM `".$dbname."`.`".$this->getTable()."` WHERE ".$this->id_column."=?";
        // echo $sql;
        $count=DataBase::selectOne($sql,$this->id);
        if($count["result"]>0){
            $this->update();
        }else{
            $this->insert();
        }
    }

    public final function update(){
        $this->db_table=$this->getTable();
        $this->db_fields=$this->getFields();
        // print_r($this->getFields());
        $dbname=DBNAME;
        $query="UPDATE `".$dbname."`.`".$this->db_table."` SET ";
        $values=[];
        $i=0;
        // print_r($this->db_fields);
        foreach ($this->db_fields as $field) {
            if(!$this->checkType($field)){
                echo "<br>error</br>";
                return false;
            }
            if($field->is_salted){
                $field->value=Security::salt($field->value);
            }
            $query=$query.$field->name."=?";
            array_push($values,$field->value);
            $i++;
            if($i<count($this->db_fields)){
                $query=$query.",";
            }else{
                $query=$query." WHERE ".$this->id_column."=?";
                array_push($values,$this->id);
            }
        }
        array_unshift($values,$query);
        forward_static_call_array("Database::update",$values);
    }

    public final function insert(){
        $this->db_table=$this->getTable();
        $this->db_fields=$this->getFields();
        // print_r($this->getFields());
        $dbname=DBNAME;
        $query="INSERT INTO `".$dbname."`.`".$this->db_table."`(";
        $values=[];
        $i=0;
        // print_r($this->db_fields);
        foreach ($this->db_fields as $field) {
            if(!$this->checkType($field)){
                echo "<br>error</br>";
                return false;
            }
            if($field->is_salted){
                $field->value=Security::salt($field->value);
            }
            $query=$query.$field->name;
            array_push($values,$field->value);
            $i++;
            if($i<count($this->db_fields)){
                $query=$query.",";
            }else{
                $query=$query.")";
            }
        }
        // print_r($values);
        // echo $query;
        $query=$query." VALUES(";
        $i=0;
        foreach ($values as $value) {
            $query=$query."?";
            $i++;
            if($i<count($values)){
                $query=$query.",";
            }else{
                $query=$query.")";
            }
        }
        // echo $query;
        // print_r($values);
        array_unshift($values,$query);
        forward_static_call_array("Database::update",$values);
    }

    public final function getTable(){
        $classname=$this->getClass();
        $result=$classname;
        $meta = new ReflectionClass($classname);
        $comment=$meta->getDocComment();
        preg_match_all('#@(.*?)\n#s', $comment, $annotations);
        foreach ($annotations[1] as $annotation) {
            $annotation=trim($annotation);
            preg_match_all('/table \w+/s', $annotation, $res);
            if(count($res[0])>0){
                $result=ltrim($res[0][0],"table ");
                if(count($res)>0){
                break;   
                }
            }else{
                $result=$classname;
            }
        }
        return $result;
    }

    private function getType(Datafield $dataField){
        if(!$dataField->is_null && is_null($dataField->value)){
            return $dataField->type;
        }elseif (is_bool($dataField->value)) {
            return "bool";
        }elseif (is_numeric($dataField->value)) {
            return "number";
        }else{
            return "string";
        }
    }

    private function checkType(DataField $dataField){
        if(!$dataField->is_null && is_null($dataField->value)){
            return false;
        }
        switch ($dataField->type) {
            case "string":
                return true;
                break;
            case "email":
                if(filter_var($dataField->value, FILTER_VALIDATE_EMAIL)) {
                    return true;
                }
                else {
                    return false;
                }
                break;
            case "url":
                if (filter_var($dataField->value, FILTER_VALIDATE_URL)) { 
                    return true;
                }else{
                    return false;
                }
                break;
            case "json":
                json_decode($dataField->value);
                return (json_last_error() == JSON_ERROR_NONE);
            case "bool":
            case "number":
            case "float":
            case "double":
            case "int":
                if(is_numeric(floatval($dataField->value))){
                    return true;
                }else{
                    return false;
                }
                break;
            case "date":
                $date = DateTime::createFromFormat("Y-m-d", $dataField->value);
                return $date && $date->format("Y-m-d") == $dataField->value;
                break;
            case "datetime":
                $date = DateTime::createFromFormat("Y-m-d h:i:s", $dataField->value);
                return $date && $date->format("Y-m-d h:i:s") == $dataField->value;
                break;
            default:
                return false;
        }
    }

    public final function getFields(){
        $classname=$this->getClass();
        $public= DataField::getPublic($this);
        $return = [];
        foreach ($public as $field => $value) {        
            $dataField = new DataField($field,$field);
            $dataField->value=$value;
            $comment = new ReflectionProperty($classname, $field);
            $comment=$comment->getDocComment();
            preg_match_all('#@(.*?)\n#s', $comment, $annotations);
            //parse annotations
            $type=false;
            foreach ($annotations[1] as $annotation) {
                $annotation=trim($annotation);
                preg_match_all('/column \w+/s', $annotation, $res);
                if(count($res[0])>0){
                    $result = substr($res[0][0], 7);
                    if($field=="id"){$this->id_column=$result;}
                    $dataField->name=$result;
                }else{
                    preg_match_all('/var \w+/s', $annotation, $res);
                    if(count($res[0])>0){
                        $result = substr($res[0][0], 4);
                        $type=true;
                        $dataField->type=$result;
                    }else{
                        preg_match_all('/salted/s', $annotation, $res);
                        if(count($res[0])>0){
                            $dataField->is_salted=true;
                        }else{
                            preg_match_all('/not null/s', $annotation, $res);
                            if(count($res[0])>0){
                                $dataField->is_null=false;
                            }
                        }
                    }
                }
            }
            if(!$type){
                $dataField->type=$this->getType($dataField);
            }
            array_push($return,$dataField);
        }
        return $return;
    }

    public function __toString(){
        return json_encode($this);
    }

}

class DataField{
    public $name;
    public $property;
    public $type;
    public $value;
    public $is_salted = false;
    public $is_null = true;
    public $is_object = false;

    public function __construct($name,$property,$type="string",$value=null){
        $this->name=$name;
        $this->property=$property;
        $this->type=$type;
        $this->value=$value;
    }

    public function __toString(){
        return json_encode($this);
    }

    public static function getPublic($object){
        return get_object_vars($object);
    }
    
}


?>