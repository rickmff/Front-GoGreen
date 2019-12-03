<section>
<h1 class="tit-secao">Cadastrar Administrador</h1>
<?php ShowErros(); ?>

<form action="action.php?do=CadastraAdmin" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label class="control-label col-sm-2" for="login">Login:</label>
    	<div class="col-sm-10">
        <input type="text" name="login" id="login" class="form-control medio" /> - Não utilize acentos.<br />
        </div>
    </div>
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
        <input type="text" name="nome" id="nome" class="form-control grande" /><br />
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="email">E-mail:</label>
    	<div class="col-sm-10">
        <input type="text" name="email" id="email" class="form-control grande" /><br />
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn">CADASTRAR <i class="fa fa-check" aria-hidden="true"></i></button>
    </div>
</form>
</section>
<?php $res = mysql_query("SELECT * FROM site_tb_admins");
if (mysql_num_rows($res)) {
?>
<section class="lista-registros">

<h1>Administradores Cadastrados</h1>

<p>Clique para editar </p>

<table class="table table-striped table-datatables">
	<thead>
    <tr>
        <th>Login</th>
        <th>Nome</th>
        <th>E-mail</th>
        <th class="tbl_acao">Excluir</th>
    </tr>
	</thead>
    <tbody>
	<?php while ($row = mysql_fetch_array($res)) { ?>
        <tr>
            <td align="center"><a href="<?=$config_prCliente?>admin&id_admin=<?=$row['adm_id']?>"><?=mostraChar($row['adm_login'])?></a></td>
            <td align="center"><?=mostraChar($row['adm_nome'])?></td>
            <td align="center"><?=mostraChar($row['adm_email'])?></td>
            <td align="center" class="excluir"><a onclick="return Confirma('Deseja excluir o administrador <?=mostraChar($row['adm_nome'])?>?')" href="action.php?do=ExcluiAdmin&id_admin=<?=$row['adm_id']?>"><i class="fa fa-times btn_excluir" aria-hidden="true"></i></a></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
</section>
<?php } ?>