<section>
<h1>E-mails Cadastrados</h1>

<?
$res = mysql_query("SELECT * FROM site_tb_emails WHERE aceita = '0' ORDER BY nome_email ASC, end_email ASC");?>
<p>Atualmente existem <?=mysql_num_rows($res)?> e-mails cadastrados para receber novidades. Clique no link abaixo para exportar o banco de e-mails.

<p align="right"><a style="margin-right:10px; color:#FFF; text-decoration:none; background:#999; display:inline-block; padding:5px 20px; border-radius:4px;" href="exportaEmails.php">EXPORTAR RELATÓRIO</a></p>
</section>

<?php 
if (mysql_num_rows($res)) {
?>
<section class="lista-registros">

<h1>E-mails Cadastrados</h1>

<table class="table table-striped table-datatables">
	<thead>
	<tr>
    	<th>Nome</th>
        <th>E-mail</th>
        <th>Canal Captado</th>
    </tr>
    </thead>
    <tbody>
    <?php while ($row = mysql_fetch_array($res)) {?>
    <tr>
		<td align="center"><?=mostraChar($row['nome_email'])?></td>
		<td align="center"><?=mostraChar($row['end_email'])?></td>
		<td align="center"><? if(mostraChar($row['canal_captado'])!=''){echo $row['canal_captado'];}else{ echo'Não informado';}?></td>                
  </tr>
    <?php } ?>
	</tbody>    
</table>
</section>
<?php } ?>