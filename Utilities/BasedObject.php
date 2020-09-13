<?php

abstract class BasedObject
{
    /**
    *@type int
    */
    public $id;
    private $db_table;
    private $db_fields;

    public final function __construct(){
        $classname=$this->getClass();
        $this->db_table=$this->getTable();   
        $this->getFields();
    }

    public final function getClass(){
        return get_class($this);
    }

    public final function save(){

    }

    public final function getTable(){
        $classname=$this->getClass();
        $meta = new ReflectionClass($classname);
        $comment=$meta->getDocComment();
        preg_match_all('#@(.*?)\n#s', $comment, $annotations);
        foreach ($annotations[1] as $annotation) {
            $annotation=trim($annotation);
            preg_match_all('/table \w+/s', $annotation, $res);
            $result=ltrim($res[0][0],"table ");
            if(count($res)>0){
            break;   
            }
        }
        return $result;
    }

    public final function getFields(){
        $classname=$this->getClass();
        $public= DataQuery::getPublic($this);
        foreach ($public as $field => $value) {
            $dataField = new DataField($field);
            $comment = new ReflectionProperty($classname, $field);
            $comment=$comment->getDocComment();
            preg_match_all('#@(.*?)\n#s', $comment, $annotations);
            //parse annotations
            foreach ($annotations[1] as $annotation) {
                $annotation=trim($annotation);
                preg_match_all('/column \w+/s', $annotation, $res);
                if(count($res[0])>0){
                    $result = substr($res[0][0], 6);
                    $dataField->name=$result;
                }else{
                    preg_match_all('/type \w+/s', $annotation, $res);
                    if(count($res[0])>0){
                        $result = substr($res[0][0], 5);
                        $dataField->type=$result;
                    }else{
                        preg_match_all('/salted/s', $annotation, $res);
                        if(count($res[0])>0){
                            $dataField->is_salted=true;
                        }
                    }
                }
            }
            echo $dataField;
        }
    }

    public function __toString(){
        return json_encode($this);
    }

}

class DataField{
    public $name;
    public $type;
    public $value;
    public $is_salted = false;

    public function __construct($name,$type="string",$value=null){
        $this->name=$name;
        $this->type=$type;
        $this->value=$value;
    }

    public function __toString(){
        return json_encode($this);
    }
    
}

class DataQuery{
    private $query;
    private $fields = [];
    private $where = [];

    public function __construct(){

    }

    public static function getPublic($object){
        return get_object_vars($object);
    }

}


?>