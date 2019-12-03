<?php
require 'auth.inc.php';
require_once 'classes/wideimage/WideImage.php';
$stamp = time();
$_SESSION['POST'] = $_POST;

for ($i=0;$i<count($_POST);$i++) {
	$var = key($_POST);
	$$var = trim($_POST[key($_POST)]);
	next($_POST);
}

for ($i=0;$i<count($_GET);$i++) {
	$var = key($_GET);
	$$var = trim($_GET[key($_GET)]);
	next($_GET);
}

if($_GET['url'] && file_exists(base64_decode(urldecode($_GET['url'])))){
	
	$caminhoImg = base64_decode(urldecode($_GET['url']));
	
	$folderImg = explode('uploads/',$caminhoImg);
	$folderImg = $folderImg[1];
	$folderImg = explode('/',$folderImg);
	$folderImg = $folderImg[0];
	$nameImg = explode('uploads/'.$folderImg.'/',$caminhoImg);
	$nameImg = $nameImg[1];
	
	
	if (file_exists('../uploads/'.$folderImg.'/thumb_'.$nameImg)) {
		//existe a thumb
		$thumbFile = true;
		$thumbSizes = getimagesize('../uploads/'.$folderImg.'/thumb_'.$nameImg);
			$thumbSizeW = $thumbSizes[0];
			$thumbSizeH = $thumbSizes[1];				
	}
	
	if (file_exists('../uploads/'.$folderImg.'/media_'.$nameImg)) {
		//existe a media
		$mediaFile = true;
		$mediaSizes = getimagesize('../uploads/'.$folderImg.'/thumb_'.$nameImg);
			$mediaSizeW = $mediaSizes[0];
			$mediaSizeH = $mediaSizes[1];	
	}
	
	$caminho = '../uploads/'.$folderImg.'/';
	$file = $caminho.$nameImg;
	$ext = '.'.end(explode('.', $nameImg));
	
	
	if (file_exists($file)) {
		
		$img = WideImage::loadFromFile($file);
		//entra script do rotate
		
		switch ($do) {
			// ===============================================================
			case 'RotateLeft':
				$img = $img->rotate(-90);
			break;
			case 'RotateRight':
				$img = $img->rotate(90);
			break;
			case 'FlipH':
				$img = $img->mirror();
			break;
			case 'FlipV':
				$img = $img->flip();
			break;
			// ===============================================================	
		}
		unlink($caminho.$nameImg);
		$img->saveToFile($caminho.$nameImg);		
		
		if($thumbFile){
			$thumb = WideImage::loadFromFile($file);
			//----THUMB---		
			$thumb = $thumb->resize($thumbSizeW, $thumbSizeH, 'outside')->crop('50% - '.floor($thumbSizeW/2), '50% - '.floor($thumbSizeH/2), $thumbSizeW, $thumbSizeH);
			unlink($caminho.'thumb_'.$nameImg);
			$thumb->saveToFile($caminho.'thumb_'.$nameImg);
			//----THUMB---		
		}
		if($mediaFile){
			$media = WideImage::loadFromFile($file);
			//---MEDIA---
			$media = $media->resize($mediaSizeW, $mediaSizeH, 'outside')->crop('50% - '.floor($mediaSizeW/2), '50% - '.floor($mediaSizeH/2), $mediaSizeW, $mediaSizeH);
			unlink($caminho.'media_'.$nameImg);
			$media->saveToFile($caminho.'media_'.$nameImg);
			//----MEDIA---
		}
				
		
		Info('Imagem editada com sucesso!');
		Redir(base64_decode(urldecode($_GET['prev'])));
		/*echo "<script>window.location.reload(history.go(-1))</script>";*/
	
	}else{
		echo "<script>alert('Arquivo de imagem não encontrado!'); history.go(-1)</script>";
	}

}else{
	echo "<script>alert('Arquivo inválido!'); history.go(-1)</script>";
}
?>