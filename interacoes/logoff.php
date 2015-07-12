<?php

/* 
 * Arquivo para fazer logoff e redirecionar para o login
 */


session_start(); 

session_destroy(); 

header('location: http://jucelio.pe.hu/index.php'); 

