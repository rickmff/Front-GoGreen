<?php
session_start();
setcookie("ck_authorized", "true", 0, "/");

include 'config/config.php';

require 'classes/class.conndatabase.php';
require 'classes/functions.php';

if (isset($_SESSION['Auth'])) {
	$login = $_SESSION['Auth']['Login'];
	$id = $_SESSION['Auth']['ID'];
	$name_user = $_SESSION['Auth']['Nome'];
	$auth_res = mysql_query("SELECT * FROM site_tb_admins WHERE adm_login = '$login' AND adm_id = $id");
	mysql_num_rows($auth_res) ? $auth = true : $auth = false;
}

if (!$auth) {

	Erro('Área restrita. Faça o login.');
	Go($config_urlCmsCliente.'login.php');
	exit;

}
?>