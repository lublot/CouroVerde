<?php
namespace controllers;

use DAO\NoticiaDAO as NoticiaDAO;
use models\Noticia as Noticia;
class homeController extends mainController{

    protected $dados = array();
    public function index(){
        $noticiaDAO = new NoticiaDAO();
        $noticia = $noticiaDAO->buscarMaisRecente(array(),array(),3);
        $this->dados['noticias'] = $noticia;
        $this->carregarConteudo('home',$this->dados);
    }

    
}



?>