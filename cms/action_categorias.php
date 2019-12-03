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
	case 'CadastraCat':
		ValidaVazio($nome,'Preencha o campo "Nome".');
		$nome = gravaChar($nome);
		$desc = gravaChar($desc);
		$slug = cleanString($nome);
		if (count($_SESSION['Erros']) == 0) {
			mysql_query("INSERT INTO site_tb_categorias VALUES (null,'".$nome."','".$desc."','".$slug."','".$ord."')");
			Info('Categoria cadastrada com sucesso.');
			Go($config_prCliente.'categorias');
		} else {
			Go($config_prCliente.'categorias');
		}
	break;
	case 'AlteraCat':
		ValidaID($id_cat,'id_cat','site_tb_categorias','');
		ValidaVazio($nome,'Preencha o campo "Nome".');
		$nome = gravaChar($nome);
		$desc = gravaChar($desc);
		$slug = cleanString($nome);
		if (count($_SESSION['Erros']) == 0) {
			mysql_query("UPDATE site_tb_categorias SET nome_cat='".$nome."', desc_cat='".$desc."', slug_cat='".$slug."', ord_cat='".$ord."' WHERE id_cat = '".$id_cat."'");
			Info('Categoria alterada com sucesso.');
			Go($config_prCliente.'categorias');
		} else {
			Go($config_prCliente.'categorias');
		}
	break;
	case 'ExcluiCat':
		ValidaID($id_cat,'id_cat','site_tb_categorias','');
		if (count($_SESSION['Erros']) == 0) {
			mysql_query("DELETE FROM site_tb_categorias WHERE id_cat = '".$id_cat."'");
			Info('Categoria excluída com sucesso.');
			Go($config_prCliente.'categorias');
		} else {
			Go($config_prCliente.'categorias');
		}
	break;
	// ===============================================================
	}

?>