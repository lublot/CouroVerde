<?php

    //Script de Configuração de Credenciais
    require_once 'autoload.php';

    $scriptUri = "http://".$_SERVER["HTTP_HOST"].$_SERVER['PHP_SELF'];
    $client = new Google_Client();
    $client->setAccessType('online'); // default: offline
    $client->setApplicationName('WebMuseu - Casa do Sertão');
    $client->setClientId('175968974460-seagsbc9m8j2mo1b2fma9fi7c3gkcddj.apps.googleusercontent.com');
    $client->setClientSecret('L5sQGB1hwfS6pR8HMJW-qUOZ');
    $client->setRedirectUri($scriptUri);
    $client->setDeveloperKey('AIzaSyBPLSPXghr-YbuDanxpk9KldMsKhC-Ap5k'); // API key
    $client->addScope('https://www.googleapis.com/auth/plus.login');
    $client->addScope('https://www.googleapis.com/auth/plus.profile.emails.read');

?>