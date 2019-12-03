<?
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

<div class="page empresa"> <!--Elemento de formatação-->

<div class="container">
    <div class="row">
    	
    	<div class="col-md-8">
    		<h1>Nossa Empresa</h1>
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque non ipsum tincidunt mi auctor tempus. Curabitur luctus hendrerit purus convallis aliquet. Sed et sagittis nisl, eu dapibus dui. Praesent eget nibh risus. Phasellus euismod pulvinar tristique. Curabitur eu maximus est. Donec lacus sem, rutrum sed rhoncus non, pretium vitae turpis. Nulla suscipit purus in ornare dignissim. Quisque vitae convallis libero, eget tristique dui.</p>
		<p>Quisque consectetur ac sapien ac accumsan. In nec pellentesque elit, id tincidunt nisl. Etiam vitae odio ac erat pulvinar mollis at at augue. Nulla laoreet vitae sem condimentum dignissim. Vivamus ultricies bibendum erat, vitae tincidunt magna mattis sed. Integer mauris felis, tristique id enim vitae, semper consequat ipsum. Aenean quis finibus tellus, quis consequat lorem. Etiam sit amet quam suscipit, luctus nibh ut, tincidunt ex. Aenean varius tincidunt leo, at tristique ipsum condimentum ac..</p>


    	</div>
    	<div class="col-md-4">
    		logo
    	</div>
		

    </div>
</div>

</div> <!--Fim do elemento de formatação-->

<? include('includes/footer.php');?>

<? include('includes/js.php');?>

<? include('includes/analytics.php');?>

</body>
</html>