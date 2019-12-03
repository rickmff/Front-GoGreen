<?php
if($_POST['session']!=''){
	session_id($_POST['session']);
}
session_start();

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Content-type: text/html; charset=utf-8');

require 'auth.inc.php';
require 'classes/phpmailer/class.phpmailer.php';

$num_ip= $_SERVER['REMOTE_ADDR'];
$date_time= date("Y-m-d H:i:s");
$act = $_REQUEST['act'];
$session = $_REQUEST['session'];
switch ($act) {
	// ===============================================================
	case 'sendHomeSuporte':
	if($_REQUEST['nome']!='' && $_REQUEST['email']!='' && $_REQUEST['telefone']!='' && $_REQUEST['mensagem']!=''){
		$nome = mysql_real_escape_string($_REQUEST['nome']);
		$email = mysql_real_escape_string($_REQUEST['email']);
		$telefone = mysql_real_escape_string($_REQUEST['telefone']);
		$mensagem = nl2br($_REQUEST['mensagem']);
		
		$body = '
			<p>Suporte reportado via CMS por: <strong>'.$config_nomeCliente.'</strong> (Site: '.$config_urlCliente.'),</p>
			<br>
			<p><b>Solicitante:</b> '.$nome.'.</p>
			<p><b>E-mail:</b> '.$email.'.</p>
			<p><b>Telefone:</b> '.$telefone.'.</p>
			<p><b>Site:</b> '.$config_urlCliente.'.</p>
			<p><b>Dúvida Reportada:</b><br>'.$mensagem.'.</p>
			<br>
			<p><em>Este e-mail foi enviado em '.date('d/m/Y',time()).' às '.date('H:i:s',time()).'.</em></p>';
			
		$body = TemaCorpoEmail('SUPORTE REPORTADO', $body);

		$destinatario = 'suporte@agenciakombi.com.br';

		$mail = new PHPMailer();
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
		$mail->CharSet = 'utf-8';
		$mail->From = $configSMTP_host; // Seu e-mail
		$mail->FromName = $nome; // Seu nome
		$mail->AddReplyTo($email);
		$mail->AddAddress($destinatario);
		$mail->IsHTML(true); // Define que o e-mail será enviado como HTML
		$mail->Subject  = 'Suporte Reportado via CMS - Cliente '.$config_nomeCliente; // Assunto da mensagem
		$mail->Body = $body;
		$enviado = $mail->Send();
		 
		// Limpa os destinatários e os anexos
		$mail->ClearAllRecipients();
		$mail->ClearAttachments();

		if($enviado){
			echo 'sucesso';
		} else {
			echo 'Erro: '. $mail->ErrorInfo;
		}
	} else {
		echo 'Erro: Preencha os campos obrigatórios';
	}
	break;
	// ===============================================================
	case 'sendHomeIndique':
	if($_REQUEST['nome']!='' && $_REQUEST['email']!='' && $_REQUEST['nome_indicado']!='' && $_REQUEST['email_indicado']!=''){
		$nome = mysql_real_escape_string($_REQUEST['nome']);
		$email = mysql_real_escape_string($_REQUEST['email']);
		$nome_indicado = mysql_real_escape_string($_REQUEST['nome_indicado']);
		$email_indicado = mysql_real_escape_string($_REQUEST['email_indicado']);
		
		$body = '
			<p>Olá <strong>'.$nome_indicado.'</strong>, </p>
			<br>
			<p>'.$nome.' da empresa '.$config_nomeCliente.', recomendou a <a href="https://www.agenciakombi.com.br" target="_blank">Agência Kombi</a> para te ajudar com soluções em marketing digital, seguem abaixo os dados de contato.</p>
			<br>
			<p>Kombi Agência Digital<br>
			(15) 3318-5300<br>
			<a href="mailto:comercial@agenciakombi.com.br">comercial@agenciakombi.com.br</a><br>
			<a href="http://www.agenciakombi.com.br" target="_blank">agenciakombi.com.br</a><br>
			<a href="https://facebook.com/kombiagencia" target="_blank">fb.com/kombiagencia</a></p>
			<br>
			<p><em>Este e-mail foi enviado em '.date('d/m/Y',time()).' às '.date('H:i:s',time()).'.</em></p>';
			
		$body = TemaCorpoEmail(mb_convert_case($nome, MB_CASE_UPPER, $encoding).' RECOMENDOU A KOMBI AGÊNCIA DIGITAL', $body);

		$destinatario = $email_indicado;

		$mail = new PHPMailer();
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
		$mail->CharSet = 'utf-8';
		$mail->From = $configSMTP_host; // Seu e-mail
		$mail->FromName = $nome; // Seu nome
		$mail->AddReplyTo($email);
		$mail->AddAddress($email_indicado);
			$mail->AddCC($email);
			$mail->AddCC('comercial@agenciakombi.com.br');			
		$mail->IsHTML(true); // Define que o e-mail será enviado como HTML
		$mail->Subject  = $nome.' recomendou a Kombi Agência Digital'; // Assunto da mensagem
		$mail->Body = $body;
		$enviado = $mail->Send();
		 
		// Limpa os destinatários e os anexos
		$mail->ClearAllRecipients();
		$mail->ClearAttachments();

		if($enviado){
			echo 'sucesso';
		} else {
			echo 'Erro: '. $mail->ErrorInfo;
		}
	} else {
		echo 'Erro: Preencha os campos obrigatórios';
	}
	break;
	// ===============================================================
	case 'getContentDica':
	$ref_dica = mysql_real_escape_string($_REQUEST['ref_dica']);
	$arrRetorno = array();
	
	$feedUrl = "http://agenciakombi.com.br/apicms/getCmsDicas.php";
	$curl = curl_init($feedUrl);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$feedContent = curl_exec($curl);
	curl_close($curl);
	
	if($feedContent && !empty($feedContent)){
		$feedDicas = true;
		$feedXml = @simplexml_load_string($feedContent);
		
		foreach($feedXml->channel->item as $item){
			
			if($item->title == $ref_dica){
				$arrRetorno['data_dica'] = strftime("%d/%m/%Y", strtotime($item->pubDate));
				$arrRetorno['txt_dica'] = str_replace(array('<\![CDATA[',']]>'), '', $item->description);

			}
                
        }
				
	}
    
    echo json_encode($arrRetorno);

	
	break;
	// ===============================================================
	
	
	case 'sendSuporte':
	if($_REQUEST['nome']!='' && $_REQUEST['email']!='' && $_REQUEST['telefone']!='' & $_REQUEST['duvida']!=''){
		
		$email = mysql_real_escape_string($_REQUEST['email']);
		$telefone = mysql_real_escape_string($_REQUEST['telefone']);
		$duvida = nl2br($_REQUEST['duvida']);
		
		$body = '<style type="text/css">
			p{font-size:12px; font-family:Tahoma; margin:0px; padding:0px;}
			a{font-size:11px; color:#999; text-decoration:none}a:hover{font-size:11px; color:#333; text-decoration:underline}

			</style>
			<p>Pedido de Orçamento para locação de <b>'.$referente.'</b>, recebido através do site '.$config_nomeCliente.'</p><br>
			<p>
				<strong>Nome:</strong> '.$nome.'<br>
				<strong>E-mail:</strong> '.$email.'<br>
				<strong>Telefone:</strong> '.$telefone.'<br>
				<strong>Empresa:</strong> '.$empresa.'<br>
			</p>
			<p><br></p>
			<p><b>Mensagem Recebida:</b><br>'.$mensagem.'</p>
			<br>
			<hr /><p>Responda a mensagem o mais breve possível.<br /></p><br /><br />		
			';

		$destinatario = 'michel@moviter.com.br';
		$add_copia = 'renato@moviter.com.br; pamela@moviter.com.br; rh@comingersoll.com.br';
		
		$mail = new PHPMailer();
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
		$mail->CharSet = 'utf-8';
		$mail->From = $configSMTP_host; // Seu e-mail
		$mail->FromName = $nome; // Seu nome
		$mail->AddReplyTo($email);
		$mail->AddAddress($destinatario);
			$addr = explode(';',$add_copia);
			foreach ($addr as $ad) {
				if(trim($ad)!=''){$mail->AddAddress( trim($ad) ); }
			}//$mail->AddBCC('fulano@dominio.com.br', 'Fulano da Silva'); // Cópia Oculta
		$mail->IsHTML(true); // Define que o e-mail será enviado como HTML
		$mail->Subject  = 'Mensagem recebida pelo site '.$config_nomeCliente; // Assunto da mensagem
		$mail->Body = $body;
		$enviado = $mail->Send();
		 
		// Limpa os destinatários e os anexos
		$mail->ClearAllRecipients();
		$mail->ClearAttachments();

		if($enviado){
			GravaMailing($email, $nome, $telefone, '', 'Orçcamento Locação', $referente, $mensagem);	
			echo 'sucesso';
		} else {
			echo 'Erro: '. $mail->ErrorInfo;
		}
	}
	break;
	// ===============================================================
	case 'sendOrctoVenda':
	if($_REQUEST['nome']!='' && $_REQUEST['email']!='' && $_REQUEST['telefone']!=''){
		$nome = mysql_real_escape_string($_REQUEST['nome']);
		$email = mysql_real_escape_string($_REQUEST['email']);
		$telefone = mysql_real_escape_string($_REQUEST['telefone']);
		$empresa = mysql_real_escape_string($_REQUEST['empresa']);
		$referente = mysql_real_escape_string($_REQUEST['referente']);
		$mensagem = $_REQUEST['mensagem'];
		
		$body = '<style type="text/css">
			p{font-size:12px; font-family:Tahoma; margin:0px; padding:0px;}
			a{font-size:11px; color:#999; text-decoration:none}a:hover{font-size:11px; color:#333; text-decoration:underline}

			</style>
			<p>Proposta para compra do equipamento <b>'.$referente.'</b>, recebida através do site '.$config_nomeCliente.'</p><br>
			<p>
				<strong>Nome:</strong> '.$nome.'<br>
				<strong>E-mail:</strong> '.$email.'<br>
				<strong>Telefone:</strong> '.$telefone.'<br>
				<strong>Empresa:</strong> '.$empresa.'<br>
			</p>
			<p><br></p>
			<p><b>Mensagem Recebida:</b><br>'.$mensagem.'</p>
			<br>
			<hr /><p>Responda a mensagem o mais breve possível.<br /></p><br /><br />		
			';

		$destinatario = 'michel@moviter.com.br';
		$add_copia = 'renato@moviter.com.br; pamela@moviter.com.br; rh@comingersoll.com.br';

		$mail = new PHPMailer();
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
		$mail->CharSet = 'utf-8';
		$mail->From = $configSMTP_host; // Seu e-mail
		$mail->FromName = $nome; // Seu nome
		$mail->AddReplyTo($email);
		$mail->AddAddress($destinatario);
			$addr = explode(';',$add_copia);
			foreach ($addr as $ad) {
				if(trim($ad)!=''){$mail->AddAddress( trim($ad) ); }
			}//$mail->AddBCC('fulano@dominio.com.br', 'Fulano da Silva'); // Cópia Oculta
		$mail->IsHTML(true); // Define que o e-mail será enviado como HTML
		$mail->Subject  = 'Mensagem recebida pelo site '.$config_nomeCliente; // Assunto da mensagem
		$mail->Body = $body;
		$enviado = $mail->Send();
		 
		// Limpa os destinatários e os anexos
		$mail->ClearAllRecipients();
		$mail->ClearAttachments();

		if($enviado){
			GravaMailing($email, $nome, $telefone, '', 'Orçcamento Venda', $referente, $mensagem);	
			echo 'sucesso';
		} else {
			echo 'Erro: '. $mail->ErrorInfo;
		}
	}
	break;
	// ===============================================================
}
?>