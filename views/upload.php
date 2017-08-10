<?php

$uploaded = array();
header('Content-Type: application/json');
if(!empty($_FILES['file']['name'][0])){	
	$pastaImagem = dirname(__DIR__).'/media/obras/imagens/'.$_GET["inv"];
	mkdir($pastaImagem);	
	$pasta3D= dirname(__DIR__).'/media/obras/modelo3D/'.$_GET["inv"];
	mkdir($pasta3D);

	foreach($_FILES['file']['name'] as $position => $name){
		$name = mb_convert_encoding($name, "Windows-1252", "UTF-8");
		$ext = explode('.', $name)[1];
		if(strtoupper($ext) == "OBJ") {
			move_uploaded_file($_FILES['file']['tmp_name'][$position], $pasta3D . '/' . $name);
		} else {
			move_uploaded_file($_FILES['file']['tmp_name'][$position], $pastaImagem . '/' . $name);
		}
	}
}
echo json_encode(array('sucesso' => true));
?>