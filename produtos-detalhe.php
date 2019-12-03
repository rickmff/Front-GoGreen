<?php
session_start();
include 'cms/config/config.php';
require 'cms/classes/class.conndatabase.php';
require 'cms/classes/functions.php';
?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="pt-br" itemscope itemtype="http://schema.org/WebPage"> <!--<![endif]-->
<head>
    <? include('includes/metas.php');?>
    
    <? include('includes/css.php');?>
</head>

<body>

<? include('includes/header.php');?>

<?

if (is_numeric($_GET['ref'])) {
	$resProd = mysql_query("SELECT * FROM site_tb_produtos WHERE id_prod = '".$_GET['ref']."'");
	if (mysql_num_rows($resProd)) {
		$rowProd = mysql_fetch_array($resProd);
		
		$resFotos = mysql_query("SELECT * FROM site_tb_produtos_fotos WHERE ref = '".$rowProd['id_prod']."' ORDER BY id_foto DESC");
		$resDownloads = mysql_query("SELECT * FROM site_tb_produtos_downloads WHERE ref = '".$rowProd['id_prod']."' ORDER BY id_down DESC");
		
		$count_hit = $rowProd['hit_prod'];
		$count_hit = $count_hit+1;
		mysql_query("UPDATE site_tb_produtos SET hit_prod='".$count_hit."' WHERE id_prod = '".$rowProd['id_prod']."'");
		
	} else {
		Redir('produtos/');
	}
} else {
	Redir('produtos/');
}


?>

<div class="page page_produtos"> <!--Elemento de formatação-->

<div class="container">
    <div class="row">
		<div class="col-md-12">
            <h1>Produtos</h1>
        </div>
    </div>
    <div class="row">	
        <div class="col-md-4">
        
	        <a href="uploads/produtos/<?=$rowProd['thumb_prod']?>" class="zoom"><img src="uploads/produtos/media_<?=$rowProd['thumb_prod']?>" class="img-responsive" alt="<?=$rowProd['nome_prod']?>" /></a>
            
            <? if($rowProd['logo_prod']){?>
                <img src="uploads/produtos/<?=$rowProd['logo_prod']?>" alt="<?=$rowProd['nome_prod']?>" />
            <? } ?>
        
        </div>


        <div class="col-md-8 produto_detalhe">
            <h1><?=$rowProd['nome_prod']?></h1>
           
           <? include('includes/sharethis.php');?>
        
           <br>
		   <?=$rowProd['texto_prod']?>
            
            <? if($rowProd['vantagens_prod']){?>
                <?=$rowProd['vantagens_prod']?>
            <? } ?>
            
            <? if($rowProd['video_prod']){?>
                <br>
                <iframe name="player" width="654" height="368" src="http://www.youtube.com/embed/<?=CodYouTube($rowProd["video_prod"])?>?autoplay=1?rel=0" frameborder="0" allowfullscreen></iframe><br>
            <? } ?>
            
            
            <? if(mysql_num_rows($resFotos)){?>
            <div class="row">
            	<div class="col-md-12"><h2>Outras Fotos</h2></div>
                <? while($rowFotos = mysql_fetch_array($resFotos)){?>
                	<div class="col-md-4"><a href="uploads/produtos/<?=$rowFotos['url_foto']?>" class="zoom"><img src="uploads/produtos/thumb_<?=$rowFotos['url_foto']?>" class="img-responsive" alt="<?=$rowFotos['legenda_foto']?>" /></a></div>
                <? } ?>
            </div>
            <? }?>
            
            <? if(mysql_num_rows($resDownloads)){?>
            <div class="row">
            	<div class="col-md-12"><h2>Outras Fotos</h2></div>
                <? while($rowFotos = mysql_fetch_array($resFotos)){?>
                	<div class="col-md-4"><a href="uploads/produtos/<?=$rowFotos['url_foto']?>" class="zoom"><img src="uploads/produtos/thumb_<?=$rowFotos['url_foto']?>" class="img-responsive" alt="<?=$rowFotos['legenda_foto']?>" /></a></div>
                <? } ?>
            </div>
            <? }?>
            
            <? if(mysql_num_rows($resDownloads)){?>
            <h2>Material para Download</h2>

                <? while($rowDownloads = mysql_fetch_array($resDownloads)){?>
                    <p><a href="uploads/downloads/<?=$rowDownloads['file_down']?>" target="_blank"><i class="fa fa-download"></i>
 <? if($rowDownloads['legenda_down']!=''){ echo mostraChar($rowDownloads['legenda_down']); } else { echo $rowDownloads['file_down'];}?></a></p>
                <? } ?>

            <? }?>    
            
            <a href="javascript:history.back()" class="nav_back">Voltar</a>
        </div>
	
    </div>
</div>




</div> <!--Fim do elemento de formatação-->

<? include('includes/footer.php');?>

<? include('includes/js.php');?>

<? include('includes/analytics.php');?>

</body>
</html>