<?php
namespace controllers;
class GaleriaController extends mainController {

    public function index() {
        $this->carregarConteudo("galeria", array());
    }
}