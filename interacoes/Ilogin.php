<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'].'/controller/Cusuario.php';

$json = file_get_contents('php://input');

$obj  = json_decode($json);

$usuario = new Cusuario();
$msg = $usuario->logarUsuario($obj); 
    
    if(!$msg){
        $msg = "Usuario Logado!";
        $tipo = 'success';
    } else {
        $tipo = 'error';
    }

$retorno = ["msg"=>$msg, 'tipo' => $tipo];

echo json_encode($retorno);


