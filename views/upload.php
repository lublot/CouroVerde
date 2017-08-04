<?php
$uploaded = array();
header('Content-Type: application/json');
if(!empty($_FILES['file']['name'][0])){	
	$pastaImagem = '../media/obras/imagens/'.$_GET["inv"];
	mkdir($pastaImagem);	
	$pasta3D= '../media/obras/modelo3D/'.$_GET["inv"];
	mkdir($pasta3D);
		
	foreach($_FILES['file']['name'] as $position => $name){
		$ext = explode('.', $name)[1];
		if(strtoupper($ext) == "OBJ") {
			move_uploaded_file($_FILES['file']['tmp_name'][$position], $pasta3D . '/' . $name);
		} else {
			move_uploaded_file($_FILES['file']['tmp_name'][$position], $pastaImagem . '/' . $name);
		}
	}
}
?>