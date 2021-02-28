<?php

    namespace Utilities;

    trait SoftDelete{

        public static function delete($id){
            $dbname=DBNAME;
            $classname=get_called_class();
            $reflection  = new \ReflectionClass($classname);
            $object = $reflection->newInstance();
            $object->getTable();
            $object->getFields();
            $id_column=$object->getId_column();
            if ($object->columnExists("deleted_at")) {
                Database::update("UPDATE `".$dbname."`.`".$object->getTable()."` SET deleted_at=CURRENT_TIMESTAMP WHERE ".$id_column."=? ",$id);
            }else{
                Database::update("ALTER TABLE ".$object->getTable()." ADD COLUMN deleted_at TIMESTAMP NULL DEFAULT NULL");
                Database::update("UPDATE `".$dbname."`.`".$object->getTable()."` SET deleted_at=CURRENT_TIMESTAMP WHERE ".$id_column."=? ",$id);
            }
        }

        public static function get($id){
            $dbname=DBNAME;
            $classname=self::getClassStatic();
            $reflection  = new \ReflectionClass($classname);
            $object = $reflection->newInstance();
            $object->db_table=$object->getTable();
            $object->db_fields=$object->getFields();
            
            if (!$object->columnExists("deleted_at")) {            
                Database::update("ALTER TABLE ".$object->getTable()." ADD COLUMN deleted_at TIMESTAMP NULL DEFAULT NULL");
            }

            $id_column=$object->id_column;
            $count=Database::selectOne("SELECT COUNT(".$id_column.") as mycount FROM `".$dbname."`.`".$object->db_table."` WHERE ".$id_column."=? AND deleted_at IS NULL",$id);
            if($count["mycount"]<1){
                return false;
            }else{
                $sql="SELECT * FROM `".$dbname."`.`".$object->db_table."` WHERE ".$id_column."=? AND deleted_at IS NULL";
                $result=Database::selectOne($sql,$id);
                foreach ($result as $property => $value) {
                    foreach ($object->db_fields as $field) {
                        if($property==$field->name && !$field->is_object){
                            $propertyName=$field->property;
                            $object->$propertyName=$value;
                        }
                    }
                }
                return $object;
            }
        }

        public static function list(){
            $dbname=DBNAME;
            $classname=\get_called_class();
            $reflection  = new \ReflectionClass($classname);
            $object = $reflection->newInstance();
            $object->db_table=$object->getTable();
            $object->db_fields=$object->getFields();

            if (!$object->columnExists("deleted_at")) {            
                Database::update("ALTER TABLE ".$object->getTable()." ADD COLUMN deleted_at TIMESTAMP NULL DEFAULT NULL");
            }

            $id_column=$object->id_column;
            $sql="SELECT * FROM `".$dbname."`.`".$object->db_table."` WHERE deleted_at IS NULL";
            // echo $sql;
            $result=Database::selectMany($sql);
            $return=[];
            foreach ($result as $row) {
                $object=$object->get($row[$id_column]);
                array_push($return,$object);
            }
            return $return;
        }

        public static function listDeleted(){
            $dbname=DBNAME;
            $classname=\get_called_class();
            $reflection  = new \ReflectionClass($classname);
            $object = $reflection->newInstance();
            $object->db_table=$object->getTable();
            $object->db_fields=$object->getFields();

            if (!$object->columnExists("deleted_at")) {            
                Database::update("ALTER TABLE ".$object->getTable()." ADD COLUMN deleted_at TIMESTAMP NULL DEFAULT NULL");
            }

            $id_column=$object->id_column;
            $sql="SELECT * FROM `".$dbname."`.`".$object->db_table."` WHERE deleted_at IS NOT NULL";
            // echo $sql;
            $result=Database::selectMany($sql);
            $return=[];
            foreach ($result as $row) {
                $object=$object->get($row[$id_column]);
                array_push($return,$object);
            }
            return $return;
        }

        public static function getDeleted($id){
            $dbname=DBNAME;
            $classname=self::getClassStatic();
            $reflection  = new \ReflectionClass($classname);
            $object = $reflection->newInstance();
            $object->db_table=$object->getTable();
            $object->db_fields=$object->getFields();
            
            if (!$object->columnExists("deleted_at")) {            
                Database::update("ALTER TABLE ".$object->getTable()." ADD COLUMN deleted_at TIMESTAMP NULL DEFAULT NULL");
            }

            $id_column=$object->id_column;
            $count=Database::selectOne("SELECT COUNT(".$id_column.") as mycount FROM `".$dbname."`.`".$object->db_table."` WHERE ".$id_column."=? AND deleted_at IS NOT NULL",$id);
            if($count["mycount"]<1){
                return false;
            }else{
                $sql="SELECT * FROM `".$dbname."`.`".$object->db_table."` WHERE ".$id_column."=? AND deleted_at IS NOT NULL";
                $result=Database::selectOne($sql,$id);
                foreach ($result as $property => $value) {
                    foreach ($object->db_fields as $field) {
                        if($property==$field->name && !$field->is_object){
                            $propertyName=$field->property;
                            $object->$propertyName=$value;
                        }
                    }
                }
                return $object;
            }
        }

        public function listWithDeleted(){
            return parent::list();
        }

    }

?>