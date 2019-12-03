<?php
if (is_numeric($_GET['id_admin'])) {
	$id_admin = $_GET['id_admin'];
	$res = mysql_query("SELECT * FROM site_tb_admins WHERE adm_id = $id_admin");
	if (mysql_num_rows($res)) {
		$row = mysql_fetch_array($res);
	} else {
		Redir($config_prCliente.'admins');
	}
} else {
	Redir($config_prCliente.'admins');
}
?>
<section>
<h1>Administrador - Detalhes</h1>

<p>Modifique os campos a seguir e pressione "SALVAR" para alterar os dados.</p>

<?php ShowErros(); ?>

<form action="action.php?do=AlteraAdmin&id_admin=<?=$row['adm_id']?>" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label class="control-label col-sm-2" for="senha">Senha:</label>
    	<div class="col-sm-10">
        <input type="password" name="senha" id="senha" class="form-control medio" /><br />
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="conf">Redigite a senha:</label>
    	<div class="col-sm-10">
        <input type="password" name="conf" id="conf" class="form-control medio" /><br />
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="nome">Nome:</label>
    	<div class="col-sm-10">
        <input type="text" name="nome" id="nome" class="form-control grande" value="<?=mostraChar($row['adm_nome'])?>" /><br />
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="email">E-mail:</label>
    	<div class="col-sm-10">
        <input type="text" name="email" id="email" class="form-control grande" value="<?=mostraChar($row['adm_email'])?>" /><br />
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn">SALVAR <i class="fa fa-check" aria-hidden="true"></i></button>
        <a href="index.php?p=admins" class="btn btn-gray pull-right">Voltar <i class="fa fa-chevron-left" aria-hidden="true"></i></a>
    </div>
</form>
</section>