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
	case 'CadastraProduto':
		ValidaVazio($nome,'Preencha o campo "Nome".');
		$nome = gravaChar($nome);
		
		if ($_FILES['arquivo']['name'] != '') {
			$file = $_FILES['arquivo']['tmp_name'];
			$ext = '.'.end(explode('.', $_FILES['arquivo']['name']));
			ValidaImagem($_FILES['arquivo']);
			$caminho = '../uploads/produtos/';
		}

		if ($_FILES['logotipo']['name'] != '') {
			$fileLogo = $_FILES['logotipo']['tmp_name'];
			$extLogo = '.'.end(explode('.', $_FILES['logotipo']['name']));
			ValidaImagem($_FILES['logotipo']);
			$caminho = '../uploads/produtos/';
		}

		if (count($_SESSION['Erros']) == 0) {
			$fotoNome = ''; $logoNome = '';
			if ($_FILES['arquivo']['name'] != '') {
				$file = compress_image($file, $file, 80);
				$img = WideImage::loadFromFile($file);
				//---THUMB---
				$width = 200; $height = 150;
				$thumb = $img;
				$thumb = $thumb->resize($width, $height, 'outside')->crop('50% - '.floor($width/2), '50% - '.floor($height/2), $width, $height);
				$thumb->saveToFile($caminho.'thumb_'.$stamp.$ext);
				//----THUMB---		
				//---MEDIA---
				$width = 400; $height = 300;
				$thumb = $img;
				$thumb = $thumb->resize($width, $height, 'outside')->crop('50% - '.floor($width/2), '50% - '.floor($height/2), $width, $height);
				$thumb->saveToFile($caminho.'media_'.$stamp.$ext);
				//----MEDIA---		
				
				$info_imag = getimagesize($file);
				if(($info_imag[0]>'1200')|| ($info_imag[1]>'1200')){
					$img = $img->resize(1200, 1200, 'outside');
				}
				$img->saveToFile($caminho.$stamp.$ext);
				$fotoNome = $stamp.$ext;
			}
			if ($_FILES['logotipo']['name'] != '') {
				$fileLogo = compress_image($fileLogo, $fileLogo, 80);
				$imgLogo = WideImage::loadFromFile($fileLogo);
				$imgLogo->resize(250, 180, 'outside');
				$imgLogo->saveToFile($caminho.'logo_'.$stamp.$ext);
				$logoNome = 'logo_'.$stamp.$ext;
			}

			mysql_query("INSERT INTO site_tb_produtos VALUES (null,'".$nome."','".$categoria."','".$texto."','".$vantagens."','".$fotoNome."','".$logoNome."','".$video."','".$ordem."','0')");
			Info('Produto cadastrado com sucesso.');
			//--------------------
			$temp_query = mysql_query("SELECT * FROM site_tb_produtos ORDER BY id_prod DESC LIMIT 1");
			$temp = mysql_fetch_array($temp_query);
			$id_prod = $temp['id_prod'];
			//---------------------
			Go($config_prCliente.'produto&id_prod='.$id_prod);
		} else {
			Go($config_prCliente.'produto&id_prod='.$id_prod);
		}
	break;
	case 'AlteraProduto':
		ValidaID($id_prod,'id_prod','site_tb_produtos','');
		ValidaVazio($nome,'Preencha o campo "Nome".');
		$nome = gravaChar($nome);
		
		if ($_FILES['arquivo']['name'] != '') {
			$file = $_FILES['arquivo']['tmp_name'];
			$ext = '.'.end(explode('.', $_FILES['arquivo']['name']));
			ValidaImagem($_FILES['arquivo']);
			$caminho = '../uploads/produtos/';
		}

		if ($_FILES['logotipo']['name'] != '') {
			$fileLogo = $_FILES['logotipo']['tmp_name'];
			$extLogo = '.'.end(explode('.', $_FILES['logotipo']['name']));
			ValidaImagem($_FILES['logotipo']);
			$caminho = '../uploads/produtos/';
		}

		if (count($_SESSION['Erros']) == 0) {
			
			$row = mysql_fetch_array(mysql_query("SELECT * FROM site_tb_produtos WHERE id_prod = $id_prod"));
			$fotoNome = $row['thumb_prod']; $logoNome = $row['logo_prod'];
			
			if ($_FILES['arquivo']['name'] != '') {
				unlink($caminho.$fotoNome);
				unlink($caminho.'thumb_'.$fotoNome);
				unlink($caminho.'media_'.$fotoNome);
				$file = compress_image($file, $file, 80);
				$img = WideImage::loadFromFile($file);
				//---THUMB---
				$width = 200; $height = 150;
				$thumb = $img;
				$thumb = $thumb->resize($width, $height, 'outside')->crop('50% - '.floor($width/2), '50% - '.floor($height/2), $width, $height);
				$thumb->saveToFile($caminho.'thumb_'.$stamp.$ext);
				//----THUMB---		
				//---MEDIA---
				$width = 400; $height = 300;
				$thumb = $img;
				$thumb = $thumb->resize($width, $height, 'outside')->crop('50% - '.floor($width/2), '50% - '.floor($height/2), $width, $height);
				$thumb->saveToFile($caminho.'media_'.$stamp.$ext);
				//----MEDIA---		
				
				$info_imag = getimagesize($file);
				if(($info_imag[0]>'1200')|| ($info_imag[1]>'1200')){
					$img = $img->resize(1200, 1200, 'outside');
				}
				$img->saveToFile($caminho.$stamp.$ext);
				$fotoNome = $stamp.$ext;
				
			}
			
			if ($_FILES['logotipo']['name'] != '') {
				unlink($caminho.$logoNome);
				$fileLogo = compress_image($fileLogo, $fileLogo, 80);
				$imgLogo = WideImage::loadFromFile($fileLogo);
				$imgLogo->resize(250, 180, 'outside');
				$imgLogo->saveToFile($caminho.'logo_'.$stamp.$ext);
				$logoNome = 'logo_'.$stamp.$ext;
			}
			
			mysql_query("UPDATE site_tb_produtos SET nome_prod='".$nome."', ref_cat='".$categoria."', texto_prod='".$texto."', vantagens_prod='".$vantagens."', thumb_prod='".$fotoNome."', logo_prod='".$logoNome."', video_prod='".$video."', ord_prod='".$ordem."' WHERE id_prod = $id_prod");
			Info('Produto alterado com sucesso.');
			Go($config_prCliente.'produto&id_prod='.$id_prod);
		} else {
			Go($config_prCliente.'produto&id_prod='.$id_prod);
		}
	break;
	case 'ExcluiProduto':
		ValidaID($id_prod,'id_prod','site_tb_produtos','');
		if (count($_SESSION['Erros']) == 0) {
			$res = mysql_query("SELECT * FROM site_tb_produtos WHERE id_prod = $id_prod");
			if(mysql_num_rows($res)){
				while($row = mysql_fetch_array($res)) {
					unlink('../uploads/produtos/'.$row['thumb_prod']);
					unlink('../uploads/produtos/media_'.$row['thumb_prod']);
					unlink('../uploads/produtos/thumb_'.$row['thumb_prod']);
					unlink('../uploads/produtos/'.$row['logo_prod']);
				}
			}
			$res = mysql_query("SELECT * FROM site_tb_produtos_fotos WHERE ref = $id_prod");
			if(mysql_num_rows($res)){
				while($row = mysql_fetch_array($res)) {
					unlink('../uploads/produtos/'.$row['url_foto']);
					unlink('../uploads/produtos/thumb_'.$row['url_foto']);
				}
			}
			$res = mysql_query("SELECT * FROM site_tb_produtos_downloads WHERE ref = $id_prod");
			if(mysql_num_rows($res)){
				while($row = mysql_fetch_array($res)) {
					unlink('../uploads/downloads/'.$row['file_down']);
				}
			}
			mysql_query("DELETE FROM site_tb_produtos_fotos WHERE ref = $id_prod");
			mysql_query("DELETE FROM site_tb_produtos_downloads WHERE ref = $id_prod");
			mysql_query("DELETE FROM site_tb_produtos WHERE id_prod = $id_prod");
			Info('Produto excluído com sucesso.');
			Go($config_prCliente.'produtos');
		} else {
			Go($config_prCliente.'produtos');
		}
	break;
	
	case 'ApagaFotoProd':
		ValidaID($id_prod,'id_prod','site_tb_produtos','');
		if (count($_SESSION['Erros']) == 0) {
			$res = mysql_query("SELECT * FROM site_tb_produtos WHERE id_prod = $id_prod");
			if(mysql_num_rows($res)){
				while($row = mysql_fetch_array($res)) {
					unlink('../uploads/produtos/'.$row['thumb_prod']);
					unlink('../uploads/produtos/media_'.$row['thumb_prod']);
					unlink('../uploads/produtos/thumb_'.$row['thumb_prod']);
				}
			}
			
			mysql_query("UPDATE site_tb_produtos SET thumb_prod='' WHERE id_prod = $id_prod");
			Info('Foto principal apagada com sucesso.');
			Go($config_prCliente.'produto&id_prod='.$id_prod);
		} else {
			Go($config_prCliente.'produto&id_prod='.$id_prod);
		}
	break;
	case 'ApagaLogoProd':
		ValidaID($id_prod,'id_prod','site_tb_produtos','');
		if (count($_SESSION['Erros']) == 0) {
			$res = mysql_query("SELECT * FROM site_tb_produtos WHERE id_prod = $id_prod");
			if(mysql_num_rows($res)){
				while($row = mysql_fetch_array($res)) {
					unlink('../uploads/produtos/'.$row['logo_prod']);
				}
			}
			
			mysql_query("UPDATE site_tb_produtos SET logo_prod='' WHERE id_prod = $id_prod");
			Info('Logotipo apagado com sucesso.');
			Go($config_prCliente.'produto&id_prod='.$id_prod);
		} else {
			Go($config_prCliente.'produto&id_prod='.$id_prod);
		}
	break;
	// ===============================================================
	case 'CadastraProd_Foto':
		$legenda = gravaChar($legenda);
		
		$file = $_FILES['arquivo']['tmp_name'];
		$ext = '.'.end(explode('.', $_FILES['arquivo']['name']));
			ValidaImagem($_FILES['arquivo']);
		$caminho = '../uploads/produtos/';
		
		if (count($_SESSION['Erros']) == 0) {
				$fotoNome = '';
				$file = compress_image($file, $file, 80);
				$img = WideImage::loadFromFile($file);
				//---THUMB---
				$width = 200; $height = 150;
				$thumb = $img;
				$thumb = $thumb->resize($width, $height, 'outside')->crop('50% - '.floor($width/2), '50% - '.floor($height/2), $width, $height);
					$thumb->saveToFile($caminho.'thumb_'.$stamp.$ext);
					//----THUMB---
				$info_imag = getimagesize($file);
				if(($info_imag[0]>'1200')|| ($info_imag[1]>'1200')){
					$img = $img->resize(1200, 1200, 'outside');
				}
				$img->saveToFile($caminho.$stamp.$ext);
				$fotoNome = $stamp.$ext;

				if (count($_SESSION['Erros']) == 0) {
					mysql_query("INSERT INTO site_tb_produtos_fotos VALUES (null,'".$ref."','".$legenda."','".$fotoNome."','9999')");
					Info('Foto cadastrada com sucesso.');
					Go($config_prCliente.'produto&id_prod='.$ref);
				} else {
					Go($config_prCliente.'produto&id_prod='.$ref);
				}
		} else {
			Go($config_prCliente.'produto&id_prod='.$ref);
		}
	break;
	case 'ExcluiProduto_Foto':
		ValidaID($id_foto,'id_foto','site_tb_produtos_fotos','');
		if (count($_SESSION['Erros']) == 0) {
			$row = mysql_fetch_array(mysql_query("SELECT * FROM site_tb_produtos_fotos WHERE id_foto = $id_foto"));
			unlink('../uploads/produtos/'.$row['url_foto']);
			unlink('../uploads/produtos/thumb_'.$row['url_foto']);
			mysql_query("DELETE FROM site_tb_produtos_fotos WHERE id_foto = $id_foto");
			Info('Foto excluída com sucesso.');
			Go($config_prCliente.'produto&id_prod='.$ref);
		} else {
			Go($config_prCliente.'produto&id_prod='.$ref);
		}
	break;
	// ===============================================================
	case 'OrderProd_Foto':
	if($_POST['ordem']){
		$ordem = $_POST['ordem'];
		for($k=0; $k<count($ordem); $k++){
			$new_ord = $k+1;
			mysql_query("UPDATE site_tb_produtos_fotos SET ord_foto='".$new_ord."' WHERE id_foto = '".$ordem[$k]."'");
		}
	}
	break;
	// ===============================================================
	case 'CadastraProd_Download':
		$legenda = gravaChar($legenda);
		$arquivo = isset($_FILES['arquivo']) ? $_FILES['arquivo'] : FALSE;
		if (count($_SESSION['Erros']) == 0) {
			if($arquivo){
				$filename = str_replace(" ", "_", $arquivo["name"]);
				$filename = ereg_replace("[^a-zA-Z0-9_.]", "", strtr($filename,"áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ ","aaaaeeiooouucAAAAEEIOOOUUC_"));
				$filename = $stamp.'_'.$filename;
				if(file_exists('../uploads/downloads/'.$filename)){
					Info('Esse arquivo já encontra-se cadastrado.');
					Go($config_prCliente.'produto&id_prod='.$ref);
				} else {
					move_uploaded_file($arquivo['tmp_name'], '../uploads/downloads/'.$filename);
					if($legenda==''){$legenda=$filename;}
					mysql_query("INSERT INTO site_tb_produtos_downloads VALUES (null,'".$ref."','".$legenda."','".$filename."')");
					$js="<script language='javascript'>alert('Upload completo!')</script>";
					print $js;
					$js="<script language='javascript'>javascript:history.go(-1)</script>";
					print $js;
				}
			} else {
				Info('Arquivo Inválido.');
				Go($config_prCliente.'produto&id_prod='.$ref);
			}
		} else {
			Go($config_prCliente.'produto&id_prod='.$ref);
		}
	break;
	case 'ExcluiProduto_Download':
		ValidaID($id_down,'id_down','site_tb_produtos_downloads','');
		if (count($_SESSION['Erros']) == 0) {
			$row = mysql_fetch_array(mysql_query("SELECT * FROM site_tb_produtos_downloads WHERE id_down = $id_down"));
			unlink('../uploads/downloads/'.$row['file_down']);
			mysql_query("DELETE FROM site_tb_produtos_downloads WHERE id_down = $id_down");
			Info('Material para Download excluído com sucesso.');
			Go($config_prCliente.'produto&id_prod='.$ref);
		} else {
			Go($config_prCliente.'produto&id_prod='.$ref);
		}
	break;
	// ===============================================================
	}

?>