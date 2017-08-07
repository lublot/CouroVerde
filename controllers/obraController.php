<?php
namespace controllers;
require_once dirname(__DIR__).'/vendor/autoload.php';

use \exceptions\DadosCorrompidosException as DadosCorrompidosException;
use \exceptions\CampoInvalidoException as CampoInvalidoException;
use DAO\obraDAO as ObraDAO;
use \util\ValidacaoDados as ValidacaoDados;
use \util\GerenciarSenha as GerenciarSenha;
use \models\Obra as Obra;
use \models\Colecao as Colecao;
use \models\Classificacao as Classificacao;

class obraController extends mainController {

    /**
    * Configura a classe para realização de testes.
    */
    public function configurarAmbienteParaTeste($numInventario, $nome, $titulo, $funcao, $origem, $procedencia, $descricao, $idColecao, $idClassificacao,
                                                $altura, $largura, $diametro, $peso, $comprimento, $materiais, $tecnicas, $autoria, $marcas, $historico, 
                                                $modoAquisicao, $dataAquisicao, $autor, $observacoes, $estado)
    {
        //seta valores necessários para o teste
        $_POST['numInventario'] = $numInventario;
        $_POST['nome'] = $nome;
        $_POST['titulo'] = $titulo;
        $_POST['funcao'] = $funcao;
        $_POST['origem'] = $origem;
        $_POST['procedencia'] = $procedencia;
        $_POST['descricao'] = $descricao;
        $_POST['idColecao'] = $idColecao;
        $_POST['idClassificacao'] = $idClassificacao;
        $_POST['altura'] = $altura;
        $_POST['largura'] = $largura;
        $_POST['diametro'] = $diametro;
        $_POST['peso'] = $comprimento;
        $_POST['materiais'] = $materiais;
        $_POST['tecnicas'] = $autoria;
        $_POST['marcas'] = $marcas;
        $_POST['historico'] = $historico;
        $_POST['modoAquisicao'] = $modoAquisicao;
        $_POST['dataAquisicao'] = $dataAquisicao;
        $_POST['autor'] = $autor;
        $_POST['observacoes'] = $observacoes;
        $_POST['estado'] = $estado;

        $_POST['submit'] = $post;
    }
    // public function index() {
    //     if(isset($_POST["submit"])) {
    //         // if(ValidacaoDados::validarForm($_POST, array("colecao"))) {

