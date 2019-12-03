<?
$resCat = mysql_query("SELECT * FROM site_tb_categorias ORDER BY ord_cat ASC, slug_cat ASC");
if(mysql_num_rows($resCat)){ ?>

<ul class="categorias">	
	<? 	while($rowCat = mysql_fetch_array($resCat)){?>
		<li><a href="produtos/<?=$rowCat['slug_cat']?>"><?=$rowCat['nome_cat']?></a></li>
	<? } ?>
</ul>
<? } ?>

