<?php

    namespace Utilities;
    
    use Utilities\Query;

    class BasedQuery extends Query{
        protected $classname;
        protected $id_column;

        public function __construct($table,$classname){
            parent::__construct($table);
            $this->classname=$classname;
        }

        public function where($field,$operator,$value){
            $reflection  = new \ReflectionClass("Models\\".$this->classname);
            $object = $reflection->newInstance();
            $object->getFields();
            $fieldname= $object->getColumn($field);
            return parent::where($fieldname,$operator,$value);
        }

        public function list(){
            $result=parent::list();
            $return=[];
            foreach ($result as $row) {
                $reflection  = new \ReflectionClass("Models\\".$this->classname);
                $object = $reflection->newInstance();
                $object->getFields();
                foreach ($object->getFields() as $field) {
                    $property=$field->property;
                    $object->$property=$row[$field->name];
                }
                array_push($return,$object);
            }
            return $return;
        }

        public function get(){
            $result=parent::get();
            $reflection  = new \ReflectionClass("Models\\".$this->classname);
            $object = $reflection->newInstance();
            $object->getFields();
            foreach ($object->getFields() as $field) {
                $property=$field->property;
                $object->$property=$result[$field->name];
            }
            return $object;
        }

    }
?>