    //         // }
    //     }
    // }
//colecao classificacao fotografo data-da-fotografia fotografia_autor
    public function cadastrarObra() {
        var_dump(isset($_POST));
        var_dump($_POST);
        var_dump(ValidacaoDados::validarForm($_POST, array("inventario", "nome", "titulo", "funcao", "origem", "procedencia", "descricao", "idColecao", "idClassificacao",
                                            "altura", "largura", "diametro", "peso", "comprimento", "materiais-constitutivos", "tecnicas-de-fabricacao", "autoria", "marcas-e-inscrições", "historico-do-objeto", 
                                            "modo-de-aquisicao", "data-de-aquisicao", "aquisicao_autor", "observacoes", "estado-de-conservacao")));
        if (isset($_POST) and ValidacaoDados::validarForm($_POST, array("inventario", "nome", "titulo", "colecao", "classificacao"))) {

            if(!ValidacaoDados::validarCampo($_POST['nome'])) { //verifica se o campo está válido
                throw new CampoInvalidoException('nome');
            }

            if(!ValidacaoDados::validarCampo($_POST['titulo'])) { //verifica se o campo está válido
                throw new CampoInvalidoException('titulo');
            }

            if(!ValidacaoDados::validarCampo($_POST['inventario'])) { //verifica se o campo está válido
                throw new CampoInvalidoException('inventario');
            }

            if(!ValidacaoDados::validarCampo($_POST['colecao'])) { //verifica se o campo está válido
                throw new CampoInvalidoException('coleção');
            }

            if(!ValidacaoDados::validarCampo($_POST['classificacao'])) { //verifica se o campo está válido
                throw new CampoInvalidoException('classificação');
            }                        

            if(isset($_POST['origem']) && $_POST['origem'] != '') {
                if(!ValidacaoDados::validarCampo($_POST['origem'])) { //verifica se o campo está válido
                    $origem = null;
                    throw new CampoInvalidoException('origem');
                } else {
                    $origem = addslashes($_POST['origem']);
                }
            } else {
                $origem = null;
            }

            if(isset($_POST['procedencia']) && $_POST['procedencia'] != '') {
                if(!ValidacaoDados::validarCampo($_POST['procedencia'])) { //verifica se o campo está válido
                    $procedencia = null;
                    throw new CampoInvalidoException('procedencia');
                } else {
                    $procedencia = addslashes($_POST['procedencia']);
                }
            } else {
                $procedencia = null;
            }            

            if(isset($_POST['funcao']) && $_POST['funcao'] != '') {
                if(!ValidacaoDados::validarCampo($_POST['funcao'])) { //verifica se o campo está válido
                    $funcao = null;
                    throw new CampoInvalidoException('funcao');
                } else {
                    $funcao = addslashes($_POST['funcao']);
                }
            } else {
                $funcao = null;
            }

            if(isset($_POST['descricao']) && $_POST['descricao'] != '') {
                if(!ValidacaoDados::validarCampo($_POST['descricao'])) { //verifica se o campo está válido
                    $descricao = null;
                    throw new CampoInvalidoException('descricao');
                } else {
                    $descricao = addslashes($_POST['descricao']);
                }
            } else {
                $descricao = null;
            }       

            if(isset($_POST['altura']) && $_POST['altura'] != '') {
                if(!ValidacaoDados::validarCampo($_POST['altura'])) { //verifica se o campo está válido
                    $altura = null;
                    throw new CampoInvalidoException('altura');
                } else {
                    $altura = addslashes($_POST['altura']);
                }
            } else {
                $altura = null;
            }

            if(isset($_POST['largura']) && $_POST['largura'] != '') {
                if(!ValidacaoDados::validarCampo($_POST['largura'])) { //verifica se o campo está válido
                    $largura = null;
                    throw new CampoInvalidoException('largura');
                } else {
                    $largura = addslashes($_POST['largura']);
                }
            } else {
                $largura = null;
            }            

            if(isset($_POST['diametro']) && $_POST['diametro'] != '') {
                if(!ValidacaoDados::validarCampo($_POST['diametro'])) { //verifica se o campo está válido
                    $diametro = null;
                    throw new CampoInvalidoException('diametro');
                } else {
                    $diametro = addslashes($_POST['diametro']);
                }
            } else {
                $diametro = null;
            }   

            if(isset($_POST['peso']) && $_POST['peso'] != '') {
                if(!ValidacaoDados::validarCampo($_POST['peso'])) { //verifica se o campo está válido
                    $peso = null;
                    throw new CampoInvalidoException('peso');
                } else {
                    $peso = addslashes($_POST['peso']);
                }
            } else {
                $peso = null;
            }   

            if(isset($_POST['comprimento']) && $_POST['comprimento'] != '') {
                if(!ValidacaoDados::validarCampo($_POST['comprimento'])) { //verifica se o campo está válido
                    $comprimento = null;
                    throw new CampoInvalidoException('comprimento');
                } else {
                    $comprimento = addslashes($_POST['comprimento']);
                }
            } else {
                $comprimento = null;
            }               
                
            if(isset($_POST['materiais-constitutivos']) && $_POST['materiais-constitutivos'] != '') {
                if(!ValidacaoDados::validarCampo($_POST['materiais-constitutivos'])) { //verifica se o campo está válido
                    $materiais = null;
                    throw new CampoInvalidoException('materiais constitutivos');
                } else {
                    $materiais = addslashes($_POST['materiais-constitutivos']);
                }
            } else {
                $materiais = null;
            }

            if(isset($_POST['tecnicas-de-fabricacao']) && $_POST['tecnicas-de-fabricacao'] != '') {
                if(!ValidacaoDados::validarCampo($_POST['tecnicas-de-fabricacao'])) { //verifica se o campo está válido
                    $tecnicas = null;
                    throw new CampoInvalidoException('tecnicas de fabricacao');
                } else {
                    $tecnicas = addslashes($_POST['tecnicas-de-fabricacao']);
                }
            } else {
                $tecnicas = null;
            }

            if(isset($_POST['marcas-e-inscrições']) && $_POST['marcas-e-inscrições'] != '') {
                if(!ValidacaoDados::validarCampo($_POST['marcas-e-inscrições'])) { //verifica se o campo está válido
                    $marcas = null;
                    throw new CampoInvalidoException('marcas e inscrições');
                } else {
                    $marcas = addslashes($_POST['marcas-e-inscrições']);
                }
            } else {
                $marcas = null;
            }

            if(isset($_POST['historico-do-objeto']) && $_POST['historico-do-objeto'] != '') {
                if(!ValidacaoDados::validarCampo($_POST['historico-do-objeto'])) { //verifica se o campo está válido
                    $historico = null;
                    throw new CampoInvalidoException('historico do objeto');
                } else {
                    $historico = addslashes($_POST['historico-do-objeto']);
                }
            } else {
                $historico = null;
            }

            if(isset($_POST['modo-de-aquisicao']) && $_POST['modo-de-aquisicao'] != '') {
                if(!ValidacaoDados::validarCampo($_POST['modo-de-aquisicao'])) { //verifica se o campo está válido
                    $modoAquisicao = null;
                    throw new CampoInvalidoException('modo de aquisicao');
                } else {
                    $modoAquisicao = addslashes($_POST['modo-de-aquisicao']);
                }
            } else {
                $modoAquisicao = null;
            }

            if(isset($_POST['data-de-aquisicao']) && $_POST['data-de-aquisicao'] != '') {
                if(!ValidacaoDados::validarCampo($_POST['data-de-aquisicao'])) { //verifica se o campo está válido
                    $dataAquisicao = null;
                    throw new CampoInvalidoException('data de aquisicao');
                } else {
                    $dataAquisicao = addslashes($_POST['data-de-aquisicao']);
                }
            } else {
                $dataAquisicao = null;
            }

            if(isset($_POST['autoria']) && $_POST['autoria'] != '') {
                if(!ValidacaoDados::validarCampo($_POST['autoria'])) { //verifica se o campo está válido
                    $autoria = null;
                    throw new CampoInvalidoException('autoria');
                } else {
                    $autoria = addslashes($_POST['autoria']);
                }
            } else {
                $autoria = null;
            }

            if(isset($_POST['aquisicao_autor']) && $_POST['aquisicao_autor'] != '') {
                if(!ValidacaoDados::validarCampo($_POST['aquisicao_autor'])) { //verifica se o campo está válido
                    $autor = null;
                    throw new CampoInvalidoException('aquisicao autor');
                } else {
                    $autor = addslashes($_POST['aquisicao_autor']);
                }
            } else {
                $autor = null;
            }

            if(isset($_POST['observacoes']) && $_POST['observacoes'] != '') {
                if(!ValidacaoDados::validarCampo($_POST['observacoes'])) { //verifica se o campo está válido
                    $observacoes = null;
                    throw new CampoInvalidoException('observacoes');
                } else {
                    $observacoes = addslashes($_POST['observacoes']);
                }
            } else {
                $observacoes = null;
            }                       

            if(isset($_POST['estado-de-conservacao']) && $_POST['estado-de-conservacao'] != '') {
                if(!ValidacaoDados::validarCampo($_POST['estado-de-conservacao'])) { //verifica se o campo está válido
                    $estado = null;
                    throw new CampoInvalidoException('estado-de-conservacao');
                } else {
                    $estado = addslashes($_POST['estado-de-conservacao']);
                }
            } else {
                $estado = null;
            }            

            
            $caminhosArquivos = $this->obterArquivos($_POST['inventario']);
            
            $caminhosImagens = $caminhosArquivos[0];
            $caminhoModelo3D = addslashes($caminhosArquivos[1]);
            
            $caminhoImagem1 = isset($caminhosImagens[0]) ? addslashes($caminhosImagens[0]) : null;
            $caminhoImagem2 = isset($caminhosImagens[1]) ? addslashes($caminhosImagens[1]) : null;
            $caminhoImagem3 = isset($caminhosImagens[2]) ? addslashes($caminhosImagens[2]) : null;
            $caminhoImagem4 = isset($caminhosImagens[3]) ? addslashes($caminhosImagens[3]) : null;
            $caminhoImagem5 = isset($caminhosImagens[4]) ? addslashes($caminhosImagens[4]) : null;

            $nome = addslashes($_POST["nome"]);
            $numInventario = addslashes($_POST["inventario"]);
            $titulo = addslashes($_POST["titulo"]);            
            $idColecao = addslashes($_POST["colecao"]);
            $idClassificacao = addslashes($_POST["classificacao"]);

            $obraDAO = new ObraDAO();
                
            $obraDAO->inserirObra(new Obra($numInventario, $nome, $titulo, $funcao, $origem, $procedencia, $descricao, $idColecao, $idClassificacao,
                                            $altura, $largura, $diametro, $peso, $comprimento, $materiais, $tecnicas, $autoria, $marcas, $historico, 
                                            $modoAquisicao, $dataAquisicao, $autor, $observacoes, $estado, $caminhoImagem1, $caminhoImagem2, $caminhoImagem3, $caminhoImagem4, $caminhoImagem5, $caminhoModelo3D));                                        

            $this->cadastrarPalavraChave();
            }
        else {
            throw new DadosCorrompidosException();
        }
    }

