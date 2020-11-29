<?php

namespace Utilities;
use Utilities\Database;

class Query{
    protected $sql;
    protected $wheres=[];
    protected $db_table;

    public function __construct($table){
        $this->db_table=$table;
        $this->sql="SELECT * FROM `".DBNAME."`.`".$table."`";
    }

    public function where($field,$operator,$value){
        array_push($this->wheres,$field.$operator."'".$value."'");
        return $this;
    }

    protected function build(){
        $result=$this->sql;
        if(count($this->wheres)>0){
            for ($i=0; $i < count($this->wheres); $i++) { 
                if ($i==0) {
                    $result=$result." WHERE ".$this->wheres[$i];
                }else{
                    $result=$result." AND ".$this->wheres[$i];
                }
            }
        }
        $this->sql=$result;
    }

    public function getSql(){
        $this->build();
        return $this->sql;
    }
    
    public function get(){
        return Database::selectOne($this->getSql());
    }

    public function list(){
        return Database::selectMany($this->getSql());
    }


}

?>