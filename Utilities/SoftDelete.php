<?php

    namespace Utilities;

    trait SoftDelete{
        public static function delete($id){
            $dbname=DBNAME;
            $classname=self::$classname;
            $reflection  = new \ReflectionClass($classname);
            $object = $reflection->newInstance();
            $object->db_table=$object->getTable();
            $object->db_fields=$object->getFields();
            $id_column=$object->id_column;
            if ($this->columnExists()) {
                # code...
            }

            // $sql="DELETE FROM `".$dbname."`.`".$object->db_table."` WHERE ".$id_column."=?";
            $result=Database::update($sql,$id);
        }
    }

?>