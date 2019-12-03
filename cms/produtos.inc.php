<?
$resCat = mysql_query("SELECT * FROM site_tb_categorias ORDER BY ord_cat ASC, slug_cat ASC");
?>
<section>
<h1 class="tit-secao">Produto</h1>

<?php ShowErros(); ?>

<form action="action_produtos.php?do=CadastraProduto" method="post" enctype="multipart/form-data">

<div class="form-group">
    <label class="control-label col-sm-2" for="categoria">Categoria:</label>
    <div class="col-sm-10">
    <select name="categoria" class="form-control grande" id="categoria">
    <? while($rowCat=mysql_fetch_array($resCat)){?>
        <option value="<?=$rowCat['id_cat']?>"><?=$rowCat['nome_cat']?></option>
    <? } ?>
    </select><br />
	</div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="nome">Nome:</label>
    <div class="col-sm-10">
    <input name="nome" type="text" class="form-control grande" id="nome" /><br />
	</div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2">Descrição:</label>
    <div class="col-sm-10">
    <textarea class="form-control" name="texto" id="texto"></textarea><br />
	</div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2">Vantagens:</label>
    <div class="col-sm-10">
    <textarea class="form-control" name="vantagens" id="vantagens"></textarea><br />
	</div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="arquivo">Foto Principal:</label>
    <div class="col-sm-10">
    <input type="file" name="arquivo" class="form-control medio" id="arquivo" /><span class="legenda">Utilize tamanho mínimo 200px X 150px</span><br />
	</div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="logotipo">Logotipo:</label>
    <div class="col-sm-10">
    <input type="file" name="logotipo" class="form-control medio" id="logotipo" /><span class="legenda">Utilize tamanho até 250px X 180px</span><br />
	</div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="video">Vídeo (Youtube&reg;):</label>
    <div class="col-sm-10">
    <input type="text" name="video" id="video" class="form-control pequeno" />
    <span class="legenda"><em>Exemplo: http://www.youtube.com/watch?v=4jkjWE_df</em></span><br />
	</div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="ordem">Ordem de exibição:</label>
    <div class="col-sm-10">
    <input type="text" value="9999" name="ordem" id="ordem" class="form-control pequeno" />
    <span class="legenda"><em>A ordem de exibição será crescente.</em></span><br />
	</div>
</div>
<div class="form-group">
	<button type="submit" class="btn">CADASTRAR <i class="fa fa-check" aria-hidden="true"></i></button>
</div>
</form>
</section>

<script type="text/javascript">
	CKEDITOR.replace( 'texto',{toolbar : 'Personalizada', uiColor : '#F5F5F5', height: '250px',});
	CKEDITOR.replace( 'vantagens',{toolbar : 'Personalizada', uiColor : '#F5F5F5', height: '250px',});
</script>


<?php
$res = mysql_query("SELECT * FROM site_tb_produtos ORDER BY ord_prod ASC, nome_prod ASC");
if (mysql_num_rows($res)) {
?>
<section class="lista-registros">
<h1>Produtos Cadastrados</h1>

<p>Clique para editar</p>

<table class="table table-striped table-datatables">
	<thead>
	<tr>
    	<th>Ordem de exibição</th>
        <th>Nome</th>
        <th>Categoria</th>
        <th>Views</th>
        <th class="tbl_acao">Excluir</th>
	</tr>
    </thead>
    <tbody>
    <?php while ($row = mysql_fetch_array($res)) {
		$infoCat = mysql_fetch_array(mysql_query("SELECT nome_cat FROM site_tb_categorias WHERE id_cat = '".$row['ref_cat']."'"));
		?>
<tr>
      <td <?=$bg?> align="center"><a href="./?p=produto&id_prod=<?=$row['id_prod']?>"><?=mostraChar($row['ord_prod'])?></a></td>
      <td <?=$bg?> align="center"><a href="./?p=produto&id_prod=<?=$row['id_prod']?>"><?=mostraChar($row['nome_prod'])?></a></td>
      <td <?=$bg?> align="center"><a href="./?p=produto&id_prod=<?=$row['id_prod']?>"> <?=mostraChar($infoCat['nome_cat'])?></a></td>
      <td <?=$bg?> align="center"><a href="./?p=produto&id_prod=<?=$row['id_prod']?>"><?=$row['hit_prod']?></a></td>
      <td <?=$bg?> align="center" class="excluir"><a onclick="return Confirma('Deseja excluir o produto <?=mostraChar($row['nome_prod'])?>?')" href="action_produtos.php?do=ExcluiProduto&id_prod=<?=$row['id_prod']?>"><i class="fa fa-times btn_excluir" aria-hidden="true"></i></a></td>
  </tr>
    <?php } ?>
	</tbody>
       
</table>
</section>
<?php
}
?>