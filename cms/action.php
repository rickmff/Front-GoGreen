<?php
require 'auth.inc.php';
require_once 'classes/wideimage/WideImage.php';
$stamp = time();
$_SESSION['POST'] = $_POST;

for ($i=0;$i<count($_POST);$i++) {
	$var = key($_POST);
	$$var = trim($_POST[key($_POST)]);
	next($_POST);
}

for ($i=0;$i<count($_GET);$i++) {
	$var = key($_GET);
	$$var = trim($_GET[key($_GET)]);
	next($_GET);
}


switch ($do) {
	// ===============================================================
	case 'CadastraAdmin':
		ValidaSenha($senha,$conf);
		ValidaNome($nome);
		ValidaEmail($email);
		ValidaUnico($login,'adm_login','site_tb_admins','Este login já está em uso.');
		$nome = gravaChar($nome);
		$senha = md5($senha);
		if (count($_SESSION['Erros']) == 0) {
			mysql_query("INSERT INTO site_tb_admins VALUES (null,'".$login."','".$senha."','".$nome."','".$email."')");
			Info('Administrador cadastrado com sucesso.');
			Go($config_prCliente.'admins');
		} else {
			Go($config_prCliente.'admins');
		}

	break;
	case 'AlteraAdmin':
		ValidaID($id_admin,'adm_id','site_tb_admins','');
		ValidaNome($nome);
		ValidaEmail($email);
		$nome = gravaChar($nome);
		
		if($_POST['senha']){
			ValidaSenha($senha,$conf);
			$senha = md5($_POST['senha']);
		} else {
			$row = mysql_fetch_array(mysql_query("SELECT * FROM site_tb_admins WHERE adm_id = '".$id_admin."'"));
			$senha = $row['adm_senha'];
		}


		if (count($_SESSION['Erros']) == 0) {
			
			if($_POST['senha']){
				mysql_query("UPDATE site_tb_admins SET adm_nome='".$nome."', adm_senha='".md5($_POST['senha'])."', adm_email='".$email."' WHERE adm_id = '".$id_admin."'");			
			}else{
				mysql_query("UPDATE site_tb_admins SET adm_nome='".$nome."', adm_senha='".$senha."', adm_email='".$email."' WHERE adm_id = '".$id_admin."'");			
			}
			Info('Administrador alterado com sucesso.');
			Go($config_prCliente.'admins');
		} else {
			Go($config_prCliente.'admins');
		}

	break;
	case 'ExcluiAdmin':
		ValidaID($id_admin,'adm_id','site_tb_admins','');
		if (count($_SESSION['Erros']) == 0) {
			mysql_query("DELETE FROM site_tb_admins WHERE adm_id = '".$id_admin."'");
			Info('Administrador excluído com sucesso.');
			Go($config_prCliente.'admins');
		} else {
			Go($config_prCliente.'admins');
		}

	break;

	// ===============================================================
	case 'CadastraDestaque':
		$titulo = gravaChar($titulo);
		$legenda = gravaChar($legenda);
		$link = gravaChar($link);
		$txt_botao = gravaChar($txt_botao);

		$file = $_FILES['arquivo']['tmp_name'];
		$ext = '.'.end(explode('.', $_FILES['arquivo']['name']));
		ValidaImagem($_FILES['arquivo']);
		$caminho = '../uploads/destaques/';
		
		if (count($_SESSION['Erros']) == 0) {
			$fotoNome = '';
			$img = WideImage::loadFromFile($file);
			$width = $config_BannerHomeW; $heigh = $config_BannerHomeH;
			$img = $img->resize($width, $heigh, 'fill')->crop('50% - '.floor($width/2), '50% - '.floor($heigh/2), $width, $heigh);
			$img->saveToFile($caminho.$stamp.$ext);
			$fotoNome = $stamp.$ext;
			
			mysql_query("INSERT INTO site_tb_banner VALUES (null,'$titulo','$legenda','$cor_txt','$txt_botao','$fotoNome','$link','H')");
			Info('Banner cadastrado com sucesso.');
			Go($config_prCliente.'destaques');
		} else {
			Info("Não foi possível enviar o arquivo, tente novamente");
			Go($config_prCliente.'destaques');
		}

	break;
	case 'AlteraDestaque':
		ValidaID($id_banner,'id_banner','site_tb_banner','');
		$titulo = gravaChar($titulo);
		$legenda = gravaChar($legenda);
		$link = gravaChar($link);
		$caminho = '../uploads/destaques/';
		$txt_botao = gravaChar($txt_botao);
		if ($_FILES['arquivo']['name'] != '') {
			$file = $_FILES['arquivo']['tmp_name'];
			$ext = '.'.end(explode('.', $_FILES['arquivo']['name']));
			ValidaImagem($_FILES['arquivo']);
			
		}
		if (count($_SESSION['Erros']) == 0) {
			
			$row = mysql_fetch_array(mysql_query("SELECT * FROM site_tb_banner WHERE id_banner = $id_banner"));
			$fotoNome = $row['url_banner'];
			if ($_FILES['arquivo']['name'] != '') {
					
					unlink($caminho.$fotoNome);
					unlink($caminho.'thumb_'.$fotoNome);
				
					$img = WideImage::loadFromFile($file);
					$width = $config_BannerHomeW; $heigh = $config_BannerHomeH;
					$img = $img->resize($width, $heigh, 'fill')->crop('50% - '.floor($width/2), '50% - '.floor($heigh/2), $width, $heigh);
					$img->saveToFile($caminho.$stamp.$ext);
					$fotoNome = $stamp.$ext;
				
			}
			mysql_query("UPDATE site_tb_banner SET tit_banner='".$titulo."', leg_banner='".$legenda."', cor_banner='".$cor_txt."', txtBtn_banner='".$txt_botao."', url_banner='".$fotoNome."', link_banner='".$link."'  WHERE id_banner = $id_banner");
			Info('Banner alterado com sucesso.');
			Go($config_prCliente.'destaque&id_banner='.$id_banner);
		} else {	
			Info("Não foi possível enviar o arquivo, tente novamente");
			Go($config_prCliente.'destaque&id_banner='.$id_banner);
		}
	break;
	case 'ExcluiDestaque':
		ValidaID($id_banner,'id_banner','site_tb_banner','');
		if (count($_SESSION['Erros']) == 0) {
			$res = mysql_query("SELECT * FROM site_tb_banner WHERE id_banner = $id_banner");
			if(mysql_num_rows($res)){
				while($row = mysql_fetch_array($res)) {
					unlink('../uploads/destaques/'.$row['url_banner']);
				}
			}
			mysql_query("DELETE FROM site_tb_banner WHERE id_banner = $id_banner");
			Info('Banner excluído com sucesso.');
			Go($config_prCliente.'destaques');
		} else {
			Go($config_prCliente.'destaques');
		}
	break;
	// ===============================================================

	
	

	}

?>