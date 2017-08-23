<?php 
namespace controllers;

require_once dirname(__DIR__).'/vendor/autoload.php';
use \DAO\obraDAO as ObraDAO;
use \models\Obra as Obra;
use util\ValidacaoDados as ValidacaoDados;

class buscaController extends mainController {

    public function index(){
        $this->carregarConteudo("resultadoPesquisa",array());
    }

    public function pesquisar(){
        if(isset($_GET['q']) && !empty($_GET['q'])){
            $pagina = 0;
            if(isset($_GET['p'])){
                $pagina = $_GET['p'];
            }

            $obraDAO = new ObraDAO();
            $titulo  = addslashes($_GET['q']);
            $obraPorTitulo = array();
            $obraPorAutoria = array();
            $obraPorAutor = array();
            $obraPorTag = array();

            $obraTituloAgrupada = array();
            $obraAutorAgrupada = array();            
            $obraPorTagAgrupada = array();
            $obraAutoriaAgrupada = array();
            $arrayFinal = array();

            if(isset($_GET['filtros']) && strcmp($_GET['filtros'],'autor')==0){
                $obraPorAutoria = $obraDAO->buscarLike(array(),$titulo,'autoria',$pagina);
                $obraPorAutor = $obraDAO->buscarLike(array(),$titulo,'autor',$pagina);
                $obraAutoriaAgrupada = $this->agruparObras($obraPorAutoria);
                $obraAutorAgrupada = $this->agruparObras($obraPorAutor);
            
            }else if(isset($_GET['filtros']) && strcmp($_GET['filtros'],'tag')==0){
                $obraPorTag = $obraDAO->buscarPorAtributoEspecial(array(),$titulo,$pagina,'tag');
                $obraPorTagAgrupada  = $this->agruparObras($obraPorTag);
            
            }else if(isset($_GET['filtros']) && strcmp($_GET['filtros'],'titulo')==0){
                $obraPorTitulo = $obraDAO->buscarLike(array(),$titulo,'titulo',$pagina);
                $obraTituloAgrupada = $this->agruparObras($obraPorTitulo);
                
            
            }else{
                
                $obraPorTitulo = $obraDAO->buscarLike(array(),$titulo,'titulo',$pagina);
                $obraPorAutoria = $obraDAO->buscarLike(array(),$titulo,'autoria',$pagina);
                $obraPorAutor = $obraDAO->buscarLike(array(),$titulo,'autor',$pagina);
                $obraPorTag = $obraDAO->buscarPorAtributoEspecial(array(),$titulo,$pagina,'tag');

                $obraTituloAgrupada = $this->agruparObras($obraPorTitulo);
                $obraAutoriaAgrupada = $this->agruparObras($obraPorAutoria);
                $obraAutorAgrupada = $this->agruparObras($obraPorAutor);
                $obraPorTagAgrupada  = $this->agruparObras($obraPorTag);
                
            }
            
            $chaves = array_keys($obraTituloAgrupada);
            $i=0;
            while(count($obraTituloAgrupada)>0){
                $arrayFinal[$chaves[$i++]] = array_shift($obraTituloAgrupada)[0];
            }

            $chaves = array_keys($obraAutorAgrupada);
            $i=0;
            while(count($obraAutorAgrupada)>0){
                $arrayFinal[$chaves[$i++]] = array_shift($obraAutorAgrupada)[0];
            }

            $chaves = array_keys($obraAutoriaAgrupada);
            $i=0;
            while(count($obraAutoriaAgrupada)>0){
                $arrayFinal[$chaves[$i++]] = array_shift($obraAutoriaAgrupada)[0];                
            }

            $chaves = array_keys($obraPorTagAgrupada);
            $i=0;
            while(count($obraPorTagAgrupada)>0){
                $arrayFinal[$chaves[$i++]] = array_shift($obraPorTagAgrupada)[0];
            }
            
            echo json_encode($arrayFinal);
        }
    }

    public function pesquisarClassificacao(){

        if(isset($_GET['q']) && !empty($_GET['q'])){
            
            $obraDAO = new ObraDAO();
            $titulo  = addslashes($_GET['q']);

            $pagina = 0;
            if(isset($_GET['p'])){
                $pagina = $_GET['p'];
            }

            $obraPorClassificacaoAgrupada = array();
            $obraPorClassificacao = array();
            $arrayFinal = array();

            $obraPorClassificacao = $obraDAO->buscarPorAtributoEspecial(array(),$titulo,$pagina,'classificacao');
            $obraPorClassificacaoAgrupada  = $this->agruparObras($obraPorClassificacao);

            $chaves = array_keys($obraPorClassificacaoAgrupada);
            $i=0;
            while(count($obraPorClassificacaoAgrupada)>0){
                $arrayFinal[$chaves[$i++]] = array_shift($obraPorClassificacaoAgrupada)[0];
            }

            echo json_encode($arrayFinal);
        }
        
        
    }

    public function pesquisarColecao(){

        if(isset($_GET['q']) && !empty($_GET['q'])){
            
            $obraDAO = new ObraDAO();
            $titulo  = addslashes($_GET['q']);

            $pagina = 0;
            if(isset($_GET['p'])){
                $pagina = $_GET['p'];
            }

            $obraPorColecaoAgrupada = array();
            $obraPorColecao = array();
        
            $obraPorColecao = $obraDAO->buscarPorAtributoEspecial(array(),$titulo,$pagina,'colecao');    
            $obraPorColecaoAgrupada  = $this->agruparObras($obraPorColecao);
            $arrayFinal = array();

            $chaves = array_keys($obraPorColecaoAgrupada);
            $i=0;
            while(count($obraPorColecaoAgrupada)>0){
                $arrayFinal[$chaves[$i++]] = array_shift($obraPorColecaoAgrupada)[0];
            }

            echo json_encode($arrayFinal);
        }
    }
    private function agruparObras($obras){
      $resposta = array();

      foreach($obras as $key => $item)
      {
        $resposta[$item->getNumInventario()][0] = json_decode(json_encode($item), true);;
      }

      ksort($resposta, SORT_NUMERIC);

      return $resposta;
  }

}
?>