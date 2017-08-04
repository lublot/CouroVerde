<?php
$uploaded = array();
header('Content-Type: application/json');
<<<<<<< HEAD



=======
>>>>>>> beta2
if(!empty($_FILES['file']['name'][0])){	
	$pastaImagem = '../media/obras/imagens/'.$_GET["inv"];
	mkdir($pastaImagem);	
	$pasta3D= '../media/obras/modelo3D/'.$_GET["inv"];
	mkdir($pasta3D);
		
	foreach($_FILES['file']['name'] as $position => $name){
<<<<<<< HEAD
		$name = java.net.URLDecoder.decode($name, "UTF-8");
		$ext = explode('.', $name)[1];

=======
		$ext = explode('.', $name)[1];
>>>>>>> beta2
		if(strtoupper($ext) == "OBJ") {
			move_uploaded_file($_FILES['file']['tmp_name'][$position], $pasta3D . '/' . $name);
		} else {
			move_uploaded_file($_FILES['file']['tmp_name'][$position], $pastaImagem . '/' . $name);
		}

	}
}
?>