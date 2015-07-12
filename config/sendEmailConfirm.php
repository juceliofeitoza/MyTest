<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/config/mandrill/src/Mandrill.php';

function  sendEmailConfirm($email,$nome,$codConfirm) {
    try {
        $mandrill = new Mandrill('oqVLuqHktMvZa48TtvwR7g');
        $message = array(
            'html' => '<p> Olá <b>'.$nome.' </b>, Para Ativar Sua conta acesse: <a href=\'http://jucelio.pe.hu/index.php?auth='.$codConfirm.'\'>http://jucelio.pe.hu/index.php?auth='.$codConfirm.'</a></p>',
            'text' => 'Ativação',
            'subject' => 'Ative Sua Conta - Mytest',
            'from_email' => 'juceliofeitoza@gmail.com',
            'from_name' => $nome,
            'to' => array(
                array(
                    'email' => $email,
                    'name' => $nome,
                    'type' => 'to'
                )
            ),
            'headers' => array('Reply-To' => $email),
            'important' => false,
            'track_opens' => null,
            'track_clicks' => null,
            'auto_text' => null,
            'auto_html' => null,
            'inline_css' => null,
            'url_strip_qs' => null,
            'preserve_recipients' => null,
            'view_content_link' => null,
            'bcc_address' => 'message.bcc_address@example.com',
            'tracking_domain' => null,
            'signing_domain' => null,
            'return_path_domain' => null,
            'merge' => true,
            'merge_language' => 'mailchimp',
            'global_merge_vars' => array(
                array(
                    'name' => 'merge1',
                    'content' => 'merge1 content'
                )
            ),
            'merge_vars' => array(
                array(
                    'rcpt' => 'recipient.email@example.com',
                    'vars' => array(
                        array(
                            'name' => 'merge2',
                            'content' => 'merge2 content'
                        )
                    )
                )
            )
        );
        $async = false;
        $ip_pool = 'Main Pool';
        $send_at = 'example send_at';
        $result = $mandrill->messages->send($message, $async, $ip_pool);
        //print_r($result);
        
        /*
        Array
        (
            [0] => Array
                (
                    [email] => recipient.email@example.com
                    [status] => sent
                    [reject_reason] => hard-bounce
                    [_id] => abc123abc123abc123abc123abc123
                )

        )
        */
    } catch(Mandrill_Error $e) {
        // Mandrill errors are thrown as exceptions
        echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
        // A mandrill error occurred: Mandrill_Unknown_Subaccount - No subaccount exists with the id 'customer-123'
        throw $e;
    }
    return $result;
}

function validaEmail($email) {
    $regex = "^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$"; 
    if ( preg_match( $regex, $email ) ) {
        return true;
    } else {
        return false;
    } 

}

