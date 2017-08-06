<?php
$uploaded = array();
header('Content-Type: application/json');
if(!empty($_FILES['file']['name'][0])){	
	$pastaImagem = '../media/obras/imagens/'.$_GET["inv"];
	mkdir($pastaImagem);	
	$pasta3D= '../media/obras/modelo3D/'.$_GET["inv"];
	mkdir($pasta3D);

	ob_start();
	var_dump($_FILES);
	$result = ob_get_clean();

	$myfile = fopen("C:\wamp64\www\sertour\media\obras/newfile.html", "w");
	fwrite($myfile, $result);
	fclose($myfile);	

		
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
?>