<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'].'/controller/Cusuario.php';

$json = file_get_contents('php://input');

$obj  = json_decode($json);

$usuario = new Cusuario();
    
$msg = $usuario->cadastrarUsuario($obj); 
    
    if(!$msg){
        $msg = "Usuario cadastrado com sucesso!! Acesse seu email(".$usuario->getEmail().") e ative sua conta!";
        $tipo = 'success';
    } else {
        $tipo = 'error';
    }

$retorno = ["msg"=>$msg, 'tipo' => $tipo];

echo json_encode($retorno);


