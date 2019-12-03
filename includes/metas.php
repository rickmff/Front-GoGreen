<? function page() {
	return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
}
$cur_page = page();

#####################################################################################
###################      CONFIGURAÇÃO DAS TAGS PADRÕES     ##########################
#####################################################################################


$Header_Title = 'Site '.$config_nomeCliente; // Titulo da página. Recomendado de 60 a 70 caracteres. Regra: ser único
$Header_Description = 'Descrição Empresa'; // Descrição da página. Tente não ultrapassar 155 caracteres

$Header_Keywords = 'palavras, chaves'; // Utilizar poucas palavras 

$Header_CharSet = 'utf-8';
$Header_Schema = 'WebPage'; 
// WebPage, AboutPage, ContactPage, SearchResultsPage, ItemPage, Article, Event, ImageGallery, VideoGallery
// Veja o adequado em http://schema.org/docs/full.html

$Header_PlaceLati = ''; // Ex: 13.062616
$Header_PlaceLong = ''; // Ex: 80.229508
// Consulte Latitude/Longitude em http://itouchmap.com/latlong.html

$Header_NomeEmpresa = ''; // Ex: Agência Kombi
$Header_SloganEmpresa = ''; // Ex: Agência de Web e Design Gráfico
$Header_Endereco = ''; // Ex: Rua Comendador Hermelino Matarazzo, 204, Vila Santa Rita
$Header_Cidade = ''; // Ex: Sorocaba
$Header_UF = ''; // Ex: SP
$Header_CEP = ''; //  18080-000
$Header_Pais = 'Brasil';
$Header_Email = ''; // Ex: contato@kombidesig.com.br
$Header_Telefone = ''; // Ex: (15)3318-5300
$Header_Site = $config_urlCliente; // Ex: http://www.agenciakombi.com.br
$Header_BaseURL = $config_urlCliente; // Ex: http://www.agenciakombi.com.br/

$Header_Twitter = ''; // Ex: kombidesign
$Header_ImgAvatar = $Header_BaseURL.'assets/images/avatar.jpg'; // Preferencialmente 200px X 200px
$Header_UrlPage = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER ['REQUEST_URI'];

$Header_FaceID = '1453324574936611'; // ID da conta developer do facebook
$Header_FaceType = 'website'; // Veja lista completa em http://ogp.me/#types

$Header_GoogleWebMasterTools = ''; // ID de Verificação do GoogleWebMasterTools
$Header_GoogleMaisPerfil = ''; // Username (ou ID) do Perfil no Google+

#################################################################################################################
################################			FIM CONFIGURAÇÃO DAS TAGS PADRÕES		#############################
#################################################################################################################


#################	CONFIGURAÇÃO DAS TAGS DE CADA PÁGINA	#################
switch($cur_page){
	case 'index.php':
		$Header_Title = $Header_NomeEmpresa.' - '.$Header_SloganEmpresa;
		//$Header_Description = '';
	break;
	
	case 'empresa.php':
		$Header_Title = 'Sobre a '.$Header_NomeEmpresa;
		//$Header_Description = '';
	break;
	
	case 'produtos.php':
		$Header_Title = 'Produtos '.$Header_NomeEmpresa;
		//$Header_Description = '';
	break;
	
	case 'produtos-detalhes.php':
		$rowMT = mysql_fetch_array(mysql_query("SELECT * FROM site_tb_produtos WHERE id_prod = '".$_GET['ref']."'"));
		$rowMT_CAT = mysql_fetch_array(mysql_query("SELECT * FROM site_tb_categorias WHERE id_cat = '".$rowMT['ref_linha']."'"));			
		$Header_Title = $rowMT['nome_prod'].' - '.$Header_NomeEmpresa;
		//$Header_Description = $rowMT['nome_prod'].' &eacute; um produto da linha '.$rowMT_CAT['nome_cat'].'. Saboreie!';
	break;

	case 'categoria.php':
		$rowMT = mysql_fetch_array(mysql_query("SELECT * FROM site_tb_categorias WHERE slug_cat = '".$_GET['slug']."'"));
		$Header_Title = $rowMT['nome_cat'].' - '.$Header_NomeEmpresa;
		$Header_Description = Reduz(strip_tags($rowMT['desc_cat']),50);
	break;

	case 'fale-conosco.php':
		$Header_Title = 'Fale Conosco '.$Header_NomeEmpresa;
		$Header_Description = 'Quer conhecer melhor nossa empresa, entre em contato conosco através do nosso telefone, ou se preferir envie uma mensagem pelo nosso site.';
	break;

}
#################	FIM CONFIGURAÇÃO DAS TAGS DE CADA PÁGINA	#################

