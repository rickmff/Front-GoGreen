<?php

if (is_numeric($_GET['id_banner'])) {

	$id_banner = $_GET['id_banner'];

	$res = mysql_query("SELECT * FROM site_tb_banner WHERE id_banner = $id_banner AND tipo_banner = 'H'");

	if (mysql_num_rows($res)) {

		$row = mysql_fetch_array($res);

	} else {

		Redir('./?p=destaques');

	}

} else {

	Redir('./?p=destaques');

}

?>



<section>
<h1>Banner de Destaque - Detalhes</h1>

<p>Modifique os campos a seguir e pressione "SALVAR" para alterar os dados.</p>

<?php ShowErros(); ?>



<?php if($row['url_banner']){?>
<div class="row">
	<div class="col-sm-10 col-sm-offset-2">
        <a href="../uploads/destaques/<?=$row['url_banner']?>" class="zoom"><img src="../uploads/destaques/<?=$row['url_banner']?>" class="foto-item" alt="<?=$row['ref_banner']?>" /></a>
	</div>
</div>
<?php } ?>

<form action="action.php?do=AlteraDestaque&id_banner=<?=$row['id_banner']?>" method="post" enctype="multipart/form-data">
<div class="form-group">
    <label class="control-label col-sm-2" for="titulo">Título:</label>
    <div class="col-sm-10">
    <input type="text" name="titulo" id="titulo" value="<?=mostraChar($row['tit_banner'])?>" class="form-control grande" /><br />
	</div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="legenda">Legenda:</label>
    <div class="col-sm-10">
    <input type="text" name="legenda" id="legenda" value="<?=mostraChar($row['leg_banner'])?>" class="form-control grande" /><br />
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
    <input type="text" name="link" id="link" class="form-control medio" value="<?=mostraChar($row['link_banner'])?>" /><span class="legenda">Utilizar http:// antes do endereço.</span><br />
	</div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="cor_txt">Cor do Texto:</label>
    <div class="col-sm-10">
    <input type="text" name="cor_txt" id="cor_txt" maxlength="6" value="<?=mostraChar($row['cor_banner'])?>" class="form-control pequeno jscolor" /><br />
	</div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="txt_botao">Texto Botão:</label>
    <div class="col-sm-10">
    <input type="text" name="txt_botao" id="txt_botao" maxlength="20" value="<?=mostraChar($row['txtBtn_banner'])?>" class="form-control pequeno" /><span class="legenda">Exemplo: SAIBA MAIS, DETALHE</span><br />
	</div>
</div>
<div class="form-group">
		<button type="submit" class="btn">SALVAR <i class="fa fa-check" aria-hidden="true"></i></button>
		<a href="index.php?p=destaques" class="btn btn-gray pull-right">Voltar <i class="fa fa-chevron-left" aria-hidden="true"></i></a>
</div>
</form>
</section>