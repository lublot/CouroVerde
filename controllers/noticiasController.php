<?php
namespace controllers;

require_once dirname(__DIR__).'/vendor/autoload.php';

use \DAO\NoticiaDAO as NoticiaDAO;
use \DAO\UsuarioDAO as UsuarioDAO;
use \util\ValidacaoDados as ValidacaoDados;
use \models\Noticia as Noticia;
use exceptions\ErroUploadImagemException as ErroUploadImagemException;
use exceptions\CampoInvalidoException as CampoInvalidoException;
use exceptions\DadosCorrompidosException as DadosCorrompidosException;
use exceptions\NoticiaNaoEncontradaException as NoticiaNaoEncontradaException;
use util\VerificarPermissao as VerificarPermissao;

if(!isset($_SESSION)){session_start();}
class noticiasController extends mainController
{

    protected $dados = array();
    /**
    * Configura a classe para realização de testes.
    */
    public function configurarAmbienteParaTeste($titulo, $descricao, $subtitulo, $caminhoImagem, $nomeImagem, $post, $idNoticia = 0)
    {
        //seta valores necessários para o teste
        $_POST['titulo'] = $titulo;
        $_POST['descricao'] = $descricao;
        $_POST['subtitulo'] = $subtitulo;
        $_POST['idNoticia'] = $idNoticia;
        $_FILES["user_file"]["tmp_name"] = $caminhoImagem;
        $_FILES["user_file"]["name"] = $nomeImagem;

        $_POST['submit'] = $post;
    }


    public function index(){
        if(VerificarPermissao::isAdministrador() || VerificarPermissao::isFuncionario()){
            $this->carregarConteudo('homeNoticia',array());
        }else{
            $this->permissaoNegada();
        }
    }

    /**
    * Realiza o cadastro de uma notícia.
    */
    public function cadastrar(){
        if(VerificarPermissao::isAdministrador() || VerificarPermissao::podeCadastrarNoticia()){
            
            try{
                if (ValidacaoDados::validarForm($_POST,array('titulo','descricao','subtitulo'))) { //verifica se a variável superglobal foi setada
                    if (!ValidacaoDados::validarCampo($_POST['titulo'])) { //verifica se o campo está válido
                        throw new CampoInvalidoException('Por favor, verifique o título');
                    }

                    if (!ValidacaoDados::validarCampo($_POST['descricao'])) { //verifica se o campo está válido
                        throw new CampoInvalidoException('Por favor, verifique o conteúdo da notícia');
                    }
                   
                    try {
                        $caminhoImagem = $this->uploadImagem();
                    } catch (ErroUploadImagemException $e) {
                        $this->dados['exception'] = $e->getMessage();
                    }

                    $noticiaDAO = new NoticiaDAO();

                    $titulo = addslashes($_POST['titulo']);
                    $descricao = addslashes($_POST['descricao']);
                    $subtitulo = isset($_POST['subtitulo']) ? addslashes($_POST['subtitulo']) : null;
                    $data = addslashes(date('Y/m/d')); //obtém a data atual
                    $caminhoImagem = addslashes($caminhoImagem);
                    
                    $noticiaDAO->inserir(new Noticia(null, $titulo, $subtitulo, $descricao, $caminhoImagem, $data));
                    echo '<script>window.location.href = "'.ROOT_URL.'noticias"</script>';
                }  
            }catch(CampoInvalidoException $e){
                $this->dados['exception'] = $e->getMessage();
            }
            $this->carregarConteudo('cadastroNoticia',$this->dados);
        }else{
                $this->permissaoNegada();
        }          
    }

    public function gerenciar($parametro){
        if(VerificarPermissao::isAdministrador()){
            if(!empty($parametro[0])){
                $parametro = addslashes($parametro[0]);
                $noticiaDAO = new NoticiaDAO();
                $noticia = $noticiaDAO->buscar(array(),array("idNoticia"=>$parametro));

                if(count($noticia)>0){
                    $this->dados['noticia'] = $noticia[0];
                    $this->dados['podeGerenciarNoticia'] = VerificarPermissao::podeGerenciarNoticia();
                    $this->dados['podeRemoverNoticia'] = VerificarPermissao::podeRemoverNoticia();
                }else{
                    $this->dados['alerta'] = 'Nenhuma notícia foi encontrada';
                }
            }
            $this->carregarConteudo('gerenciarNoticia',$this->dados);
        }else{
            $this->permissaoNegada();
        }
    }

    public function remover(){
        
        if(ValidacaoDados::validarForm($_POST,array('senhaAdmin','idNoticia'))){  
            $idNoticia = $_POST['idNoticia'];
            $senha = md5($_POST['senhaAdmin']);

            $adminDAO = new UsuarioDAO();
            $adminDAO = $adminDAO->buscar(array('senha'),array("idUsuario"=>$_SESSION['id']));
            $senhaArmazenada = $adminDAO[0]->getSenha();

            if(strcmp($senhaArmazenada,$senha)==0){// Se a senha do administrador estiver correta, IMPLEMENTAR....
                $NoticiaDAO = new NoticiaDAO();
                $noticia = $NoticiaDAO->buscar(array(),array("idNoticia"=>$idNoticia));
                $NoticiaDAO->remover(array('idNoticia'=>$idNoticia));
                echo json_encode(array("success"=>true));
            }else{
                echo json_encode(array("success"=>false,"erro"=>"Senha Incorreta"));
            }
        }

    }
    
