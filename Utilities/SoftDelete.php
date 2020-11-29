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
    }

?>