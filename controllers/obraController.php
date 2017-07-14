<?php
namespace controllers;

use \exceptions\DadosCorrompidosException as DadosCorrompidosException;
use \exceptions\CampoInvalidoException as CampoInvalidoException;
use DAO\obraDAO as ObraDAO;
use \util\ValidacaoDados as ValidacaoDados;
use \util\GerenciarSenha as GerenciarSenha;
use \models\Obra as Obra;

class obraController extends mainController {

    public function cadastrarObra() {
        if (isset($_POST["submit"]) and ValidacaoDados::validarForm($_POST, array("nome", "titulo", "numInventario", "idColecao", "origem", "procedencia", "idClassificacao",
                                                        "funcao", "palavrasChave", "descricao", "altura", "largura", "diametro", "peso", "comprimento", "materiais",
                                                        "tecnicas", "autoria", "marcas", "historico", "modoAquisicao", "dataAquisicao", "autor", "observacoes",
                                                        "estado", "caminhoImagem1", "caminhoImagem2", "caminhoImagem3", "caminhoImagem4", "caminhoImagem5", "caminhoModelo3D"))) {

            try {
                $caminhoImagem1 = uploadImagem();
                $caminhoImagem2 = uploadImagem();
                $caminhoImagem3 = uploadImagem();
                $caminhoImagem4 = uploadImagem();
                $caminhoImagem5 = uploadImagem();
                $caminhoModelo3D = uploadImagem(); //Ainda não concluído
            } catch (ErroUploadImagemException $e) {
                throw $e;
            }

            if(!ValidacaoDados::validarCampo($_POST['nome'])) { //verifica se o campo está válido
                throw new CampoInvalidoException('nome');
            }

            if(!ValidacaoDados::validarCampo($_POST['titulo'])) { //verifica se o campo está válido
                throw new CampoInvalidoException('titulo');
            }

            if(!ValidacaoDados::validarCampo($_POST['numInventario'])) { //verifica se o campo está válido
                throw new CampoInvalidoException('numInventario');
            }

            if(!ValidacaoDados::validarCampo($_POST['origem'])) { //verifica se o campo está válido
                throw new CampoInvalidoException('origem');
            }

            if(!ValidacaoDados::validarCampo($_POST['procedencia'])) { //verifica se o campo está válido
                throw new CampoInvalidoException('procedencia');
            }

            if(!ValidacaoDados::validarCampo($_POST['funcao'])) { //verifica se o campo está válido
                throw new CampoInvalidoException('funcao');
            }

            if(!ValidacaoDados::validarCampo($_POST['palavrasChave'])) { //verifica se o campo está válido
                throw new CampoInvalidoException('palavrasChave');
            }

            if(!ValidacaoDados::validarCampo($_POST['descricao'])) { //verifica se o campo está válido
                throw new CampoInvalidoException('descricao');
            }

            if(!ValidacaoDados::validarCampo($_POST['altura'])) { //verifica se o campo está válido
                throw new CampoInvalidoException('altura');
            }

            if(!ValidacaoDados::validarCampo($_POST['largura'])) { //verifica se o campo está válido
                throw new CampoInvalidoException('largura');
            }

            if(!ValidacaoDados::validarCampo($_POST['diametro'])) { //verifica se o campo está válido
                throw new CampoInvalidoException('diametro');
            }

            if(!ValidacaoDados::validarCampo($_POST['peso'])) { //verifica se o campo está válido
                throw new CampoInvalidoException('peso');
            }

            if(!ValidacaoDados::validarCampo($_POST['comprimento'])) { //verifica se o campo está válido
                throw new CampoInvalidoException('comprimento');
            }

            if(!ValidacaoDados::validarCampo($_POST['materiais'])) { //verifica se o campo está válido
                throw new CampoInvalidoException('materiais');
            }

            if(!ValidacaoDados::validarCampo($_POST['tecnicas'])) { //verifica se o campo está válido
                throw new CampoInvalidoException('tecnicas');
            }

            if(!ValidacaoDados::validarCampo($_POST['autoria'])) { //verifica se o campo está válido
                throw new CampoInvalidoException('autoria');
            }

            if(!ValidacaoDados::validarCampo($_POST['marcas'])) { //verifica se o campo está válido
                throw new CampoInvalidoException('marcas');
            }

            if(!ValidacaoDados::validarCampo($_POST['historico'])) { //verifica se o campo está válido
                throw new CampoInvalidoException('historico');
            }

            if(!ValidacaoDados::validarCampo($_POST['modoAquisicao'])) { //verifica se o campo está válido
                throw new CampoInvalidoException('modoAquisicao');
            }

            if(!ValidacaoDados::validarCampo($_POST['dataAquisicao'])) { //verifica se o campo está válido
                throw new CampoInvalidoException('dataAquisicao');
            }

            if(!ValidacaoDados::validarCampo($_POST['autor'])) { //verifica se o campo está válido
                throw new CampoInvalidoException('autor');
            }

            if(!ValidacaoDados::validarCampo($_POST['observacoes'])) { //verifica se o campo está válido
                throw new CampoInvalidoException('observacoes');
            }

            if(!ValidacaoDados::validarCampo($_POST['estado'])) { //verifica se o campo está válido
                throw new CampoInvalidoException('estado');
            }

            $nome = addslashes($_POST["nome"]);
            $titulo = addslashes($_POST["titulo"]);
            $numInventario = addslashes($_POST["numInventario"]);
            $idColecao = $_POST["idColecao"];
            $origem = addslashes($_POST["origem"]);
            $procedencia = addslashes($_POST["procedencia"]);
            $idClassificacao = $_POST["idClassificacao"];
            $funcao = addslashes($_POST["funcao"]);
            $palavrasChave = addslashes($_POST["palavrasChave"]);
            $descricao = addslashes($_POST["descricao"]);
            $altura = addslashes($_POST["altura"]);
            $largura = addslashes($_POST["largura"]);
            $diametro = addslashes($_POST["diametro"]);
            $peso = addslashes($_POST["peso"]);
            $comprimento = addslashes($_POST["comprimento"]);
            $materiais = addslashes($_POST["materiais"]);
            $tecnicas = addslashes($_POST["tecnicas"]);
            $autoria = addslashes($_POST["autoria"]);
            $marcas = addslashes($_POST["marcas"]);
            $historico = addslashes($_POST["historico"]);
            $modoAquisicao = addslashes($_POST["modoAquisicao"]);
            $dataAquisicao = addslashes($_POST["dataAquisicao"]);
            $autor = addslashes($_POST["autor"]);
            $observacoes = addslashes($_POST["observacoes"]);
            $estado = addslashes($_POST["estado"]);
            $caminhoImagem1 = addslashes($caminhoImagem1);
            $caminhoImagem2 = addslashes($caminhoImagem2);
            $caminhoImagem3 = addslashes($caminhoImagem3);
            $caminhoImagem4 = addslashes($caminhoImagem4);
            $caminhoImagem5 = addslashes($caminhoImagem5);
            $caminhoModelo3D = addslashes($caminhoModelo3D);

            $obraDAO = new ObraDAO();
                
            $obraDAO->inserirObra(new Obra(null, $nome, $titulo, $numInventario, $idColecao, $origem, $procedencia, $idClassificacao, $funcao, 
                                    $palavrasChave, $descricao, $altura, $largura, $diametro, $peso, $comprimento, $materiais, 
                                    $tecnicas, $autoria, $marcas, $historico, $modoAquisicao, $dataAquisicao, $autor, $observacoes,
                                    $estado, $caminhoImagem1, $caminhoImagem2, $caminhoImagem3, $caminhoImagem4, $caminhoImagem5, $caminhoModelo3D));
            }
        else {
            throw new DadosCorrompidosException();
        }
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

    public function cadastrarColecao() {
        if(isset($_POST["submit"]) and ValidacaoDados::validarForm($_POST, array('nome'))) { //verifica se a variável superglobal foi setada
            if(!ValidacaoDados::validarCampo($_POST['nome'])) { //verifica se o campo está válido
                throw new CampoInvalidoException('nome');
            }

            $obraDAO = new obraDAO();

            $nome = addslashes($POST['nome']);

            $obraDAO->inserirColecao(new Colecao(null, $nome));
        } else {
            throw new DadosCorrompidosException();
        }
    }

    public function cadastrarClassificacao() {
        if(isset($_POST["submit"]) and ValidacaoDados::validarForm($_POST, array('nome'))) { //verifica se a variável superglobal foi setada
            if(!ValidacaoDados::validarCampo($_POST['nome'])) { //verifica se o campo está válido
                throw new CampoInvalidoException('nome');
            }

            $obraDAO = new obraDAO();

            $nome = addslashes($POST['nome']);

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
    *Este metodo realiza edições nos campos da obra, verificando se estão dentro do padrão
    */
    public function gerenciarObra(){
        
        //Array com o nome dos campos
        $nomeCampos = array('nome', 'titulo', 'numInventario', 'idColecao', 'origem', 'procedencia',
         'idClassificacao', 'funcao', 'palavrasChave', 'descricao', 'altura', 'largura',
         'diametro', 'peso', 'comprimento', 'materiais', 'tecnicas', 'autoria', 'marcas',
         'historico', 'modoAquisicao', 'dataAquisicao', 'autor', 'observacoes', 'estado');


        if (isset($_POST["submit"]) && isset($_POST['numeroInventario'])){
            $numeroInventario = addslashes($_POST['numeroInventario']);
            $campos; //array para receber campos alterados

            foreach($nomeCampos as $value){ //percorre o nome dos campos
                if(isset($_POST[value])){ //verifica se o campo foi modificado
                    if(!ValidacaoDados::validarCampo($_POST[value])) { //verifica se o campo está válido
                        throw new CampoInvalidoException(value);
                    }

                    $campos [value] = addslashes($_POST[value]); //recebe o campo
                }
            }

            $obraDAO = new obraDAO();
            $obraDAO->alterar($campos, array('numeroInventario'=>$numeroInventario));
        }
    }
}


    

?>