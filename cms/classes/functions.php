<?php
function secret_mail($email){
	$prop=2;
    $domain = substr(strrchr($email, "@"), 1);
    $mailname=str_replace($domain,'',$email);
    $name_l=strlen($mailname);
    $domain_l=strlen($domain);
        for($i=0;$i<=$name_l/$prop-1;$i++){
        $start.='*';
        }

        for($i=0;$i<=$domain_l/$prop-1;$i++){
        $end.='*';
        }

    return substr_replace($mailname, $start, 2, $name_l/$prop).substr_replace($domain, $end, 2, $domain_l/$prop);
}
function TemaCorpoEmail($titulo, $content){
	global $config_nomeCliente;
	global $config_urlCliente;
	global $config_corCliente;
	
	$body = '';
	
	$body .= '<style type="text/css">body{background-color:#efefef;}h1 {font: bold 14px Arial; text-align: center; padding: 20px 0px 10px 20px; margin-bottom: 40px; border-bottom: 5px solid #'.$config_corCliente.';}a{font:12px Arial;color:#313131; text-decoration:none;} a:hover{font:12px Arial;color:#313131; text-decoration:none;}p, table { font:12px Arial; }hr{border: solid 1px #ddd;}</style>';
	$body .= '<table width="600" border="0" align="center" cellpadding="10" cellspacing="0" style="background-color:#FFF; border:1px solid #ddd">';
	$body .= '<tr><td>';
	$body .= '<h1>'.$titulo.'</h1>';
	$body .= $content;
	$body .= '<br></td></tr>';
	$body .= '<tr><td align="center" valign="middle"><hr />';
	$body .= '<p>'.$config_nomeCliente.'<br>';
	$body .= '<a href="'.$config_urlCliente.'" target="_blank">'.$config_urlCliente.'</a></p>';
	$body .= '</td></tr></table>';
	
	return $body;

}
function addMailChimp( $email, $status, $list_id, $api_key, $merge_fields = array('FNAME' => '','LNAME' => '','ORIGIN' => '','SUBJECT' => '') ){
    $data = array(
        'apikey'        => $api_key,
        'email_address' => $email,
        'status'        => $status,
        'merge_fields'  => $merge_fields
    );
    $mch_api = curl_init(); // initialize cURL connection
    curl_setopt($mch_api, CURLOPT_URL, 'https://' . substr($api_key,strpos($api_key,'-')+1) . '.api.mailchimp.com/3.0/lists/' . $list_id . '/members/' . md5(strtolower($data['email_address'])));
    curl_setopt($mch_api, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Basic '.base64_encode( 'user:'.$api_key )));
    curl_setopt($mch_api, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
    curl_setopt($mch_api, CURLOPT_RETURNTRANSFER, true); // return the API response
    curl_setopt($mch_api, CURLOPT_CUSTOMREQUEST, 'PUT'); // method PUT
    curl_setopt($mch_api, CURLOPT_TIMEOUT, 10);
    curl_setopt($mch_api, CURLOPT_POST, true);
    curl_setopt($mch_api, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($mch_api, CURLOPT_POSTFIELDS, json_encode($data) ); // send data in json

    $result = curl_exec($mch_api);
    return $result;
}

function GravaMailing($mail, $nome, $telefone, $cidade, $canal, $assunto, $obs){
	$nome = gravaChar($nome);
	$telefone = gravaChar($telefone);
	$cidade = gravaChar($cidade);
	$canal = gravaChar($canal);
	$assunto = gravaChar($assunto);
	$obs = gravaChar($obs);
	
	
		$res = mysql_query("SELECT * FROM site_tb_emails WHERE end_email = '".$mail."'");
		if(!mysql_num_rows($res)){
			mysql_query("INSERT INTO site_tb_emails VALUES(NULL, '".$mail."', '".$nome."', '".$telefone."', '".$cidade."', '".$canal."', '".$assunto."', '".$obs."', '0', '".date("Y-m-d H:i:s")."')");
		} else {
			
			while($row = mysql_fetch_array($res)){
				if($row['aceita']=='1'){ mysql_query("UPDATE site_tb_emails SET aceita = '0' WHERE id_email ='".$row['id_email']."' ");}
				if($row['nome_email']==''){ mysql_query("UPDATE site_tb_emails SET nome_email = '".$nome."' WHERE id_email ='".$row['id_email']."'");}
				if($row['fone_email']==''){ mysql_query("UPDATE site_tb_emails SET fone_email = '".$telefone."' WHERE id_email ='".$row['id_email']."'");}
				if($row['cidade_email']==''){ mysql_query("UPDATE site_tb_emails SET cidade_email = '".$cidade."' WHERE id_email ='".$row['id_email']."'");}
				if($row['obs_email']==''){ mysql_query("UPDATE site_tb_emails SET obs_email = '".$obs."' WHERE id_email ='".$row['id_email']."'");}
				//se o canal OU assunto for diferente gera um novo registro
				if( ($row['canal_captado']!=$canal) || ($row['assunto_desejado']!=$assunto)){
					$novo_registro = true;
				}			
			}
			
			if($novo_registro){
				mysql_query("INSERT INTO site_tb_emails VALUES(NULL, '".$mail."', '".$nome."', '".$telefone."', '".$cidade."', '".$canal."', '".$assunto."', '".$obs."', '0', '".date("Y-m-d H:i:s")."')");
			}
		}
	 	
}

function CodYouTube ($url_video){
	$vdfoto = explode("v=",$url_video);
	$vdfoto = $vdfoto[1];
	$vdfoto = substr($vdfoto,0,11);	
	return $vdfoto;
}

function NomeMes($numero){
	$numero = str_pad($numero, 2, "0", STR_PAD_LEFT);
	$nome_mes = array(
		'01'=>'Janeiro',
		'02'=>'Fevereiro',
		'03'=>'Março',
		'04'=>'Abril',
		'05'=>'Maio',
		'06'=>'Junho',
		'07'=>'Julho',
		'08'=>'Agosto',
		'09'=>'Setembro',
		'10'=>'Outubro',
		'11'=>'Novembro',
		'12'=>'Dezembro'
	);
	return $nome_mes[$numero];
}

function proximoDia($dias = 1){
	return date("Y-m-d",mktime(0, 0, 0, date("m"), date("d")+$dias, date("y")));
}

function addDias ($dias, $data) {
	$maisDias = '+'.$dias.' days';
	return date("Y-m-d", strtotime($maisDias,strtotime($data))); // 15/03/2006
}

function diasemana($data) {
	$ano =  substr("$data", 0, 4);	$mes =  substr("$data", 5, -3);	$dia =  substr("$data", 8, 9);
	$diasemana = date("w", mktime(0,0,0,$mes,$dia,$ano) );

	switch($diasemana) {
		case"0": $diasemana = "Dom";	break;
		case"1": $diasemana = "Seg"; 	break;
		case"2": $diasemana = "Ter";   	break;
		case"3": $diasemana = "Qua";  	break;
		case"4": $diasemana = "Qui";  	break;
		case"5": $diasemana = "Sex";   	break;
		case"6": $diasemana = "Sab";	break;
	}

	return $diasemana;
}

function Moeda($valor) {

	$valstr = number_format($valor,2,',','.');

	return $valstr;

}


function GetExtensao($get_file) {

	$ext = array_reverse(explode(".",$get_file));

	return $ext[0];

}

function Reduz($string,$maxwords) {

	$words = explode(' ',$string);

	$numwords = count($words);

	if ($numwords > $maxwords) {

		for ($i=0;$i<$maxwords;$i++) {

			$text .= ' '.$words[$i];

		}

		return trim($text).'...';

	} else {

		return trim($string);

	}

}


function DataExtenso($stamp) {

	$sem = date('N',$stamp);

	$mes = date('m',$stamp);

	switch($sem) {

		case '1':

			$semExt = 'Segunda-feira';

		break;

		case '2':

			$semExt = 'Terça-feira';

		break;

		case '3':

			$semExt = 'Quarta-feira';

		break;

		case '4':

			$semExt = 'Quinta-feira';

		break;

		case '5':

			$semExt = 'Sexta-feira';

		break;

		case '6':

			$semExt = 'Sábado';

		break;

		case '7':

			$semExt = 'Domingo';

		break;

	}

	switch($mes) {

		case '01':

			$mesExt = 'janeiro';

		break;

		case '02':

			$mesExt = 'fevereiro';

		break;

		case '03':

			$mesExt = 'março';

		break;

		case '04':

			$mesExt = 'abril';

		break;

		case '05':

			$mesExt = 'maio';

		break;

		case '06':

			$mesExt = 'junho';

		break;

		case '07':

			$mesExt = 'julho';

		break;

		case '08':

			$mesExt = 'agosto';

		break;

		case '09':

			$mesExt = 'setembro';

		break;

		case '10':

			$mesExt = 'outubro';

		break;

		case '11':

			$mesExt = 'novembro';

		break;

		case '12':

			$mesExt = 'dezembro';

		break;

	}

	return "$semExt, ".date('d',$stamp)." de $mesExt de ".date('Y',$stamp);

}

	

function FormataCep($cep) {

	return substr($cep,0,5).'-'.substr($cep,5,3);

}

	

function FormataFone($fone) {

	return '('.substr($fone,0,2).') '.substr($fone,2,4).' '.substr($fone,6,4);

}


function Redir($pag) {

	echo "<script type=\"text/javascript\">";

	echo "window.open(\"".$pag."\",\"_self\");";

	echo "</script>";

	exit;

}


function Go($pag) {

	header('Location: '.$pag);

	exit;

}


function Erro($str) {

	$_SESSION['Erros'][count($_SESSION['Erros'])] = $str;

}


function Info($str) {

	$_SESSION['Info'] = $str;

}


function ShowErros() {

	$erros = count($_SESSION['Erros']);

	if ($erros > 0) {
		
		$msg = '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
		foreach ($_SESSION['Erros'] as $erro) {
			$msg .=  '<b><i class="fa fa-times"></i></b> '.$erro.'</br>';
		}
		$msg .=  '</div>';
		unset($_SESSION['Erros']);
		echo $msg;

	}

	if ($_SESSION['Info'] != '') {

		$msg = '<div class="alert alert-success">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<b><i class="fa fa-check"></i></b> '.$_SESSION['Info'].'</div>';
		//echo '<div class="info">'.$_SESSION['Info'].'</div>';
		unset($_SESSION['Info']);
		echo $msg;
	}

}


function print_array($array) {

	echo '<pre>';

	print_r($array);

	echo '</pre>';

}


function ValidaSenha($senha,$conf) {

	if (strlen($senha) > 3) {

		if ($senha == $conf) {

			return true;

		} else {

			Erro('A confirmação deve ser idêntica à senha.');

			return false;

		}

	} else {

		Erro('A senha deve conter no mínimo 4 caracteres.');

		return false;

	}

}


function ValidaNome($nome) {

	if (strlen($nome) > 4) {

		return true;

	} else {

		Erro('O nome deve conter no mínimo 5 caracteres.');

		return false;

	}

}


function ValidaCidade($cidade) {

	if (strlen($cidade) > 2) {

		return true;

	} else {

		Erro('O campo cidade deve conter no mínimo 3 caracteres.');

		return false;

	}

}


function ValidaEndereco($endereco) {

	if (strlen($endereco) > 5) {

		return true;

	} else {

		Erro('Endereço inválido.');

		return false;

	}

}


function ValidaUnico($valor,$campo,$tabela,$erro) {

	if (strlen($valor) > 2) {

		$res = mysql_query("SELECT $campo FROM $tabela WHERE $campo = '$valor'");

		if (!mysql_num_rows($res)) {

			return true;

		} else {

			$row = mysql_fetch_array($res);

			if($row[$campo]==$valor){

				Erro($erro);

				return false;

			} else {

				return true;

			}

		}

	} else {

		Erro($erro);

		return false;

	}

}


function ValidaID($id,$campo,$tabela,$msg) {

	if ($msg == '') $msg = 'Identificação inválida.';

	if (!empty($id)) {

		if (is_numeric($id)) {

			$res = mysql_query("SELECT $campo FROM $tabela WHERE $campo = $id");

			if (@mysql_num_rows($res) > 0) {

				return true;

			} else {

				Erro($msg);

				return false;

			}

		} else {

			Erro($msg);

			return false;

		}

	} else {

		Erro($msg);

		return false;

	}

}


function ValidaCEP($cep) {

	if (ereg("^[0-9]{8}$",$cep)) {

		return true;

	} else {

		Erro('CEP inválido.');

		return false;

	}

}


function ValidaEmail($email) {

	if (ereg("^([0-9,a-z,A-Z]+)([.,_]([0-9,a-z,A-Z]+))*[@]([0-9,a-z,A-Z]+)([.,_,-]([0-9,a-z,A-Z]+))*[.]([0-9,a-z,A-Z]){2}([0-9,a-z,A-Z])?$",$email)) { 

		return true;

	} else {

		Erro('E-mail inválido.');

		return false;

	}

}


function ValidaFone($fone,$msg) {

	if (ereg("^[0-9]{10}$",$fone)) {

		return true;

	} else {

		Erro($msg);

		return false;

	}

}


function ValidaVazio($campo,$msg) {

	if (!empty($campo)) {

		return true;

	} else {

		Erro($msg);

		return false;

	}

}


function ValidaMoeda($valor,$msg) {

	if (!empty($valor)) {

		$valor = str_replace('.','',$valor);

		$valor = str_replace(',','.',$valor);

		if (is_numeric($valor)) {

			return $valor;

		} else {

			Erro($msg);

			return false;

		}

	} else {

		Erro($msg);

		return false;

	}

}

function gravaChar($string) {
	$string = str_replace('"','"',$string);
	$string = str_replace('"','"',$string);
	$string = str_replace('–','-',$string);
	return html_entity_decode($string,ENT_COMPAT,'UTF-8');

}

function mostraChar($string) {
	return html_entity_decode($string,ENT_COMPAT,'UTF-8');
}

function gravaData($data) {
	$data = explode('/', $data);

	$data = $data[2].'-'.$data[1].'-'.$data[0];

	return $data;

}


function mostraData($data) {

	$data = explode('-', $data);

	$data = $data[2].'/'.$data[1].'/'.$data[0];

	return $data;

}


function removeAcentos($string, $slug = false) {

	$string = strtolower(utf8_encode($string));


	// Código ASCII das vogais

	$ascii['a'] = range(224, 230);

	$ascii['e'] = range(232, 235);

	$ascii['i'] = range(236, 239);

	$ascii['o'] = array_merge(range(242, 246), array(240, 248));

	$ascii['u'] = range(249, 252);


	// Código ASCII dos outros caracteres

	$ascii['b'] = array(223);

	$ascii['c'] = array(231);

	$ascii['d'] = array(208);

	$ascii['n'] = array(241);

	$ascii['y'] = array(253, 255);


	foreach ($ascii as $key=>$item) {

		$acentos = '';

		foreach ($item AS $codigo) $acentos .= chr($codigo);

		$troca[$key] = '/['.$acentos.']/i';

	}


	$string = preg_replace(array_values($troca), array_keys($troca), $string);


	// Slug?

	/*if ($slug) {

		// Troca tudo que não for letra ou número por um caractere ($slug)

		$string = preg_replace('/[^a-z0-9]/i', $slug, $string);

		// Tira os caracteres ($slug) repetidos

		$string = preg_replace('/' . $slug . '{2,}/i', $slug, $string);

		$string = trim($string, $slug);

	}*/


	return $string;

}


function cleanURI($input){
	return ereg_replace(
		'[^a-z0-9-]',
		'',
		ereg_replace(
			 ' +',
			 '-',
			 strtr(
			   strtolower(html_entity_decode($input,ENT_COMPAT,'UTF-8')),
			   'ÀÁÃÂÉÊÍÓÕÔÚÜÇàáãâéêíóõôúüç',
			   'AAAAEEIOOOUUCaaaaeeiooouuc'
			   )
			 )
		)
;}

function cleanString($string){
    $url = mostraChar($string);
    setlocale(LC_ALL, 'pt_BR'); // change to the one of your language
    $url = iconv("UTF-8", "ASCII//TRANSLIT", $url); 
    $url = preg_replace('~[^\\pL0-9_]+~u', '-', $url);
    $url = trim($url, "-");
    $url = strtolower($url);
    return $url;
}
/*function cleanString($input){
	return str_replace('---','-',cleanURI(html_entity_decode(mb_strtolower($input),ENT_COMPAT,'UTF-8')));
}*/

function GeraDATA($days){

	

	$hoje = date("Y-m-d");

	

	$data = mktime(0, 0, 0, date("m"), date("d") - $days, date("Y"));

	$data = date("Y-m-d", $data);

	

	return $data;

}	


function RandomPass($numchar){  

   $letras = "a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,x,w,y,z,0,1,2,3,4,5,6,7,8,9";  

   $array = explode(",", $letras);  

   shuffle($array);  

   $senha = implode($array, "");  

   return substr($senha, 0, $numchar);  

}


function ValidaImagem($file) {

		if (getimagesize($file['tmp_name'])) {

			switch ($file['type']) {

				case 'image/jpeg':

					return true;

				break;

				case 'image/pjpeg':

					return true;

				break;

				case 'image/gif':

					return true;

				break;

				case 'image/png':

					return true;

				break;

				case 'image/x-png':

					return true;

				break;

				default:

					Erro('Formato de imagem inválido. São aceitos: JPEG, GIF e PNG.');

					return false;

				break;

			}

		} else {

			Erro('Formato inválido.');

			return false;

		}

}

 function ascii_to_entities($str){

   $count	= 1;

   $out	= '';

   $temp	= array();

	

   for ($i = 0, $s = strlen($str); $i < $s; $i++)

   {

	   $ordinal = ord($str[$i]);

	

	   if ($ordinal < 128)

	   {

		   $out .= $str[$i];

	   }

	   else

	   {

		   if (count($temp) == 0)

		   {

			   $count = ($ordinal < 224) ? 2 : 3;

		   }

		

		   $temp[] = $ordinal;

		

		   if (count($temp) == $count)

		   {

			   $number = ($count == 3) ? (($temp['0'] % 16) * 4096) + (($temp['1'] % 64) * 64) + ($temp['2'] % 64) : (($temp['0'] % 32) * 64) + ($temp['1'] % 64);


			   $out .= '&#'.$number.';';

			   $count = 1;

			   $temp = array();

		   }

	   }

   }


   return $out;

}

function image_fix_orientation($filename) {
    $exif = exif_read_data($filename,0,true);
    if (!empty($exif['Orientation'])) {
        $image = imagecreatefromjpeg($filename);
        switch ($exif['Orientation']) {
            case 3:
                $image = imagerotate($image, 180, 0);
                break;

            case 6:
                $image = imagerotate($image, -90, 0);
                break;

            case 8:
                $image = imagerotate($image, 90, 0);
                break;
        }
        imagejpeg($image, $filename, 90);    }
}

function compress_image($source_url, $destination_url, $quality) {
	$info = getimagesize($source_url);
	if ($info['mime'] == 'image/jpeg') {
		$image = imagecreatefromjpeg($source_url);
		imagejpeg($image, $destination_url, $quality);
	} elseif ($info['mime'] == 'image/gif') {
		$image = imagecreatefromgif($source_url);
		imagegif($image,$destination_url);
	} elseif ($info['mime'] == 'image/png'){
		//$image = imagecreatefrompng($source_url);
		//imagepng($image, $destination_url);
	} else {
		imagejpeg($image, $destination_url, $quality);
	}	
	return $destination_url;
}
?>