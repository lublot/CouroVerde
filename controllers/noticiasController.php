<?php
namespace controllers;
require_once dirname(__DIR__).'/vendor/autoload.php';
use util\GerenciarSenha as GerenciarSenha;
use \DAO\usuarioDAO as usuarioDAO;
use \util\ValidacaoDados as ValidacaoDados;
use exceptions\UsuarioInexistenteException as UsuarioInexistenteException;
use exceptions\SenhaInvalidaException as SenhaInvalidaException;
use exceptions\EmailInvalidoException as EmailInvalidoException;
use exceptions\AcessoExternoNegadoException as AcessoExternoNegadoException;

class noticiasController extends mainController{
    public function cadastrarNoticia() {
        if(isset($_POST['titulo']) && isset($_POST['descricao'])) {
            $noticiaDAO = new noticiaDAO();

            $titulo = addslashes($POST['titulo']);
            $descricao = addslashes($POST['descricao']);
            $subtitulo = isset($_POST['subtitulo']) ? addslashes($_POST['subtitulo']) : null;

            $noticiaDAO->inserir()
        }
    }
}
