<?
session_start();
include 'cms/config/config.php';
require 'cms/classes/class.conndatabase.php';
require 'cms/classes/functions.php';

include('cms/classes/phpmailer/class.phpmailer.php');

if($_POST['nome'] && $_POST['email'] && $_POST['mensagem']){	
	for ($i=0;$i<count($_POST);$i++) {
		$var = key($_POST);
		$$var = trim($_POST[key($_POST)]);
		next($_POST);
	}
	
	$destino = 'suporte@agenciakombi.com.br';
	
	$body = "<style type=\"text/css\">
		h2 { font:bold 14px Arial; }
		p { font:12px Arial; }	
		</style>
		<h2>Contato enviado pelo site ".$config_nomeCliente."</u></b></h2>
		
		<p>
		<b>Nome: </b>".$_POST['nome']."<br />
		<b>E-mail: </b><a href=\"mailto:".$_POST['email']."\">".$_POST['email']."</a><br />
		<b>Telefone: </b>".$_POST['telefone']."<br />
		<b>Mensagem: </b>".$_POST['mensagem']."<br />
		</p>
		<p><em>Este e-mail foi enviado em ".date('d/m/Y',time())." às ".date('H:i:s',time()).".</em></p>";
		
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
	$mail->From = $_POST['email'];
	$mail->AddReplyTo($_POST['email'],$_POST['nome']);
	$mail->FromName = $_POST['nome'];
	$mail->Body = $body;
	$mail->Subject = "Contato enviado pelo site ".$config_nomeCliente;
	$mail->IsHTML(true);
	$mail->AddAddress($destino);
	if ($mail->Send()) {	
		$sucesso = 's';
		GravaMailing($_POST['email'], $_POST['nome'], $_POST['telefone'], '', 'FaleConosco', '', $_POST['mensagem']);	

	} else {
		$sucesso = 'n';
	}
    
} ?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" itemscope itemtype="http://schema.org/WebPage"> <!--<![endif]-->
<head>
    <? include('includes/metas.php');?>
    
    <? include('includes/css.php');?>
    
    <script src="js/formata_campo.js"></script>
</head>

<body>

<? if($sucesso == 's'){ ?>
<div class="overlay">
    <div class="msg">
		<span><?=$nome ?></span><br>
        SUA MENSAGEM FOI ENVIADA COM SUCESSO!<br>
		<span class="fechar">FECHAR</span>
    </div>
</div>
<? } if($sucesso == 'n'){ ?> 
<div class="overlay">
    <div class="msg">
        OCORREU ALGUM ERRO NO ENVIO DA SUA MENSAGEM<br>
        <?=$mail->ErrorInfo?><br>
        favor entrar em contato via telefone
    </div>
</div>
<? } ?>

<? include('includes/header.php');?>

<script>
	function validaForm(){

		d = document.formulario;
		
		//validar nome
		if (d.nome.value == ""){
			alert("O campo Nome deve ser preenchido!");
			d.nome.focus();
			return false;
		}
		
		
		//validar email
		if (d.email.value == ""){			
			alert("O campo E-mail deve ser preenchido!");
			d.email.focus();
			return false;
		} else {
            var email = d.email.value;
			var exclude=/[^@\-\.\w]|^[_@\.\-]|[\._\-]{2}|[@\.]{2}|(@)[^@]*\1/;
    		var check=/@[\w\-]+\./;
    		var checkend=/\.[a-zA-Z]{2,3}$/;
    		if(((email.search(exclude) != -1)||(email.search(check)) == -1)||(email.search(checkend) == -1)){
				alert("O campo E-mail deve ser um endereço válido!");
				d.email.focus();
				return false;
			} 
		
		}
		
		//validar telefone
		if (d.telefone.value == ""){
			alert("O campo Telefone deve ser preenchido!");
			d.telefone.focus();
			return false;
		}
		
		//validar mensagem
		if (d.mensagem.value == ""){
			alert("O campo Mensagem deve ser preenchido!");
			d.mensagem.focus();
			return false;
		}		
		
	}
</script>


<div class="page fale-conosco"> <!--Elemento de formatação-->

    <div class="container">
        <div class="row">
            
            <div class="col-md-12">
                <h1>Fale Conosco</h1>
             </div>
             
			<div class="col-md-6">      
                <form class="formulario" name="formulario" id="formulario" action="" method="post" onSubmit="return validaForm()">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Nome</label>
                            <input required type="text" name="nome" id="nome" class="form-control">
                        </div>
                        <div class="form-group col-md-12">
                            <label>E-Mail</label>
                            <input required type="email" name="email" id="email" class="form-control">
                        </div>
                        <div class="form-group col-md-12">
                            <label>Telefone</label>
                            <input required type="text" name="telefone" id="telefone" onKeyPress="return txtBoxFormat(this, '(99)99999-9999', event);" maxlength="16" class="form-control">
                        </div>
                        <div class="form-group col-md-12">
                        <label>Mensagem</label>
                        <textarea required name="mensagem" id="mensagem" rows="5" class="form-control"></textarea>
                        </div>
                        
                        <div class="form-group col-md-12 text-right">
                        <button type="submit" class="btn btn1">Enviar</button>
                        </div>
                    </div>
                    
                </form>
            </div>
    
            <div class="col-md-6 text-right">
    			Rua Comendador Hermelino Matarazzo, 204, Vila Santa Rita - CEP: 18080-000, Sorocaba/SP<br>
				<span class="fone">Tel: (15) 3033.8668</span>
                
                <div class="mapa embed-responsive embed-responsive-16by9">
                <iframe name="mapframe" class="embed-responsive-item" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3659.075281590816!2d-47.45983878502353!3d-23.493797784716428!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94c58aa55e545999%3A0xcd7c4afccd01ce66!2sAg%C3%AAncia+Kombi+Design!5e0!3m2!1spt-BR!2sbr!4v1487678317611" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                </div>
    
                <a class="link_maps" href="https://goo.gl/maps/KZq4Y" target="_blank">Visualizar no Google Maps</a>
            </div>
        </div>
    </div>

</div> <!--Fim do elemento de formatação-->

<? include('includes/footer.php');?>

<? include('includes/js.php');?>

<script>
$(document).ready(function(){
	$(".overlay").click(function(){
		$(this).fadeOut();
	});
});
</script> 

<? include('includes/analytics.php');?>

</body>
</html>