<?php
namespace controllers;

require_once dirname(__DIR__).'/vendor/autoload.php';
use DAO\PesquisaDAO as PesquisaDAO;
use DAO\PerguntaDAO as PerguntaDAO;
use DAO\OpcaoDAO as OpcaoDAO;
use \util\ValidacaoDados as ValidacaoDados;
use \models\Pesquisa as Pesquisa;
use \models\Pergunta as Pergunta;
use \models\Opcao as Opcao;
use \models\OpcaoPergunta as OpcaoPergunta;
use \exceptions\DadosCorrompidosException as DadosCorrompidosException;
use \exceptions\NomeInvalidoException as NomeInvalidoException;
use \exceptions\CampoInvalidoException as CampoInvalidoException;
use \exceptions\PerguntaInconsistenteException as PerguntaInconsistenteException;
use \exceptions\PesquisaJaExistenteException as PesquisaJaExistenteException;

class pesquisaController extends mainController{


  protected $dados = array();

  public function index(){
  
    
  }
  
  /**
  * Este método carrega a página responsável pelo cadastro da pesquisa
  */
  public function cadastrar(){
    $this->carregarConteudo('cadastroPesquisa',$this->dados); 
  }


  /**
  * Este método, de fato, cria a pesquisa. É utilizado pela requisição AJAX.
  */
  public function criar(){
    
    try{
      $json = $_POST['json']; //Recebe os dados da view
      $dadosRecebidos = json_decode($json,true); //Decodifica o JSON
    
      if(ValidacaoDados::validarForm($dadosRecebidos,array("tituloPesquisa"))){// Verifica se os campos existem
          $tituloPesquisa = array_shift($dadosRecebidos);//Recebe o titulo da pesquisa
          $descricaoPesquisa = array_shift($dadosRecebidos);//Recebe a descrição da pesquisa
          
          
          

          $perguntas = array(); //Este array vai conter todas as perguntas a serem adicionadas;

          while(count($dadosRecebidos)> 0){ // Itera o array dos dados recebidos para organizar as informações
              $pergunta = array_shift($dadosRecebidos)[0];//Retira a pergunta do array recebido
              $perguntaFinal = array();

              if(strlen($tituloPesquisa)==0 || ValidacaoDados::campoVazio($tituloPesquisa)){ // Verifica se a string do titulo está vazia
                $tituloPesquisa = "Sem título";
              }

              if(!isset($descricaoPesquisa) || strlen($descricaoPesquisa)==0 || ValidacaoDados::campoVazio($descricaoPesquisa)){// Verifica se a string da descrição está vazia
                $descricaoPesquisa = "Sem descrição";
              }

              if(empty($pergunta['tipoPergunta']) || ValidacaoDados::campoVazio($pergunta['tipoPergunta'])){ //Verifica se o tipo da pergunta foi informado
                  throw new DadosCorrompidosException();  
              }

              if(strlen($pergunta['tituloPergunta'])==0 || ValidacaoDados::campoVazio($pergunta['tituloPergunta'])){//Verifica se a pergunta possui um título
                throw new PerguntaInconsistenteException();
              }else{
                $tituloPergunta = $pergunta['tituloPergunta'];
                $tipoPergunta = $pergunta['tipoPergunta'];
                $isObrigatorio = $pergunta['obrigatorio'];
              }

              $opcoes;
              
              $perguntaFinal['pergunta']  = new Pergunta(null,$tituloPergunta,$tipoPergunta,$isObrigatorio); //Cria um objeto pergunta

              if(strcmp($tipoPergunta,"Aberta")!=0){// Guarda as opções no array, caso existam
                if(ValidacaoDados::validarForm($pergunta,array("opcoes"))){
                  $opcoes = $pergunta['opcoes'];
                  $perguntaFinal['opcoes'] = !empty($opcoes)?$opcoes:null;
                }
              }
              
              array_push($perguntas,$perguntaFinal);//Insere a pergunta no array de perguntas
          }//Fim do while

          
          //Cria a pesquisa e guarda no banco
          $pesquisa = new Pesquisa(null,$tituloPesquisa,$descricaoPesquisa,false); // Inicializa a pesquisa, ao ser criada a pesquisa ainda não é ativada
          
          $pesquisaDAO = new PesquisaDAO();

          $buscarPesquisa = $pesquisaDAO->buscar(array("idPesquisa"),array("titulo"=>$tituloPesquisa));
          
          if(count($buscarPesquisa) == 0){
            $pesquisaDAO->inserir($pesquisa);
          }else{
              throw new PesquisaJaExistenteException();
          }
         

          $pesquisaDAO = new PesquisaDAO(); //Recupera o ID da Pesquisa
          $idPesquisa = $pesquisaDAO->buscar(array("idPesquisa"),array("titulo"=>$tituloPesquisa));
          $idPesquisa = $idPesquisa[0]->getIdPesquisa();

          $perguntaDAO = new PerguntaDAO();
          $opcaoDAO = new OpcaoDAO();
          foreach($perguntas as $pergunta){
            $perguntaDAO->inserir($pergunta['pergunta'],$idPesquisa);
            $idPergunta = $perguntaDAO->getIdUltimaPergunta();
            
            if(isset($pergunta['opcoes'])){// Se a pergunta tiver opções
              $opcoes = $pergunta['opcoes'];
              foreach($opcoes as $opcao){
                $opcaoDAO->inserir(new Opcao(null,$opcao),$idPergunta);
              }//Fim foreach
            }// Fim if
          }//Fim foreach
        }// Fim if

        echo json_encode(array("success"=>true));
    }catch(DadosCorrompidosException $e){
      echo json_encode(array("erro"=>"Por favor, escolha o tipo da pergunta.","success"=>"false"));
    }catch(PerguntaInconsistenteException $e){
      echo json_encode(array("erro"=>$e->getMessage(),"success"=>"false"));
    }catch(PesquisaJaExistenteException $e){
      echo json_encode(array("erro"=>$e->getMessage(),"success"=>"false"));
    }

       
  }// Fim método

  public function listarTodasPesquisas(){

    $pesquisaDAO = new PesquisaDAO();

    if(ValidacaoDados::validarForm($_POST,array("titulo"))){
      $pesquisaDAO = $pesquisaDAO->buscarLike(array(),array("titulo"=>$_POST['titulo']));
    }else{
      $pesquisaDAO = $pesquisaDAO->buscar(array(),array());
    }
   
    $pesquisas = array();
    foreach($pesquisaDAO as $pesquisa){
      $pesquisaAtual;
      $pesquisaAtual['idPesquisa'] = $pesquisa->getIdPesquisa();
      $pesquisaAtual['tituloPesquisa'] = $pesquisa->getTitulo();
      $pesquisaAtual['descricaoPesquisa'] = $pesquisa->getDescricao();
      $pesquisaAtual['estaAtiva'] = $pesquisa->getEstaAtiva() ? true:false;

      $pesquisas[] = $pesquisaAtual;
    }
    echo json_encode($pesquisas);
  }
  
}

?>