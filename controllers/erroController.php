<?php

namespace controllers;

class erroController extends mainController{

    public function index(){
        $this->carregarConteudo('erro404',array());
    }

    public function acesso(){
        $this->carregarConteudo('permissaoNegada',array());
    }
}
?>