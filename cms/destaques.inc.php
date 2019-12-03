<section>
<h1 class="tit-secao">Cadastrar Banner de Destaque</h1>
<?php ShowErros();?>

<form action="action.php?do=CadastraDestaque" method="post" enctype="multipart/form-data">
<div class="form-group">
    <label class="control-label col-sm-2" for="titulo">Título:</label>
    <div class="col-sm-10">
    <input type="text" name="titulo" id="titulo" class="form-control grande" /><br />
	</div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="legenda">Legenda:</label>
    <div class="col-sm-10">
    <input type="text" name="legenda" id="legenda" class="form-control grande" /><br />
	</div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="arquivo">Foto:</label>
    <div class="col-sm-10">
    <input type="file" name="arquivo" id="arquivo" />
    <span class="legenda">Imagem com  <?=$config_BannerHomeW?>px X <?=$config_BannerHomeH?>px.</span><br />
	</div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="link">Link:</label>
    <div class="col-sm-10">
    <input type="text" name="link" id="link" class="form-control medio" /><span class="legenda">Utilizar http:// antes do endereço.</span><br />
	</div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="cor_txt">Cor do Texto:</label>
    <div class="col-sm-10">
    <input type="text" name="cor_txt" id="cor_txt" maxlength="6" class="form-control pequeno jscolor" /><br />
	</div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="txt_botao">Texto Botão:</label>
    <div class="col-sm-10">
    <input type="text" name="txt_botao" id="txt_botao" maxlength="20" class="form-control pequeno" /><span class="legenda">Exemplo: SAIBA MAIS, DETALHE</span><br />
	</div>
</div>
<div class="form-group">
    <button type="submit" class="btn">CADASTRAR <i class="fa fa-check" aria-hidden="true"></i></button>
</div>

</form>
</section>

  <?php

$res = mysql_query("SELECT * FROM site_tb_banner WHERE tipo_banner = 'H' ORDER BY id_banner DESC ");

if (mysql_num_rows($res)) {

?>

<section class="lista-registros">
<h1>Banners Cadastrados</h1>
<p>Clique para editar </p>

<table class="table table-striped table-datatables">
	<thead>
    
    <tr>
        <th>Título</th>       
        <th class="tbl_acao">Excluir</th>
    </tr>

    </thead>
    <tbody>
	<?php while ($row = mysql_fetch_array($res)) { ?>

    <tr>

    	<td><a href="./?p=destaque&id_banner=<?=$row['id_banner']?>"><? if($row['tit_banner']){ echo mostraChar($row['tit_banner']);} else{ echo 'Sem Referência';}?></a></td>

      	<td align="right" class="excluir"><a onclick="return Confirma('Deseja excluir a imagem do banner?')" href="action.php?do=ExcluiDestaque&id_banner=<?=$row['id_banner']?>"><i class="fa fa-times times"></i></a></td>

  </tr>

    <?php } ?>
    </tbody>

</table>
</section>
<? } ?>