<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/config/sendEmailConfirm.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/action/Ausuario.php';

/**
 * Description of cUsuario
 *
 * @author jucelio
 */

class Cusuario extends Ausuario {
   
    /*
     * Caso seja sucesso retorna false, no caso de insucesso retorna a msg do erro!
     */
    public function cadastrarUsuario($usuario) {
        
        if($usuario->{'email'} == '' || $usuario->{'email'} == null){
            return'Erro: Preencha um Email!!';
        }
        if($usuario->{'fullname'} == '' || $usuario->{'fullname'} == null){
            return'Erro: Preencha o Nome Completo!!';
        }
        if($usuario->{'username'} == '' || $usuario->{'username'} == null){
            return'Erro: Preencha o usuário!!';
        }
        if($usuario->{'password'} == '' || $usuario->{'password'} == null){
            return'Erro: Preencha a Senha!!';
        }
        if (!preg_match('/^[a-z\d_]{4,28}$/i', $usuario->{'username'})) {
            return "Usuario invalido: De 4 a 28 caracteres, alfanuméricos e acentuados:!";
        }
        if (!preg_match(
        '/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/',
        $usuario->{'email'})) {
            return "Email Inválido.";
        }
        if(!preg_match( '/[0-9]/' , $usuario->{'password'}) || !preg_match( '/[^A-Z]/' , $usuario->{'password'}) || !preg_match( '/[a-z]/' , $usuario->{'password'}) ) {
            return "Senha Invalida: Pelo menos uma letra minúscula, uma letra maiúscula e números.";
        }
        
        $this->setEmail($usuario->{'email'});
        $this->setNomeCompleto($usuario->{'fullname'});
        $this->setUsuario($usuario->{'username'});
        $this->setSenha($usuario->{'password'});
        
        if($this->getUsuario()){
            $where = "and user = '".$this->getUsuario()."'";
            $result = $this->contarLinhas($where);
            if($result != 0){
                return "Usuário já existente!";
            }
        }
        if($this->getEmail()){
            $where = "and email = '".$this->getEmail()."'";
            $result = $this->contarLinhas($where);
            if($result != 0){
                return "Email já Cadastrado!";
            }
        }

        if($this->insert()){

            $sendEmail = sendEmailConfirm($this->getEmail(),$this->getNomeCompleto(),$this->getCodConfirm());
           
            if($sendEmail) {
                return false;
            } else {
                return "Error: entre em contato com suporte!!";
            }
        } else {
            return  "Não foi possivel inserir o Usuario!";
        }
    }
    
    public function logarUsuario($usuario){
        if($usuario->{'user'} == '' || $usuario->{'user'} == null){
            return'Erro: Preencha o Usuario!!';
        }
        if($usuario->{'password'} == '' || $usuario->{'password'} == null){
            return'Erro: Preencha a Senha!!';
        }
        $this->setUsuario($usuario->{'user'});
        $this->setSenha($usuario->{'password'});
        
        if($this->verificaLogin() == 1){
            session_start();
            $_SESSION['user'] = $this->getUsuario();
            $_SESSION['password'] = true;
            return false;
        } else {
            return  "Usuario ou Senha Invalida!!";
        }
    }
    
    public function getUsuarioPerfil($user){
        $where = "and user = '".$user."'";
        $return = $this->select($where);
  
        if($return){
            if(isset($return['user'])) {
            $this->setUsuario($return['user']);
            }
            if(isset($return['namefull'])) {
                $this->setNomeCompleto($return['namefull']);
            }
            if(isset($return['email'])) {
                $this->setEmail($return['email']);
            }
            
            return $this;
        }
    }
}
