<?php
if (is_numeric($_GET['id_prod'])) {
	$id_prod = $_GET['id_prod'];
	$res = mysql_query("SELECT * FROM site_tb_produtos WHERE id_prod = $id_prod");
	if (mysql_num_rows($res)) {
		$row = mysql_fetch_array($res);
		$resCat = mysql_query("SELECT * FROM site_tb_categorias ORDER BY ord_cat ASC, slug_cat ASC");
	} else {
		Redir('./?p=produtos');
	}
} else {
	Redir('./?p=produtos');
}
?>
<section>
<h1>Produto - Detalhes</h1>

<p>Modifique os campos a seguir e pressione "SALVAR" para alterar os dados.</p>

<?php ShowErros(); ?>
<?php if($row['thumb_prod']){?>
<div class="row">
	<div class="col-sm-12 text-center">
        <a href="../uploads/produtos/<?=$row['thumb_prod']?>" class="zoom"><img src="../uploads/produtos/thumb_<?=$row['thumb_prod']?>" class="foto-item" alt="<?=$row['nome_prod']?>" /></a>
	<br />
	<p><a href="action_produtos.php?do=ApagaFotoProd&id_prod=<?=$row['id_prod']?>" class="btn-foto-item">Apagar Foto</a></p>
    </div>
</div>
<?php } ?>

<?php if($row['logo_prod']){?>
<div class="row">
	<div class="col-sm-12 text-center">
        <img src="../uploads/produtos/<?=$row['logo_prod']?>" class="foto-item" alt="Logotipo <?=$row['nome_prod']?>" />
	<br />
	<p><a href="action_produtos.php?do=ApagaLogoProd&id_prod=<?=$row['id_prod']?>" class="btn-foto-item">Apagar Foto</a></p>
    </div>
</div>
<?php } ?>


<form action="action_produtos.php?do=AlteraProduto&id_prod=<?=$row['id_prod']?>" method="post" enctype="multipart/form-data">

<div class="form-group">
	<label class="control-label col-sm-2" for="categoria">Categoria:</label>
    <div class="col-sm-10">
    <select name="categoria" class="form-control grande" id="categoria">
    	<? while($rowCat=mysql_fetch_array($resCat)){?>
	        <option value="<?=$rowCat['id_cat']?>" <? if($rowCat['id_cat']==$row['ref_cat']){ echo 'selected="selected"';}?>><?=$rowCat['nome_cat']?></option>
        <? } ?>
    </select><br />
	</div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="nome">Nome:</label>
    <div class="col-sm-10">
    <input name="nome" type="text" class="form-control grande" id="nome" value="<?=mostraChar($row['nome_prod'])?>" /><br />
	</div>
</div>
<div class="form-group">
	<label class="control-label col-sm-2">Descrição:</label>
    <div class="col-sm-10">
	<textarea class="form-control" name="texto" id="texto"><?=mostraChar($row['texto_prod'])?></textarea>
    </div>
</div>
<div class="form-group">
	<label class="control-label col-sm-2">Vantagens:</label>
	<div class="col-sm-10">
    <textarea class="form-control" name="vantagens" id="vantagens"><?=mostraChar($row['vantagens_prod'])?></textarea><br />
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
    <input type="text" name="video" id="video" class="form-control pequeno" value="<?=mostraChar($row['video_prod'])?>" />
    <span class="legenda"><em>Exemplo: http://www.youtube.com/watch?v=4jkjWE_df</em></span><br />
	</div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="ordem">Ordem de exibição:</label>
    <div class="col-sm-10">
    <input type="text" value="<?=$row['ord_prod']?>" name="ordem" id="ordem" class="form-control pequeno" />
    <span class="legenda"><em>A ordem de exibição será crescente.</em></span><br />
	</div>
</div>
<div class="form-group">
	<button type="submit" class="btn">SALVAR <i class="fa fa-check" aria-hidden="true"></i></button>
    <a href="index.php?p=produtos" class="btn btn-gray pull-right">Voltar <i class="fa fa-chevron-left" aria-hidden="true"></i></a>
</div>
</form>
</section>
<script type="text/javascript">
	CKEDITOR.replace( 'texto',{toolbar : 'Personalizada', uiColor : '#F5F5F5', height: '250px',});
	CKEDITOR.replace( 'vantagens',{toolbar : 'Personalizada', uiColor : '#F5F5F5', height: '250px',});
</script>
<section>
<h2>Insira Fotos Adicionais</h2>
<p>Selecione a foto em seu computador e pressione "CADASTRAR" para adicionar.</p>
<form action="action_produtos.php?do=CadastraProd_Foto&amp;ref=<?=$row['id_prod']?>" method="post" enctype="multipart/form-data">

