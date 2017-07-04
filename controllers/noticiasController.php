<?php
namespace controllers;
require_once dirname(__DIR__).'/vendor/autoload.php';

use \DAO\noticiaDAO as noticiaDAO;
use \util\ValidacaoDados as ValidacaoDados;
use exceptions\CampoNoticiaInvalidoException as CampoNoticiaInvalidoException;
use exceptions\DadosCorrompidosException as DadosCorrompidosException;


class noticiasController extends mainController{

    public function cadastrarNoticia() {
        if(isset($_POST["submit"]) and ValidacaoDados::validarForm($_POST, array('titulo', 'descricao'))) { //verifica se a variável superglobal foi setada
            if(!ValidacaoDados::validarCampo($_POST['titulo'])) { //verifica se o campo está válido
                throw new CampoNoticiaInvalidoException('titulo');
            } 

            if(!ValidacaoDados::validarCampo($_POST['descricao'])) { //verifica se o campo está válido
                throw new CampoNoticiaInvalidoException('descricao');
            }             

            if(isset($_POST['subtitulo'])) {
                if(!ValidacaoDados::validarCampo($_POST['subtitulo'])) {  //verifica se o campo está válido
                    throw new CampoNoticiaInvalidoException('subtitulo');
                }                 
            }

            try {
                $caminhoImagem = uploadImagem();
            } catch (ErroUploadImagemException $e) {
                throw $e;
            }

            $noticiaDAO = new noticiaDAO();

            $titulo = addslashes($POST['titulo']);
            $descricao = addslashes($POST['descricao']);
            $subtitulo = isset($_POST['subtitulo']) ? addslashes($_POST['subtitulo']) : null;
            $data = addslashes(date('d-m-y')); //obtém a data atual
            $caminhoImagem = addslashes($caminhoImagem);

            $noticiaDAO->inserir(new Noticia(null, $titulo, $subtitulo, $descricao, $caminhoImagem, $data));
        } else {
            throw new DadosCorrompidosException();
        }
    }

    private function uploadImagem() {
            $arqCaminho = "media/noticias/imagens/" . date("Ymd") . date("His") . basename($_FILES["user_file"]["name"]);
            $uploadOk = true;
            $extensaoImg = pathinfo($arqCaminho, PATHINFO_EXTENSION);
            
            if(isset($_POST["submit"])) { // checar se a imagem é real
                $checar = getimagesize($_FILES["user_file"]["tmp_name"]);
                if($checar !== false) {
                    $uploadOk = true;
                } else {
                    $causa = "O arquivo enviado não é uma imagem";
                    $uploadOk = false;
                }
            }

            if(!isset($causa) && $extensaoImg != "jpg" && $extensaoImg != "png" && $extensaoImg != "jpeg" && $extensaoImg != "gif" ) {//apenas algumas extensões de imagem serão permitidas
                $causa = "Apenas imagens .jpg, .png, .jpeg e .gif são permitidas.";
                $uploadOk = false;
            }
            
            if ($uploadOk == false) {
                throw new ErroUploadImagemException($causa);
            } else {
                move_uploaded_file($_FILES["user_file"]["tmp_name"], $arqCaminho);
                $caminhoImagem = $arqCaminho;                    
            }

            return $caminhoImagem;        
    }

    public function alterarNoticia(){
        if(isset($_POST["submit"]) and ValidacaoDados::validarForm($_POST, array('titulo', 'descricao'))){
            if(!ValidacaoDados::validarCampo($_POST['titulo'])) { //verifica se o campo está válido
                throw new CampoNoticiaInvalidoException('titulo');
            }
            if(!ValidacaoDados::validarCampo($_POST['descricao'])) { //verifica se o campo está válido
                throw new CampoNoticiaInvalidoException('descricao');
            }             

            if(isset($_POST['subtitulo'])) {
                if(!ValidacaoDados::validarCampo($_POST['subtitulo'])) {  //verifica se o campo está válido
                    throw new CampoNoticiaInvalidoException('subtitulo');
                }                 
            }
            
            try {
                $caminhoImagem = uploadImagem();
            } catch (ErroUploadImagemException $e) {
                throw $e;
            }

            $noticiaDAO = new noticiaDAO();

            $titulo = addslashes($POST['titulo']);
            $descricao = addslashes($POST['descricao']);
            $subtitulo = isset($_POST['subtitulo']) ? addslashes($_POST['subtitulo']) : null;
            $data = addslashes(date('d-m-y')); //obtém a data atual
            $caminhoImagem = addslashes($caminhoImagem);

            $campos = array('idNoticia'=>null,
                            'titulo'=> $titulo ? null,
                            'subtitulo'=> $subtitulo ? null,
                            'descricao'=>$descricao ? null,
                            'caminhoImagem'=>$caminhoImagem ? null,
                            'data'=>$data ? null);

            $noticiaDAO->alterar($campos,array('titulo'=>$titulo));
        } else {
            throw new DadosCorrompidosException();
        }

    }

    public function buscarNoticia(){

    }

    public function removerNoticia(){

    }
}
