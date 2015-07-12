<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/controller/ControllerAutenticacao.php';
/* 
 * Arquivo para controle de ativaçãoe sessão de login.
 * 
 * @autor Jucelio
 */

if(isset($_REQUEST['auth'])) {
    
    $auth = $_REQUEST['auth'];
    
    $objAutentica = new ControllerAutenticacao($auth);
    
    if($objAutentica->getAuth()) {
        $msg = 'Conta Ativada com Sucesso!! <br/> Faça login para acessar seu perfil';
        ?>
        
        <script type="text/javascript">
            $(document).ready(function(){
                $('#msgSucess').show().html('<?php echo $msg; ?>');
            });
        </script>

        <?php
        
    } else {
        $msg = 'Error: Auteticação invalida!';
        ?>
        <script type="text/javascript">
            $(document).ready(function(){
                $('#msgDangerLogin').show().html('<?php echo $msg; ?>');
            });
        </script>
        <?php        
    }
}
?>