<div class="form-group">
	<label class="control-label col-sm-2" for="arquivo">Foto:</label>
	<div class="col-sm-10">
    <input type="file" name="arquivo" id="arquivo" /><br />
	</div>
</div>
<div class="form-group">
	<label class="control-label col-sm-2" for="legenda">Legenda:</label>
    <div class="col-sm-10">
	<input name="legenda" type="text" class="form-control grande" id="legenda" />
    </div>
</div>
<div class="form-group">
    <button type="submit" class="btn">CADASTRAR <i class="fa fa-check" aria-hidden="true"></i></button>
</div>
</form>
</section>
<?
$query_Fotos = mysql_query("SELECT * FROM site_tb_produtos_fotos WHERE ref = $id_prod ORDER BY ord_foto ASC, id_foto ASC");
if (mysql_num_rows($query_Fotos)) { ?>
<script>
$(function() {
	$( "#sortable" ).sortable({
		cursor: "move",
		placeholder: "galeria_fotos-item",
		update: function( event, ui ) {
			var sortedIDs = $( "#sortable" ).sortable( "toArray" );
			$.post("./action_produtos.php?do=OrderProd_Foto", { ordem: sortedIDs});
		}
	});
});
</script>
<section>
<ul id="sortable" class="galeria_fotos">
	<? $cont=1; while ($rowFotos = mysql_fetch_array($query_Fotos)){ ?>
    <li class="galeria_fotos-item" id="<?=$rowFotos['id_foto']?>">
    	<img src="../uploads/produtos/thumb_<?=$rowFotos['url_foto']?>" alt="<?=$rowFotos['legenda_foto']?>" style="border:1px solid #666666; padding:5px;" />
        <p align="center"><a onclick="return Confirma('Deseja excluir essa foto?')"  class="excluir" href="action_produtos.php?do=ExcluiProduto_Foto&amp;id_foto=<?=$rowFotos['id_foto']?>&amp;ref=<?=$row['id_prod']?>"><i class="fa fa-times btn_excluir" aria-hidden="true"></i></a></p>
    </li>
    <? $cont++;} ?>
</ul>	
</section>
<div style="clear:both"></div>
<?php }?>

<br />
<section>
<h2>Adicione Material para Download</h2>
<p>Selecione o arquivo em seu computador e pressione "CADASTRAR" para adicionar.</p>
<form action="action_produtos.php?do=CadastraProd_Download&amp;ref=<?=$row['id_prod']?>" method="post" enctype="multipart/form-data">

<div class="form-group">
	<label class="control-label col-sm-2" for="arquivo">Arquivo:</label>
    <div class="col-sm-10">
  	<input type="file" name="arquivo" id="arquivo" /><br />
	</div>
</div>
<div class="form-group">
	<label class="control-label col-sm-2" for="legenda">Legenda:</label>
	<div class="col-sm-10">
  	<input name="legenda" type="text" class="form-control grande" id="legenda" />
    </div>
</div>
<div class="form-group">
	<button type="submit" class="btn">CADASTRAR <i class="fa fa-check" aria-hidden="true"></i></button>
</div>
</form>
</section>
<?
$query_Downloads = mysql_query("SELECT * FROM site_tb_produtos_downloads WHERE ref = $id_prod ORDER BY id_down DESC");
if (mysql_num_rows($query_Downloads)) { ?>
<section>	
    <table class="table table-striped table-datatables">
    <thead>
    <tr>
        <th>Nome</th>
        <th class="tbl_acao">Excluir</th>
    </tr>
    </thead>
    <tbody>
        <? $cont=1; while ($rowDownload = mysql_fetch_array($query_Downloads)){ ?>
        <tr>
        	<td align="center"><a href="../uploads/downloads/<?=$rowDownload['file_down']?>" target="_blank"><? if($rowDownload['legenda_down']!=''){ echo mostraChar($rowDownload['legenda_down']); } else { echo $rowDownload['file_down'];}?></a></td>
        	<td align="center" class="excluir"><a onclick="return Confirma('Deseja excluir o arquivo <?=mostraChar($rowDownload['nome_down'])?>?')" href="action_produtos.php?do=ExcluiProduto_Download&amp;id_down=<?=$rowFotos['id_down']?>&amp;ref=<?=$row['id_prod']?>"><i class="fa fa-times btn_excluir" aria-hidden="true"></i></a></td>
        </tr>
        <? $cont++;} ?>
    </tbody>
    </table>
</section>    
<?php }?>