<?
if($_POST['session']!=''){
	session_id($_POST['session']);
}
session_start();

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Content-type: text/html; charset=utf-8');

include 'cms/config/config.php';
require 'cms/classes/class.conndatabase.php';
require 'cms/classes/functions.php';

if (ereg("^([0-9,a-z,A-Z]+)([.,_]([0-9,a-z,A-Z]+))*[@]([0-9,a-z,A-Z]+)([.,_,-]([0-9,a-z,A-Z]+))*[.]([0-9,a-z,A-Z]){2}([0-9,a-z,A-Z])?$",$_REQUEST['email'])) {
	$res = mysql_query("SELECT * FROM site_tb_emails WHERE canal_captado = 'Newsletter' AND end_email = '".$_REQUEST['email']."'");
	if(!mysql_num_rows($res)){
		GravaMailing($_REQUEST['email'], $_REQUEST['nome'], '', '', 'Newsletter', '', '');	
		echo 'Seu e-mail foi cadastrado com sucesso!';
	} else {
		$row = mysql_fetch_array($row);
		
		if($row['aceita']=='1'){
			mysql_query("UPDATE site_tb_emails SET aceita = '0' WHERE canal_captado = 'Newsletter' AND id_email = '".$row['id_email']."'");
			echo 'Seu e-mail foi cadastrado com sucesso!';
		} else {
			echo 'Seu e-mail já encontra-se cadastrado!';
		}
		
		
	}
} else {
	echo 'E-mail inválido!';
}
?>