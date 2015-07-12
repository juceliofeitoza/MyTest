<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/model/Musuario.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/action/Dao.php';

/**
 * Description of Ausuario
 *
 * @author Jucelio
 */
class Ausuario extends Musuario {
    private $sqlInsert = "insert into tb_usuario (id,email,namefull,user,pass
        ,active)values ('','%s','%s','%s','%s','%s')";
    
    private $sqlSelect = "select * from tb_usuario where 1=1 %s %s ";
    
    public $sqlContaLinhas = "select count(1) qtd from tb_usuario where 1=1 %s";
    
    private $sqlConsultarAuth = "select id, namefull from tb_usuario where active = '%s'";
    
    private $sqlAtivaUser = "update tb_usuario set active = '00000000000000000000000000000000' where id = %s";
    
    private $sqlVerificaLogin = "select count(1) qtd from tb_usuario where user = '%s'
         and pass = '%s' and active = '00000000000000000000000000000000'";
    
    public function insert() {
        $dao = new Dao();    
        $result = $dao->dml(sprintf($this->sqlInsert, $this->getEmail(),
            $this->getNomeCompleto(),$this->getUsuario(),$this->getSenha(),$this->getCodConfirm()));
        
        return $result;
    }       
                
    public function select($where = "", $order = "") {
        $dao = new dao();
        $sql = sprintf($this->sqlSelect, $where, $order);
            $result = $dao->query($sql);
        
        return $result[0];
    }
    
    public function contarLinhas($where = "", $order = "") {
        $dao = new dao();
        $sql = sprintf($this->sqlContaLinhas,$where, $order);
        $result = $dao->queryContarLinhas($sql);
        
        return $result[0]['qtd'];
    }
    public function verificarAuth($codAuth){
        $dao = new dao();
        $sql = sprintf($this->sqlConsultarAuth,$codAuth);
        $result = $dao->query($sql);
       
        return  $result[0];
    }
    
    public function autenticarUser($userAuth){
        $dao = new dao();
        $sql = sprintf($this->sqlAtivaUser,$userAuth);
        $result = $dao->dml($sql);
        
        return  $result;
    }
    
    public function verificaLogin() {
        $dao = new dao();
        $sql = sprintf($this->sqlVerificaLogin,$this->getUsuario(),$this->getSenha());
        $result = $dao->query($sql);
        
        return  $result[0]['qtd'];
    }
}
