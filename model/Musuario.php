<?php

/**
 * Description of Musuario
 *
 * @author Jucelio
 */

class Musuario{
    private $email;
    private $nomeCompleto;
    private $usuario;
    private $senha;
    private $codConfirm;
    
    public function setEmail($email) {
        $this->email = $email;
    }
    
    public function setNomeCompleto($nomeCompleto) {
        $this->nomeCompleto = $nomeCompleto;
    }
    
    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }
    
    public function setSenha($senha){
        $this->senha = md5($senha);
    }
    
    public function getEmail() {
        return $this->email;
    }
    
    public function getNomeCompleto() {
        return $this->nomeCompleto;
    }
    
    public function getUsuario() {
        return $this->usuario;
    }
    
    public function getSenha() {
        return $this->senha;
    }
    
    public function getCodConfirm() {
        $email = $this->getEmail();
        $senha = $this->getSenha();
        
        $codConfirm = "$email.$senha";
        $codConfirmMd5 = md5($codConfirm);
        
        return $codConfirmMd5;
    }
    

}
