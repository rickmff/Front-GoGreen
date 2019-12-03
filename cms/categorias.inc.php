<section>
<h1 class="tit-secao">Categoria</h1>

<?php ShowErros(); ?>

<form action="action_categorias.php?do=CadastraCat" method="post" enctype="multipart/form-data">
<div class="form-group">
    <label class="control-label col-sm-2" for="nome">Nome:</label>
    <div class="col-sm-10">
    <input type="text" name="nome" id="nome" class="form-control grande" /><br />
	</div>
</div>
<div class="form-group">
	<label class="control-label col-sm-2" for="desc">Descrição:</label>
    <div class="col-sm-10">
    <textarea name="desc" id="desc" class="form-control grande" /></textarea><br />
	</div>
</div>
<div class="form-group">
	<label class="control-label col-sm-2" for="ord">Ordem de exibição:</label>
  	<div class="col-sm-10">
     <input name="ord" type="text" class="form-control pequeno" id="ord" value="9999" />
     <span class="legenda">Informe um numero para ordenação. A ordenação será crescente.</span><br />
	</div>
</div>
<div class="form-group">
	<button type="submit" class="btn">CADASTRAR <i class="fa fa-check" aria-hidden="true"></i></button>
</div>
</form>
</section>



<?php 
$res = mysql_query("SELECT * FROM site_tb_categorias ORDER BY ord_cat ASC, nome_cat ASC");
if (mysql_num_rows($res)) {
?>
<section class="lista-registros">
<h1>Categorias Cadastradas</h1>

<p>Clique para editar </p>

<table class="table table-striped table-datatables">
	<thead>
    <tr>
        <th>Ordem de exibição</th>
        <th>Nome</th>
        <th class="tbl_acao">Excluir</th>
    </tr>
    </thead>
    <tbody>
    <?php while ($row = mysql_fetch_array($res)) {?>
    <tr>
		<td align="center"><a href="<?=$config_prCliente?>categoria&id_cat=<?=$row['id_cat']?>"><?=$row['ord_cat']?></a></td>
        <td align="center"><a href="<?=$config_prCliente?>categoria&id_cat=<?=$row['id_cat']?>"><?=mostraChar($row['nome_cat'])?></a></td>
      	<td align="center" class="excluir"><a onclick="return Confirma('Deseja excluir a categoria <?=$row['nome_cat']?>?')" href="action_categorias.php?do=ExcluiCat&id_cat=<?=$row['id_cat']?>"><i class="fa fa-times btn_excluir" aria-hidden="true"></i></a></td>
  	</tr>
    <?php } ?>
    </tbody>
</table>
</section>
<?php } ?>