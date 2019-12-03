<?php
session_start();
include 'config/config.php';
require 'classes/class.conndatabase.php';
require 'classes/functions.php';

if ($_POST['submit'] == 'ACESSAR') {
	for ($i=0;$i<count($_POST);$i++) {
		$var = key($_POST);
		$$var = trim($_POST[key($_POST)]);
		next($_POST);
	}
	$query = mysql_query("SELECT * FROM site_tb_admins WHERE adm_login='".$login."' OR adm_senha='".md5($senha)."'");
	if (mysql_num_rows($query)) {
		$user = mysql_fetch_array($query);
		if(($user['adm_login'] == $login) && ($user['adm_senha'] == md5($senha)) ){
			$_SESSION['Auth']['ID'] = $user['adm_id'];
			$_SESSION['Auth']['Login'] = $user['adm_login'];
			$_SESSION['Auth']['Nome'] = $user['adm_nome'];
			$sucesso = 'Sim';
			// -----------RELATÓRIO
			$login = $_POST['login'];
			$num_ip= $_SERVER['REMOTE_ADDR'];
			$date_time= date("Y-m-d H:i:s");						
			mysql_query("INSERT INTO site_tb_log_acesso VALUES ('$date_time','$num_ip','$login','$sucesso')");
			//------------------------
			Go($config_prCliente.'index.php');

		} else {
			Erro('Login ou senha inv&aacute;lidos.');
			$sucesso = 'Nao';
		}
	} else {
		Erro('Login ou senha inv&aacute;lidos .');
		$sucesso = 'Nao';
	}
}
?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> 
<html class="no-js" itemscope="" itemtype="http://schema.org/WebPage"> <!--<![endif]-->
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="utf-8">
<title><?=$config_nomeCliente?> - Área Restrita</title>
<link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,600" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.min.css" type='text/css'>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<style type="text/css">

* {margin:0; padding:0;}
html, body {height:100%;}
#elm_loading{display: flex; align-items: center; justify-content: center; color: #FFF; position:fixed; width:100%; height:100%; background:RGBA(0,84,134,.8); z-index:9999; top:0; line-height:100%; text-align:center}

body {background-color: #<?=$config_corCliente?>; color:#777; font-family: 'Roboto', sans-serif; font-weight:300; display: flex; align-items: center; justify-content: center;}

.wrapper { background: RGBA(0,0,0,.16); border-radius: 3px; overflow: hidden; font-size: 12px; position: relative;}
.logo {max-height:120px;margin-bottom: 20px;}
.logo img {max-width:236px;max-height: 200px;}
.loginbox {padding: 40px;background: #FFF;float: left;height: 100%;display: block;z-index: 1;}
.cmsbox {float: left;padding: 40px;color: #FFF;margin-right: -316px;animation: anima-cmsbox forwards .9s;}
@keyframes anima-cmsbox {
	from {margin-right: -316px;} to {margin-right: 0;}
}
input {display: block;font: 16px 'Raleway';width: calc(100% - 20px);border: none;padding: 10px;border-radius: 4px;background: #CCC;margin-bottom: 10px;min-width: 132px;}

.erros li {list-style-type: none;border: 1px solid #ff6a4a;color: #FFF;background-color: #ff6a4a;border-radius: 4px;padding: 7px;width: calc(100% - 15px);margin-bottom: 15px;text-align: center;}
form {margin-top:5px;}
.btn {border: 1px solid #<?=$config_corCliente?>;background: #<?=$config_corCliente?>;color: #FFF;padding: 10px; cursor: pointer; display: inline-block;
width: 100%;}
.credits {position: absolute;bottom: 10px;width: 50%;text-align: center;left: 0;color: #FFF;text-decoration: none;}
.rec-senha {cursor: pointer; line-height:2em; font-size:1em}
.form-rec-senha .btn {background: #555;border-color:#555;
}

@media screen and (max-width: 640px) {
	.credits {display:none}
	.cmsbox, .loginbox {float: none;}
	.cmsbox {margin-right: 0;animation: anima-cmsbox-vert forwards .8s; width:auto}
	@keyframes anima-cmsbox-vert {from {margin-bottom: -316px;} to {margin-bottom: 0;}}
}  

</style>

<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>

</head>

<body>

    <div class="wrapper">

        <div class="cmsbox">
            <div class="logo">
                <img src="images/logo.png" />
            </div>
            <p align="center"><b>CMS <?=$config_nomeCliente?></b></p>
            <a class="credits" href="http://www.agenciakombi.com.br/?utm_source=cms&utm_campaign=<?=cleanString($config_nomeCliente)?>" target="_blank"> Desenvolvido por Agência Kombi</a>
        </div>

        <div class="loginbox">


            <?php ShowErros(); ?>
            <form action="login.php" method="post">
                <input type="text" name="login" id="login" placeholder="DIGITE SEU LOGIN" />
                <input type="password" name="senha" id="senha" placeholder="SUA SENHA" />
                <input type="submit" value="ACESSAR" name="submit" class="btn" /></form>
            </form>

            <a class="small rec-senha">esqueceu a senha?</a>

            <form style="display: none;" class="form-rec-senha" id="form-rec-senha" action="javascript:" enctype="text/plain" method="post">
                <input type="text" name="rec_email" id="rec_email" required="required" placeholder="Digite seu login ou e-mail" />
                <input type="submit" value="RECUPERAR SENHA" name="submit" class="btn" />
            </form>

        </div>
    </div>

<script>
function getLoading(){
    var montaLoader = '<div id="elm_loading"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i><span class="sr-only">Carregando...</span></div>';
    $('body').prepend(montaLoader).fadeIn();
}

function delLoading(){
    $('#elm_loading').remove();
}

$(document).ready(function(){
	$(".rec-senha").click(function(){
		$(".form-rec-senha").slideToggle();
	});
});
	
$('#form-rec-senha').on('submit',function(e){	
		getLoading();
		if($('#form-rec-senha #rec_email').val()!=''){	
			$.post("./ajax_rec_senha.php?act=RecSenha", { login_email: $('#form-rec-senha #rec_email').val(), ip_solicitante: '<?=$_SERVER['REMOTE_ADDR']?>', session:'<?=session_id()?>'},
				function(result){
					delLoading();
					$('#form-rec-senha #rec_email').val('');
					alert(result)
				}
			);
		} else{
			delLoading();
			alert('Preencha seu login ou e-mail para recuperar a senha!');
		}
});
</script>
    </body>
</html>