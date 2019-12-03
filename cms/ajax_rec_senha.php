<?php
session_start();

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Content-type: text/html; charset=utf-8');

include 'config/config.php';

require 'classes/class.conndatabase.php';
require 'classes/functions.php';
require 'classes/phpmailer/class.phpmailer.php';

$stamp = time();
$num_ip= $_SERVER['REMOTE_ADDR'];
$date_time= date("Y-m-d H:i:s");
$act = $_REQUEST['act'];
$session = $_REQUEST['session'];
switch ($act) {
	// ===============================================================
	case 'RecSenha':
	if($_REQUEST['login_email']!=''){
		$login_email = mysql_real_escape_string($_REQUEST['login_email']);
		$ip_usuario = mysql_real_escape_string($_REQUEST['ip_solicitante']);
		
		if(filter_var($login_email, FILTER_VALIDATE_EMAIL)) {
			$whereClaus = "adm_email = '".$login_email."'";
		}else {
			$whereClaus = "adm_login = '".$login_email."'";
		}
	
		$res = mysql_query("SELECT * FROM site_tb_admins WHERE ".$whereClaus);
		$row = mysql_fetch_array($res);

		if($row['adm_login']==$login_email || $row['adm_email']==$login_email ){
			$newpass = RandomPass(8);
			$body = '
				<p>Olá <strong>'.$row['adm_nome'].'</strong> (Login: '.$row['adm_login'].'),</p>
				<br>
				<p>Você solicitou uma recuperação de senha para acessar o CMS '.$config_nomeCliente.'.</p>
				<p>Sua nova senha é <b>'.$newpass.'</b></p>
				<p>Faça o <a href="'.$config_urlCmsCliente.'">login</a> e altere para uma senha de sua preferência.</p>
				<p>IP do solcitante: '.$ip_usuario.'
				<br>Essa é uma mensagem automática, não responda.</p>';
				
			$body = TemaCorpoEmail('RECUPERAÇÃO DE SENHA', $body);
			
			$destinatario = $row['adm_email'];
			$mail = new PHPMailer();
			$mail->IsSMTP();
			if($configSMTP_host!='' && $configSMTP_usuario !='' && $configSMTP_senha!=''){
			$mail->Host = $configSMTP_host;
			$mail->Username = $configSMTP_usuario;
			$mail->Password = $configSMTP_senha;
			$mail->SMTPAuth = true;
			$mail->Port = 587;
			$mail->Sender = $configSMTP_usuario; // Seu e-mail
			} else {
			$mail->SMTPAuth = false;
			}
			$mail->CharSet = "utf-8";
			$mail->From = $destinatario;
			$mail->AddReplyTo($destinatario);
			$mail->FromName = "CMS ".$config_nomeCliente;
			$mail->Body = $body;
			$mail->Subject = 'Recuperar Senha CMS - '.$config_nomeCliente;
			$mail->IsHTML(true);
			$mail->AddAddress($destinatario);
			if ($mail->Send()) {	
				mysql_query("UPDATE site_tb_admins SET adm_senha = '".md5($newpass)."' WHERE adm_id = '".$row['adm_id']."'");
				echo 'Uma nova senha foi enviada para o e-mail '.secret_mail($row['adm_email']).'.';
			} else {
				echo 'Houve um erro ao enviar a nova senha para o e-mail '.secret_mail($row['adm_email']).' ( Erro: '. $mail->ErrorInfo.')';
			}
			$mail->ClearAllRecipients();
			$mail->ClearAttachments();
		} else {
			echo 'Cadastro não encontrado';

		}
	}
	break;
	// ===============================================================
}
?>