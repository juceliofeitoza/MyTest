<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/config/db.class.php';

class Dao extends Conexao {


    public function dml($sql) {
       return $this->RunQuery($sql);
    }
    
    public function queryContarLinhas($sql) {
        $rs = $this->RunSelect($sql);
        return $rs;
    }

    public function query($sql) {
        return $result = $this->RunSelect($sql);
    }

}
