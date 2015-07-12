<?php
session_start();
if($_SESSION['password']) {
    if($_GET['auth']) {
        header('Location: http://jucelio.pe.hu/index.php');
        exit;
    }
    getPerfil($_SESSION['user']);
} else {
    session_destroy();
    getLoginAndCad();
} 

function getLoginAndCad(){
?>
<!doctype html>

<html lang="pt-br">
<head>
<meta charset="utf-8"/>
<title>MyTest</title>
    <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <?php include_once $_SERVER['DOCUMENT_ROOT'].'/interacoes/Iautenticacao.php'; ?>

</head>
<body>
    <div class="container">    
        <div id="divLogin" style="margin-top:50px;" class="col-md-6 col-sm-8">                    
            <div class="panel panel-info" >
                <div class="panel-heading">
                    <div>Logar</div>
                </div>     
                <div  class="panel-body" >
                    <div style="display:none" id="msgSucess" class="alert alert-success"></div>
                    <div style="display:none" id="msgDangerLogin" class="alert alert-danger"></div>
                    <form id="form-login" class="form-horizontal">
                        <div style="margin-bottom: 25px" class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input id="user" type="text" class="form-control" name="user" value="" placeholder="Usuário">                                        
                        </div>
                        <div style="margin-bottom: 25px" class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input id="password" type="password" class="form-control" name="password" placeholder="Senha">
                        </div>
                        <div style="margin-top:10px" class="form-group">
                            <div class="col-sm-12">
                              <div id="loadspinLogin" ></div>
                              <a id="btn-entrar" href="#" class="btn btn-success">Entrar</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 control">
                                <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
                                    Você não é cadastrado? 
                                <a id="cadastrar">
                                    Cadastre-se Aqui!
                                </a>
                                </div>
                            </div>
                        </div>    
                    </form>     
                </div>                     
            </div>  
        </div>
        <div id="divCad" style="display:none; margin-top:50px" class="col-md-6  col-sm-8">
            <div class="panel panel-info">
                <div class="panel-heading col-md-12 col-sm-12 col-lg-12">
                    <div class=" col-lg-10 col-md-10 col-sm-10">Cadastre-se</div>
                    <div class=" col-lg-2 col-md-2">
                        <a id="signinlink" href="" onclick="$('#divCad').hide(); $('#divLogin').show()">Logar</a>
                    </div>
                </div>  
                <div class="panel-body">
                    <div style="display:none" id="msgDanger" class="alert alert-danger"></div>
                    <form style="padding-top: 20px;" id="form-cadastrar" class="form-horizontal">
                        <div class="form-group">
                            <label for="email" class="col-md-3 control-label">Email</label>
                            <div class="col-md-9">
                                <input id="form-email" type="email" class="form-control" name="email" placeholder="Email" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nome-completo" class="col-md-3 control-label">Nome Completo</label>
                            <div class="col-md-9">
                                <input id="form-fullname" type="text" class="form-control" name="nome-completo" placeholder="Nome Completo">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="usuario" class="col-md-3 control-label">Usuário</label>
                            <div class="col-md-9">
                                <input id="form-user" placeholder="Usuario" type="text" class="form-control" name="usuario">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="senha" class="col-md-3 control-label">Senha</label>
                            <div class="col-md-9">
                                <input id="form-password" type="password" placeholder="Senha" class="form-control" name="senha">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-9">
                                <div id="loadspin" ></div>
                                <button id="mandarDadosCad" type="button" class="btn btn-info"> Cadastrar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div> 
    </div>
</body>
<script type="text/javascript">
$(document).ready(function(){
    
    $('#cadastrar').click(function(){
        $('#msgSucess').hide().html('');
        $('#msgDanger').hide().html('');
        $('#msgDangerLogin').hide().html('');
        $('#divLogin').hide();
        $('#divCad').show();
    });
    
    $('#logar').click(function(){
        $('#msgSucess').hide().html('');
        $('#msgDangerLogin').hide().html('');
        $('#msgDanger').hide().html('');
        $('#divLogin').show();
        $('#divCad').hide();
    });
    
    
    $('#form-login #btn-entrar').click(function(){
        $('#msgSucess').hide().html('');
        $('#msgDangerLogin').hide().html('');
        $('#msgDanger').hide().html('');
        
        if($('#form-login #user').val() == '' || $('#form-login #user').val() == null) {
            $('#msgDanger').show().html('Digite o Usuario!!');
            return false;
        }
        if($('#form-login #password').val() == '' || $('#form-login #password').val() == null) {
            $('#msgDangerLogin').show().html('Digite o Senha Corretamente!!');
            return false;
        }
        
        var dados = {
            user: $('#form-login #user').val(),
            password:$('#form-login #password').val(),
        };
        $('#loadspinLogin').html('<img src="img/ajax_load.gif">');
        $.ajax({
            url:"interacoes/Ilogin.php",
            type: 'POST',
            dataType: "json",
            contentType: 'application/json',
            data: JSON.stringify(dados),
            success: function(data){
                if(data.tipo == 'success') {
                    $('#loadspinLogin').html('');
                    location.reload();
                }else if(data.tipo == 'error'){
                    $('#msgDangerLogin').show().html(data.msg);
                    $('#loadspinLogin').html('');
                }
            },
            error: function(data, error, xhr){
                $('#loadspinLogin').html('');
            }
        });
    $('#loadspinLogin').html('');
    });
    
    
    $('#form-cadastrar #mandarDadosCad').click(function(){
        if($('#form-cadastrar #form-email').val() == '' || $('#form-cadastrar #form-email').val() == null) {
            $('#form-cadastrar #form-email').focus();
            $('#msgDanger').show().html('Digite o Email!!');
            return false;
        }
        if($('#form-cadastrar #form-fullname').val() == '' || $('#form-cadastrar #form-fullname').val() == null) {
            $('#msgDanger').show().html('Digite o Nome Completo!!');
            $('#form-cadastrar #form-fullname').focus();
            return false;
        }
        if($('#form-cadastrar #form-user').val() == '' || $('#form-cadastrar #form-user').val() == null) {
            $('#msgDanger').show().html('Digite o Usuario!!');
            $('#form-cadastrar #form-user').focus();
            return false;
        }
        if($('#form-cadastrar #form-password').val() == '' || $('#form-cadastrar #form-password').val() == null) {
            $('#msgDanger').show().html('Digite o Senha Corretamente!!');
            $('#form-cadastrar #form-password').focus();
            return false;
        }
        if($('#form-cadastrar #form-password').val().length < 6) {
            $('#msgDanger').show().html('Digite uma senha de no mínimo 6 digitos!!');
            $('#form-cadastrar #form-password').focus();
            return false;
        }
        
        var dados = {
            email: $('#form-cadastrar #form-email').val(),
            fullname:$('#form-cadastrar #form-fullname').val(),
            username:$('#form-cadastrar #form-user').val(),
            password:$('#form-cadastrar #form-password').val(),
        };
        
        $('#loadspin').html('<img src="img/ajax_load.gif">');
        $.ajax({
            url:"interacoes/Iusuario.php",
            type: 'POST',
            dataType: "json",
            contentType: 'application/json',
            data: JSON.stringify(dados),
            success: function(data){
                if(data.tipo == 'success') {
                    $('#divLogin').show();
                    $('#divCad').hide();
                    $('#msgDanger').hide().html('');
                    $('#msgSucess').show().html(data.msg);
                }else if(data.tipo == 'error'){
                    $('#msgDanger').show().html(data.msg);
                    $('#loadspin').html('');
                }
            },
            error: function(data, error, xhr){
                $('#loadspin').html('');
            }
        });
    $('#loadspin').html('');
    });
});
</script>
</html>
<?php } 

