<?php
$uploaded = array();


if(!empty($_FILES['file']['name'][0])){	
	// Please implement security measures before deploying to production
		$pastaImagem = '../media/obras/imagens/'.$_GET["inv"];
		mkdir($pastaImagem);	
	foreach($_FILES['file']['name'] as $position => $name){
		if(move_uploaded_file($_FILES['file']['tmp_name'][$position], $pastaImagem . '/' . $name)){
		}
	}
}

?>