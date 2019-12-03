<?php
if (is_numeric($_GET['id_cat'])) {
	$id_cat = $_GET['id_cat'];
	$res = mysql_query("SELECT * FROM site_tb_categorias WHERE id_cat = $id_cat");
	if (mysql_num_rows($res)) {
		$row = mysql_fetch_array($res);
	} else {
		Redir($config_prCliente.'categorias');
	}
} else {
	Redir($config_prCliente.'categorias');
}
?>
<section>
<h1>Categoria - Detalhes</h1>

<p>Modifique os campos a seguir e pressione "SALVAR" para alterar os dados.</p>

<?php ShowErros(); ?>

<form action="action_categorias.php?do=AlteraCat&id_cat=<?=$row['id_cat']?>" method="post" enctype="multipart/form-data">

<div class="form-group">
    <label class="control-label col-sm-2" for="nome">Nome:</label>
    <div class="col-sm-10">
    <input type="text" name="nome" id="nome" class="form-control grande" value="<?=mostraChar($row['nome_cat'])?>" /><br />
	</div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="desc">Descrição:</label>
    <div class="col-sm-10">
    <textarea name="desc" id="desc" class="form-control grande" /><?=mostraChar($row['desc_cat'])?></textarea><br />
	</div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="ord">Ordem de Exibição:</label>
    <div class="col-sm-10">
    <input name="ord" type="text" class="form-control pequeno" id="ord" value="<?=$row['ord_cat']?>" /><span class="legenda">Informe um numero para ordenação. A ordenação será crescente.</span><br />
	</div>
</div>
<div class="form-group">
	<button type="submit" class="btn">SALVAR <i class="fa fa-check" aria-hidden="true"></i></button>
    <a href="index.php?p=categorias" class="btn btn-gray pull-right">Voltar <i class="fa fa-chevron-left" aria-hidden="true"></i></a>
</div>
</form>
</section>