    private function obterArquivos($numInventario) {
        $caminhoPastaImages = dirname(__DIR__).'/media/obras/imagens/';
        $caminhoPastaImages .= $numInventario;

        $caminhoPastaModelo3D = dirname(__DIR__).'/media/obras/modelo3d/';
        $caminhoPastaModelo3D .= $numInventario; 

        var_dump($caminhoPastaImages);       

        $imagens = scandir($caminhoPastaImages); //obtém todos os arquivos da pasta
        $modelo3D = scandir($caminhoPastaModelo3D); //obtém todos os arquivos da pasta

        var_dump($modelo3D);

        unset($imagens[0]);
        unset($imagens[1]);
        
        unset($modelo3D[0]);
        unset($modelo3D[1]);

        $caminhosImagens = array();

        foreach($imagens as $imagem) {
            $caminhosImagens[] = $caminhoPastaImages . '/' . $imagem;
        }


        $caminhoModelo3D = $modelo3D[2];
        
        return array($caminhosImagens, $caminhoModelo3D);
    }    

    private function uploadImagem() {
        $arqCaminho = "media/obras/imagens/" . date("Ymd") . date("His") . basename($_FILES["user_file"]["name"]);
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

    /**
    * Realiza o cadastro de uma coleção.
    */
    public function cadastrarColecao() {
        if(isset($_POST) and ValidacaoDados::validarForm($_POST, array('nome'))) { //verifica se a variável superglobal foi setada
            if(!ValidacaoDados::validarCampo($_POST['nome'])) { //verifica se o campo está válido
                throw new CampoInvalidoException('nome');
            }

            $obraDAO = new obraDAO();
            $nome = addslashes($_POST['nome']);
            $obraDAO->inserirColecao(new Colecao(null, $nome));
        } else {
            throw new DadosCorrompidosException();
        }
    }

    /**
    * Realiza o cadastro de uma classificação.
    */
    public function cadastrarClassificacao() {
        if(isset($_POST) and ValidacaoDados::validarForm($_POST, array('nome'))) { //verifica se a variável superglobal foi setada
            if(!ValidacaoDados::validarCampo($_POST['nome'])) { //verifica se o campo está válido
                throw new CampoInvalidoException('nome');
            }

            $obraDAO = new obraDAO();
            $nome = addslashes($_POST['nome']);
            $obraDAO->inserirClassificacao(new Classificacao(null, $nome));
        } else {
            throw new DadosCorrompidosException();
        }
    }    


    /**
    * Este método remove uma obra do sistema
    */
    public function removerObra(){
        try{
            if(isset($_POST['senha']) && isset($_POST['filtro']) && isset($_POST['valorFiltro'])){

                $senhaReal = GerenciarSenha::criptografarSenha($_POST['senha']);
                $usuarioDAO = new UsuarioDAO();
                $usuarioDAO = $usuarioDAO->buscar(array(),array("idUsuario"=>$_SESSION['idUsuario']));

                if(count($usuarioDAO)>0){
                    $senhaArmazenada = $usuarioDAO[0]->getSenha();
                    if(GerenciarSenha::checarSenha($senhaArmazenada,$senhaReal)){
                        $obraDAO = new ObraDAO();
                        $obraDAO = $obraDAO->remover(array($_POST['filtro']=>$_POST['valorFiltro']));
                    }
                }
            }
        }catch(Exception $e){

        }
        
    }

    /**
    * Este método retorna um JSON com as classificações cadastradas no sistema
    */
    public function listarClassificacoes(){
        
        $obraDAO = new ObraDAO();
        $obraDAO = $obraDAO->buscarClassificacoes(array(),array());
        echo json_encode($obraDAO);
    }

    /**
    * Este método retorna um JSON com as coleções cadastradas no sistema
    */
    public function listarColecoes(){
        
        $obraDAO = new ObraDAO();
        $obraDAO = $obraDAO->buscarColecoes(array(),array());
        echo json_encode($obraDAO);
    }

    /**
    * Este metodo realiza edições nos campos da obra, verificando se estão dentro do padrão
    */
    public function gerenciarObra(){
        
        //Array com o nome dos campos
        $nomeCampos = array('nome', 'titulo', 'numInventario', 'idColecao', 'origem', 'procedencia',
         'idClassificacao', 'funcao', 'palavrasChave', 'descricao', 'altura', 'largura',
         'diametro', 'peso', 'comprimento', 'materiais', 'tecnicas', 'autoria', 'marcas',
         'historico', 'modoAquisicao', 'dataAquisicao', 'autor', 'observacoes', 'estado');

        if(isset($_SESSION['podeGerenciarObra'])){ //verifica se a variavel sessão possui podeCadastrarObra setada
            if($_SESSION['podeGerenciarObra']){ //verfica se o funcionario pode gerenciar obra
                
                if (isset($_POST["submit"]) && isset($_POST['numeroInventario'])){
                    $numeroInventario = addslashes($_POST['numeroInventario']);
                    $campos; //array para receber campos alterados

                    foreach($nomeCampos as $value){ //percorre o nome dos campos
                        if(isset($_POST[$value])){ //verifica se o campo foi modificado
                            if(!ValidacaoDados::validarCampo($_POST[$value])) { //verifica se o campo está válido
                                throw new CampoInvalidoException($value);
                            }

                            $campos [$value] = addslashes($_POST[$value]); //recebe o campo
                        }
                    }

                    $obraDAO = new obraDAO();
                    $obraDAO->alterar($campos, array('numeroInventario'=>$numeroInventario)); //atualiza os dados no banco
                }
            }else{
                throw new PermissaoNaoConcedidaException();
            }
        }

    }

    /**
    *Este método cadastra palavras-chave.
    */
    /*
    public function cadastrarPalavraChave() {
        if(isset($_POST["submit"]) and ValidacaoDados::validarForm($_POST, array('descricao'))) { //verifica se a variável superglobal foi setada
            if(!ValidacaoDados::validarCampo($_POST['descricao'])) { //verifica se o campo está válido
                throw new CampoInvalidoException('descricao');
            }

            $obraDAO = new obraDAO();

            $descricao = addslashes($POST['descricao']);

            $obraDAO->inserirPalavraChave(new PalavraChave(null, $descricao));
        } else {
            throw new DadosCorrompidosException();
        }
    }*/

    /**
    * Cadastra palavras chaves
    */
    public function cadastrarPalavraChave(){
        $numeroInventario = $_POST['inventario']; //pega o numero de inventario
        $palavrasChave = explode("#", $_POST['tags']); //pega as palavras chaves e transforma num array
        
        unset($palavrasChave[0]);

        $obraDAO = new obraDAO();

        foreach($palavrasChave as $value){
            $obraDAO->inserirPalavraChave($numeroInventario, $value);   
        }
    }

    /**
    * Obtém as coleções cadastradas no sistema.
    */
    public function obterColecoes() {
        $obraDAO = new ObraDAO();
        return $obraDAO->buscarColecoes(array(), array());
    }

    /**
    * Obtém uma coleção a partir do seu id.
    * @param unknown $idColecao - o id da coleção.
    */
    public function obterColecao($idColecao) {
        $obraDAO = new ObraDAO();
        return $obraDAO->buscarColecoes(array(), array("idColecao" => $idColecao));
    }

    /**
    * Obtém as classificações cadastradas no sistema.
    */
    public function obterClassificacoes() {
        $obraDAO = new ObraDAO();
        return $obraDAO->buscarClassificacao(array(), array());
    }    

    /**
    * Obtém uma classificação a partir do seu id.
    * @param unknown $idColecao - o id da coleção.
    */
    public function obterClassificacao($idClassificacao) {
        $obraDAO = new ObraDAO();
        return $obraDAO->buscarClassificacao(array(), array("idClassificacao" => $idClassificacao));
    }    
}


    

?>