function getPerfil($user){
    include_once $_SERVER['DOCUMENT_ROOT'].'/controller/Cusuario.php';
    $usuario = new Cusuario();
    $usuario->getUsuarioPerfil($user);
    
    
?>

<!doctype html>

<html lang="pt-br">
<head>
<meta charset="utf-8"/>
<title>MyTest</title>
    <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <?php include_once $_SERVER['DOCUMENT_ROOT'].'/interacoes/Iautenticacao.php'; ?>

</head>
<body>
    <div class="container" >    
        <div id="divLogin" style="margin-top:50px;" class="col-md-6 col-lg-6">                    
            <div class="panel panel-info" >
                <div class="panel-heading">
                    <div>Perfil de <?php echo $usuario->getUsuario(); ?></div>
                </div>     
                <div  class="panel-body" >
                    <div class="col-md-12 col-lg-12">
                        <div class="col-md-7 col-lg-7">
                            <img style="padding: 20px;" src="<?php echo "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $usuario->getEmail() ) ) ) . "?s=80"; ?>" />
                        </div>
                    </div>
                    <br/>
                    <div class="col-md-12 col-lg-12">
                        <label class="col-md-5 col-lg-5 control-label">Nome Completo</label>
                        <div class="col-md-7 col-lg-7">
                            <?php echo $usuario->getNomeCompleto(); ?>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-12">
                        <label class="col-md-5 col-lg-5 control-label">Email</label>
                        <div class="col-md-7 col-lg-7">
                            <?php echo $usuario->getEmail(); ?>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-12">
                        <div class="col-md-12 col-lg-12">
                            <a href="http://jucelio.pe.hu/interacoes/logoff.php">Sair</a>
                        </div>
                    </div>
                </div>                     
            </div>  
        </div>
    </div>
</body>
</html>
<?php } ?>