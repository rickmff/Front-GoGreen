<?php
require 'auth.inc.php';
$stamp = time();
$_SESSION['POST'] = $_POST;

$arquivo = 'RelatorioMailing.xls';

$query = "SELECT * FROM site_tb_emails WHERE aceita = '0' ORDER BY nome_email ASC, end_email ASC";
$resultado = mysql_query($query);

$html = '';
$html .= '<table border="1">';
$html .= '<tr>';

$html .= '<th>Nome</th>';
$html .= '<th>E-mail</th>';
$html .= '<th>Telefone</th>';
$html .= '<th>Cidade</th>';
$html .= '<th>Assunto</th>';
$html .= '<th>Canal Captado</th>';
$html .= '<th>Data Cadastro</th>';

$html .= '</tr>';
		
while($campo = mysql_fetch_array ($resultado)){
	$html .= '<tr>';
	$html .= '<td>' . utf8_decode(mostraChar($campo['nome_email'])) . '</td>';
	$html .= '<td>' . utf8_decode(mostraChar($campo['end_email'])) . '</td>';
	$html .= '<td>' . utf8_decode(mostraChar($campo['fone_email'])) . '</td>';
	$html .= '<td>' . utf8_decode(mostraChar($campo['cidade_email'])) . '</td>';
	$html .= '<td>' . utf8_decode(mostraChar($campo['canal_captado'])) . '</td>';
	$html .= '<td>' . utf8_decode(mostraChar($campo['assunto_desejado'])) . '</td>';
	$html .= '<td>' . mostraData(substr($campo['data_captacao'],0,10)) . '</td>';

	$html .= '</tr>';
}
$html .= '</table>';

header ("Content-Encoding: UTF-8");
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/x-msexcel;");
header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
header ("Content-Description: ".$config_nomeCliente );

// Envia o conteúdo do arquivo
echo $html;
exit;


?>