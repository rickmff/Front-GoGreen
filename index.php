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
<!--[if gt IE 8]><!--> 
<html class="no-js" lang="pt-br" itemscope="" itemtype="http://schema.org/WebPage"> <!--<![endif]-->
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <? include('includes/metas.php');?>
    
    <? include('includes/css.php');?>
    
    <link rel="stylesheet" href="assets/css/slider.css" type="text/css">
</head>

<body>

<? include('includes/header.php');?>

<? include('includes/slider.php');?>

<div class="page home"> <!--Elemento de formatação-->

<div class="container">
    <div class="row">
        <div class="col-md-4">
          <h2><a href="javascript:">Título I</a></h2>
          <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
          <p><a class="btn" href="#">Saiba mais</a></p>
        </div>
        <div class="col-md-4">
          <h2><a href="javascript:">Título 2</a></h2>
          <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
          <p><a class="btn" href="#">Saiba mais</a></p>
       </div>
        <div class="col-md-4">
          <h2><a href="javascript:">Título 3</a></h2>
          <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
          <p><a class="btn" href="#">Saiba mais</a></p>
        </div>
    </div>
</div>

</div> <!--Fim do elemento de formatação-->


<? include('includes/footer.php');?>

<? include('includes/js.php');?>

<? include('includes/analytics.php');?>

</body>
</html>