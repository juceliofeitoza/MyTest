<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/action/Ausuario.php';

/**
 * Description of ControllerAutenticacao
 *
 * @author Jucelio
 */
class ControllerAutenticacao extends Ausuario {
    
    private $auth;
    
    function __construct($auth) {
        
        $userAuth = $this->verificarAuth($auth);

        if($userAuth['id']) {
            if($this->autenticarUser($userAuth['id'])) {
                $this->setAuth(true);
            }else{
                $this->setAuth(false);
            }
        } else { 
            $this->setAuth(false);
        }
    }
    
    public function getAuth() {
        return $this->auth;
    }
    
    public function setAuth($auth){
        $this->auth = $auth;
    }
}
?>