?>

<? if($Header_CharSet){?><meta charset="<?=$Header_CharSet?>"><? } ?>

<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<? if($Header_BaseURL){?><base href="<?=$Header_BaseURL?>"><? } ?>
<? if($Header_GoogleWebMasterTools){?><meta name="google-site-verification" content="<?=$Header_GoogleWebMasterTools?>" /><? } ?>
<? if($Header_Keywords){?><meta name="keywords" content="<?=$Header_Keywords?>" /><? } ?>
<meta name="rating" content="general" />
<meta name="classification" content="website" />
<meta name="robots" content="all" />
<meta name="googlebot" content="all" />
<meta name="content-language" content="pt-br" /> <? // Veja mais em https://developer.mozilla.org/pt-PT/docs/utilizando_meta_tags#_Content-language_?>
<meta name="revisit-after" content="10 days" />
<meta name="DC.email" content="<?=$Header_Email?>" />
<meta name="DC.author" content="<?=$Header_NomeEmpresa?>" />
<meta name="DC.publisher" content="<?=$Header_NomeEmpresa?>" />

<title><?=$Header_Title?></title> 
<meta name="description" content="<?=$Header_Description?>" />

<? if($Header_PlaceLati){?><meta property="place:location:latitude" content="<?=$Header_PlaceLati?>"/><? } ?>
<? if($Header_PlaceLong){?><meta property="place:location:longitude" content="<?=$Header_PlaceLong?>"/><? } ?>
<? if($Header_Endereco){?><meta property="business:contact_data:street_address" content="<?=$Header_Endereco?>"/><? } ?>
<? if($Header_Cidade){?><meta property="business:contact_data:locality" content="<?=$Header_Cidade?>"/><? } ?>
<? if($Header_CEP){?><meta property="business:contact_data:postal_code" content="<?=$Header_CEP?>"/><? } ?>
<? if($Header_Pais){?><meta property="business:contact_data:country_name" content="<?=$Header_Pais?>"/><? } ?>
<? if($Header_Email){?><meta property="business:contact_data:email" content="<?=$Header_Email?>"/><? } ?>
<? if($Header_Telefone){?><meta property="business:contact_data:phone_number" content="<?=$Header_Telefone?>"/><? } ?>
<? if($Header_Site){?><meta property="business:contact_data:website" content="<?=$Header_Site?>"/><? } ?>

<meta name="twitter:card" content="summary">
<? if($Header_Twitter){?><meta name="twitter:site" content="@<?=$Header_Twitter?>"><? } ?>
<meta name="twitter:title" content="<?=$Header_Title?>">
<meta name="twitter:description" content="<?=$Header_Description?>">
<? if($Header_ImgAvatar){?><meta name="twitter:image" content="<?=$Header_ImgAvatar?>"><? } ?>

<meta property="og:title" content="<?=$Header_Title?>" />
<? if($Header_FaceType){?><meta property="og:type" content="<?=$Header_FaceType?>" /><? } ?>
<meta property="og:url" content="<?=$Header_UrlPage?>" />
<? if($Header_ImgAvatar){?><meta property="og:image" content="<?=$Header_ImgAvatar?>" /><? } ?>
<meta property="og:description" content="<?=$Header_Description?>" />
<? if($Header_NomeEmpresa){?><meta property="og:site_name" content="<?=$Header_NomeEmpresa?>" /><? } ?>
<? if($Header_FaceID){?><meta property="fb:admins" content="<?=$Header_FaceID?>" /><? } ?>

<? if($Header_GoogleMaisPerfil){?>
<link rel="author" href="https://plus.google.com/<?=$Header_GoogleMaisPerfil?>/posts"/>
<link rel="publisher" href="https://plus.google.com/<?=$Header_GoogleMaisPerfil?>"/>
<? } ?>

<meta itemprop="name" content="<?=$Header_Title?>">
<meta itemprop="description" content="<?=$Header_Description?>">
<? if($Header_ImgAvatar){?><meta itemprop="image" content="<?=$Header_ImgAvatar?>"><? } ?>
