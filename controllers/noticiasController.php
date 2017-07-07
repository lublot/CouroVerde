<?php
namespace controllers;
require_once dirname(__DIR__).'/vendor/autoload.php';

use \DAO\noticiaDAO as noticiaDAO;
use \util\ValidacaoDados as ValidacaoDados;
use \models\Noticia as Noticia;
use exceptions\CampoNoticiaInvalidoException as CampoNoticiaInvalidoException;
use exceptions\DadosCorrompidosException as DadosCorrompidosException;
use exceptions\NoticiaNaoEncontradaException as NoticiaNaoEncontradaException;


class noticiasController extends mainController{

    public function configurarAmbienteParaTeste($titulo, $descricao, $subtitulo, $caminhoImagem, $nomeImagem, $post) {
        //seta valores necessários para o teste
        $_POST['titulo'] = $titulo;
        $_POST['descricao'] = $descricao;
        $_POST['subtitulo'] = $subtitulo;
        $_FILES["user_file"]["tmp_name"] = $caminhoImagem;
        $_FILES["user_file"]["name"] = $nomeImagem;

        $_POST['submit'] = $post;

    }

    /**
    * Realiza o cadastro de uma notícia.
    */
    public function cadastrarNoticia() {
        if(isset($_POST["submit"]) and ValidacaoDados::validarForm($_POST, array('titulo', 'descricao'))) { //verifica se a variável superglobal foi setada
            if(!ValidacaoDados::validarCampo($_POST['titulo'])) { //verifica se o campo está válido
                throw new CampoNoticiaInvalidoException('titulo');
            } 

            if(!ValidacaoDados::validarCampo($_POST['descricao'])) { //verifica se o campo está válido
                throw new CampoNoticiaInvalidoException('descricao');
            }             

            if(isset($_POST['subtitulo'])) { //como o campo subtitulo não é obrigatório, primeiro checa se foi setado
                if(!ValidacaoDados::validarCampo($_POST['subtitulo'])) {  //verifica se o campo está válido
                    throw new CampoNoticiaInvalidoException('subtitulo');
                }                 
            }

            try {
                $caminhoImagem = $this->uploadImagem();
            } catch (ErroUploadImagemException $e) {
                throw $e;
            }

            $noticiaDAO = new noticiaDAO();

            $titulo = addslashes($_POST['titulo']);
            $descricao = addslashes($_POST['descricao']);
            $subtitulo = isset($_POST['subtitulo']) ? addslashes($_POST['subtitulo']) : null;
            $data = addslashes(date('Y/m/d')); //obtém a data atual
            $caminhoImagem = addslashes($caminhoImagem);

            $noticiaDAO->inserir(new Noticia(null, $titulo, $subtitulo, $descricao, $caminhoImagem, $data));
        } else {
            throw new DadosCorrompidosException();
        }
    }

    /**
    * Realiza o upload de uma imagem.
    * @param String $caminhoImagem - caminho da imagem no diretório do sistema    
    */    
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

            //verifica se os formatos de imagem correspondem aos aceitos pelo sistema
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

    /**
    * Realiza a alteração de uma notícia cadastrada
    */    
    public function alterarNoticia(){
        if(isset($_POST["submit"])){
            
            if(isset($_POST['titulo'])) { //verifica se o campo foi enviado, ou seja, se o usuario deseja alterá-lo
                if(!ValidacaoDados::validarCampo($_POST['titulo'])) {  //verifica se o campo está válido
                    throw new CampoNoticiaInvalidoException('titulo');
                }                 
            }

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

            $idNoticia = addslashes($POST['idNoticia']);
            $titulo = addslashes($POST['titulo']);
            $descricao = addslashes($POST['descricao']);
            $subtitulo = isset($_POST['subtitulo']) ? addslashes($_POST['subtitulo']) : null;
            $data = addslashes(date('d-m-y')); //obtém a data atual
            $caminhoImagem = addslashes($caminhoImagem);

            $campos = array('idNoticia'=> $idNoticia ? $idNoticia : null,
                            'titulo'=> $titulo ? $titulo : null,
                            'subtitulo'=> $subtitulo ? $subtitulo: null,
                            'descricao'=>$descricao ? $descricao : null,
                            'caminhoImagem'=>$caminhoImagem ? $caminhoImagem : null,
                            'data'=>$data ? $data : null);

            $noticiaDAO->alterar($campos,array('idNoticia'=>$idNoticia));
        } else {
            throw new DadosCorrompidosException();
        }

    }

    public function buscarNoticia(){
        if(isset($_POST["submit"])) {
            $noticiaDAO = new noticiaDAO();
            $noticia = $noticiaDAO->buscar(array(),array('idNoticia'=>$_POST['idNoticia']));

            if(count($noticia) > 0){ //Existe uma noticia correspondente ao ID pesquisado no banco de dados
                $idNoticia = $noticia[0]->getidNoticia();
                $titulo = $noticia[0]->getTitulo();
                $$descricao = $noticia[0]->getDescricao();
                $subtitulo = $noticia[0]->getCaminhoImagem();
                $data = $noticia[0]->getData();
                $caminhoImagem = $noticia[0]->getCaminhoImagem();

            $campos = array('idNoticia'=> $idNoticia ? $idNoticia : null,
                            'titulo'=> $titulo ? $titulo : null,
                            'subtitulo'=> $subtitulo ? $subtitulo: null,
                            'descricao'=>$descricao ? $descricao : null,
                            'caminhoImagem'=>$caminhoImagem ? $caminhoImagem : null,
                            'data'=>$data ? $data : null);
                return $campos;
            } else {
            throw new NoticiaNaoEncontradaException();
            }
        } 

    }

    public function removerNoticia(){
        if(isset($_POST["submit"])) {
            $noticiaDAO = new noticiaDAO();
            $noticia = $noticiaDAO->buscar(array(),array('idNoticia'=>$_POST['idNoticia']));
        }
            if(count($noticia) > 0){
                $idNoticia = $noticia[0]->getidNoticia();
                $noticiaDAO->remover(array('idNoticia'=>$idNoticia));
            }
    }

    public function listarTodasNoticias(){
        $noticiaDAO = new noticiaDAO();
        $noticias = $noticiaDAO->buscar();
        echo json_encode($noticias);
    }
}
