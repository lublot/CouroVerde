<?php
namespace controllers;

require_once dirname(__DIR__).'/vendor/autoload.php';
use DAO\PesquisaDAO as PesquisaDAO;
use DAO\PerguntaDAO as PerguntaDAO;
use DAO\OpcaoDAO as OpcaoDAO;
use DAO\PerguntaPesquisaDAO as PerguntaPesquisaDAO;
use DAO\PerguntaOpcaoDAO as PerguntaOpcaoDAO;
use DAO\UsuarioDAO as UsuarioDAO;
use \util\ValidacaoDados as ValidacaoDados;
use \util\GerenciarSenha as GerenciarSenha;
use \models\Pesquisa as Pesquisa;
use \models\Pergunta as Pergunta;
use \models\Opcao as Opcao;
use \models\OpcaoPergunta as OpcaoPergunta;
use \exceptions\DadosCorrompidosException as DadosCorrompidosException;
use \exceptions\NomeInvalidoException as NomeInvalidoException;
use \exceptions\CampoInvalidoException as CampoInvalidoException;
use \exceptions\PerguntaInconsistenteException as PerguntaInconsistenteException;
use \exceptions\PesquisaJaExistenteException as PesquisaJaExistenteException;
use \exceptions\PesquisaInexistenteException as PesquisaInexistenteException;
use \exceptions\SenhaIncorretaException as SenhaIncorretaException;

class pesquisaController extends mainController{


  protected $dados = array();

  public function index(){
  
    $this->carregarConteudo('homePesquisa',$this->dados);
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
  
  public function buscarPesquisa($parametros){
     

     try{
      if(isset($parametros) && !empty($parametros)){
        $idPesquisa = array_shift($parametros);
        $pesquisaDAO = new PesquisaDAO();
        $pesquisa = $pesquisaDAO->buscar(array(),array('idPesquisa'=>$idPesquisa));
          if(count($pesquisa)>0){
              $tituloPesquisa = $pesquisa[0]->getTitulo();//Recebe o titulo da pesquisa
              $descricaoPesquisa = $pesquisa[0]->getDescricao();//Recebe a descrição da pesquisa
              
              $perguntaPesquisaDAO = new PerguntaPesquisaDAO();
              $perguntasPesquisa = $perguntaPesquisaDAO->buscarPergunta(array(),array('idPesquisa'=>$idPesquisa));

              $perguntaDAO = new PerguntaDAO();
              $perguntas = array();
              
              foreach($perguntasPesquisa as $perguntaPesquisa){
                $pergunta = $perguntaDAO->buscar(array(),array('idPergunta'=>$perguntaPesquisa->getIdPergunta())); //Este array vai conter todas as perguntas a serem adicionadas;
                array_push($perguntas,$pergunta[0]);
              }
              
              $perguntaOpcaoDAO = new PerguntaOpcaoDAO();
            
              $perguntasOpcao = array();


              foreach($perguntas as $pergunta){
                $opcoes = $perguntaOpcaoDAO->buscarOpcao(array(),array('idPergunta'=>$pergunta->getIdPergunta()));
                $opcoesRecuperadas = array();
                foreach($opcoes as $opcaoAtual){
                  $opcaoDAO = new OpcaoDAO();
                  $opcao = $opcaoDAO->buscar(array(),array('idOpcao'=>$opcaoAtual->getIdOpcao()));
                  $opcoesRecuperadas[] = $opcao[0];
                }
                $perguntaOpcao['Pergunta'] = $pergunta;
                $perguntaOpcao['Opcao'] = $opcoesRecuperadas;
                array_push($perguntasOpcao,$perguntaOpcao);
              }
              

              $pesquisaFinal = array();
              $pesquisaFinal['tituloPesquisa'] = $tituloPesquisa;
              $pesquisaFinal['descricaoPesquisa'] = $descricaoPesquisa;
              
              foreach($perguntasOpcao as $perguntaOpcao){
                array_push($pesquisaFinal,$perguntaOpcao);
              }
              echo json_encode($pesquisaFinal);
            }else{
              throw new PesquisaInexistenteException();
            }
      }
      
        
    }catch(DadosCorrompidosException $e){
      echo json_encode(array("erro"=>"Por favor, escolha o tipo da pergunta.","success"=>"false"));
    }catch(PerguntaInconsistenteException $e){
      echo json_encode(array("erro"=>$e->getMessage(),"success"=>"false"));
    }catch(PesquisaJaExistenteException $e){
      echo json_encode(array("erro"=>$e->getMessage(),"success"=>"false"));
    }catch(PesquisaInexistenteException $e){
      echo json_encode(array("erro"=>$e->getMessage(),"success"=>"false"));
    }
  }

  public function remover(){
    try{
      if(ValidacaoDados::validarForm($_POST,array("senhaAdmin","idPesquisa"))){

        $usuarioDAO = new UsuarioDAO();
        $senhaArmazenada = $usuarioDAO->buscar(array("senha"),array("tipoUsuario"=>"ADMINISTRADOR"));
        $senhaArmazenada = $senhaArmazenada[0]->getSenha();
        
        if(GerenciarSenha::checarSenha($_POST['senhaAdmin'],$senhaArmazenada)){
          
          $pesquisaDAO = new PesquisaDAO();  
          $perguntaPesquisaDAO = new PerguntaPesquisaDAO();
          
          $perguntas = $perguntaPesquisaDAO->buscarPergunta(array(),array());


          $opcoes;
          $perguntaOpcaoDAO = new PerguntaOpcaoDAO();
         
          foreach($perguntas as $pergunta){
             if(strcmp($pergunta->getTipo(),"ABERTA") !=0){
                $id = $pergunta->getIdPergunta();
                $opcoes = $perguntaOpcaoDAO->buscarOpcao(array(),array("idPergunta"=>$id));
             }
          }
          
          $perguntaDAO = new PerguntaDAO();
          
          $opcaoDAO = new OpcaoDAO();
          if(isset($opcoes) && !empty($opcoes)){
            foreach($opcoes as $opcao){
              $opcaoDAO->remover(array("idOpcao"=>$opcao->getIdOpcao())); 
            }
          }
          

          foreach($perguntas as $pergunta){
            $perguntaDAO->remover(array("idPergunta"=>$pergunta->getIdPergunta()));
          }

          $pesquisaDAO->remover(array("idPesquisa"=>$_POST['idPesquisa']));
          echo json_encode(array("success"=>true));
        }else{
          throw new SenhaIncorretaException();
        }

      }else{
        throw new DadosCorrompidosException();
      }
    }catch(DadosCorrompidosException $e){
      echo json_encode(array("erro"=>"Por favor, tente novamente.","success"=>"false"));
    }catch(SenhaIncorretaException $e){
      echo json_encode(array("erro"=>$e->getMessage(),"success"=>"false"));
    }
  }

  public function toggle(){

    try{
      if(ValidacaoDados::validarForm($_POST,array('idPesquisa','estadoAtual'))){
        $pesquisaDAO = new PesquisaDAO();
        $pesquisaDAO->alterar(array("estaAtiva"=>"0"),array()); //Seta false em todas as pesquisas;

        
        if(strcmp($_POST['estadoAtual'],'false')==0){
          $pesquisaDAO->alterar(array("estaAtiva"=>1),array("idPesquisa"=>$_POST["idPesquisa"]));
        }

        echo json_encode(array("success"=>true));
      }
    }catch(Exception $e){
      echo json_encode(array("erro"=>"Ocorreu um erro,tente novamente","success"=>false));
    }

  }
}

?>