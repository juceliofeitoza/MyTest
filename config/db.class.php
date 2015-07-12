<?php

class Conexao {
    
    private $host = "mysql.hostinger.com.br";
    private $database = "u772758361_user1";
    private $password = "@123456#";
    private $user = "u772758361_user1";
    
 
    public function getUser() {
        return $this->user;
    }

    public function getHost() {
        return $this->host;
    }

    public function getDatabase() {
        return $this->database;
    }

    public function getPassword() {
        return $this->password;
    }

    private function connect() {
        $conn = new PDO("mysql:host=$this->host;dbname=$this->database", "$this->user", "$this->password");
        return $conn;
    }

    public function runQuery($sql) {
        $stm = $this->connect()->prepare($sql);
        $executou = $stm->execute();
        if (!$executou) { 
            $erro = $stm->errorInfo();
            print "<br>erro no sql: " . $sql . "<br><br>";
            print_r($erro);
            die;
        }
        return $executou;
    }

    public function runSelect($sql) {
        $stm = $this->connect()->prepare($sql);
        if (empty($stm)) { 
            print "Consulta inválida";
            die;
        }
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function preparaSQL($sql) {
        return $this->connect()->prepare($sql);
    }

    public function getConexao() {
        return $this->connect();
    }

}