    /**
    * Realiza o upload de uma imagem.
    * @return String $caminhoImagem - caminho da imagem no diretório do sistema
    */
    private function uploadImagem()
    {

            $arqCaminho = "media/noticias/imagens/" . date("Ymd") . date("His") . basename($_FILES["imagem"]["name"]);
            $uploadOk = true;
            $extensaoImg = pathinfo($arqCaminho, PATHINFO_EXTENSION);
            
            //MUDAR O SUBMIT PRO NOME QUE VAI SER DEFINIDO NO BOTÃO DE UPLOAD
        if (isset($_POST["submit"])) { // checar se a imagem é real
            $checar = getimagesize($_FILES["imagem"]["tmp_name"]);
            if ($checar !== false) {
                $uploadOk = true;
            } else {
                $causa = "O arquivo enviado não é uma imagem";
                $uploadOk = false;
            }
        }

            //verifica se os formatos de imagem correspondem aos aceitos pelo sistema
        if (!isset($causa) && $extensaoImg != "jpg" && $extensaoImg != "png" && $extensaoImg != "jpeg" && $extensaoImg != "gif") {//apenas algumas extensões de imagem serão permitidas
            $causa = "Apenas imagens .jpg, .png, .jpeg e .gif são permitidas.";
            $uploadOk = false;
        }
            
        if ($uploadOk == false) {
            throw new ErroUploadImagemException($causa);
        } else {
            move_uploaded_file($_FILES["imagem"]["tmp_name"], $arqCaminho);
            $caminhoImagem = $arqCaminho;
        }

            return $caminhoImagem;
    }

    /**
    * Realiza a alteração de uma notícia cadastrada
    */
    public function gerenciarNoticia() {
        if (isset($_POST['idNoticia']) && !empty($_POST['idNoticia'])) {
            $idNoticia = addslashes($_POST['idNoticia']);
            $campos;

            if (isset($_POST['titulo'])) { //verifica se o campo foi enviado, ou seja, se o usuario deseja alterá-lo
                if (!ValidacaoDados::validarCampo($_POST['titulo'])) {  //verifica se o campo está válido
                    throw new CampoInvalidoException('titulo');
                }

                $campos['titulo'] = addslashes($_POST['titulo']);
            }

            if (isset($_POST['subtitulo'])) { //verifica se o campo foi enviado, ou seja, se o usuario deseja alterá-lo
                if (!ValidacaoDados::validarCampo($_POST['subtitulo'])) {  //verifica se o campo está válido
                    throw new CampoInvalidoException('subtitulo');
                }
                
                $campos['subtitulo'] = addslashes($_POST['subtitulo']);
            }

            if (isset($_POST['descricao'])) { //verifica se o campo foi enviado, ou seja, se o usuario deseja alterá-lo
                if (!ValidacaoDados::validarCampo($_POST['descricao'])) {  //verifica se o campo está válido
                    throw new CampoInvalidoException('descricao');
                }
                
                $campos['descricao'] = addslashes($_POST['descricao']);
            }

            $campos['data'] = addslashes(date('Y-m-d')); //obtém a data atual

            $noticiaDAO = new noticiaDAO();
            $noticiaDAO->alterar($campos, array('idNoticia'=>$idNoticia));
            echo json_encode(array('success'=>true));
        } else {
            echo json_encode(array('success'=>false,"erro"=>'Ocorreu um erro!'));
        }
    }

    /**
    * Realiza a busca de uma notícia.
    * @return Noticia $noticia - noticia obtida na busca
    */
    public function buscarNoticia()
    {
        if (isset($_POST["idNoticia"])) {
            $noticiaDAO = new NoticiaDAO();
            $noticia = $noticiaDAO->buscar(array(), array('idNoticia'=>$_POST['idNoticia']));

            if (count($noticia) > 0) { //Existe uma noticia correspondente ao ID pesquisado no banco de dados
                return $noticia[0];
            } else {
                throw new NoticiaNaoEncontradaException();
            }
        } else {
            throw new DadosCorrompidosException();
        }
    }

    /**
    * Realiza a remoção de uma notícia.
    */
    public function removerNoticia()
    {
        if (isset($_POST["idNoticia"])) {
             try {
                $this->buscarNoticia();
                $idNoticia = $_POST['idNoticia'];
                $noticiaDAO = new NoticiaDAO();
                $noticiaDAO->remover(array('idNoticia'=>$idNoticia));
             } catch (NoticiaNaoEncontradaException $e) {
                 throw $e;
             }
        } else {
            throw new DadosCorrompidosException();
        }
    }

    /**
    * Efetua a listagem de todas as notícias no banco de dados.
    */
    public function listarTodasNoticias() {
        $noticiaDAO = new noticiaDAO();
        $noticias = $noticiaDAO->buscar(array(), array());
        echo json_encode($noticias);
    }


}
