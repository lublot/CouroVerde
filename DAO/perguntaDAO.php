<?php
namespace DAO;

require_once dirname(__DIR__).'/vendor/autoload.php';
use \models\Pergunta as Pergunta;
use \DAO\Database as Database;

class PerguntaDAO extends Database {

    private $idUltimaPergunta;
   /**
    * Insere uma ou mais perguntas no banco de dados;
    * @param unknown $perguntas - a lista de perguntas que devem ser inseridas no banco;
    * */
    public function inserir($pergunta,$idPesquisa){

            $titulo = $pergunta->getTitulo();
            $tipo = $pergunta->getTipo();
            $opcional = $pergunta->getIsOpcional()? 1:0;

            if(strcmp($tipo,"Múltipla Escolha")==0){
                $tipo = "MULTIPLA ESCOLHA";
            }else if(strcmp($tipo,"Única Escolha")==0){
                $tipo = "UNICA ESCOLHA";
            }else{
                $tipo = "ABERTA"; 
            }
            $query = "INSERT INTO pergunta(idPergunta, titulo, tipo, opcional) VALUES (null, '$titulo', '$tipo', $opcional)";
            
            $this->PDO->query($query);

            // $idPergunta = $this->buscar(array("idPergunta"),array("titulo"=>$titulo,"tipo"=>$tipo,"opcional"=>$opcional));
            
            // $idPergunta = $idPergunta[0]->getIdPergunta();
            $idPergunta = $this->PDO->lastInsertId("idPergunta");
            $this->idUltimaPergunta = $idPergunta;

            $query2 = "INSERT INTO perguntapesquisa(idPergunta, idPesquisa) VALUES ($idPergunta, $idPesquisa)";
            $this->PDO->query($query2); 
    }

    /**
    * Altera informações de uma pergunta no banco de dados;
    * @param unknown $dados - um array contendo as colunas e valores para a alteração. Ex: array("titulo"=>"O que você acha das obras?");
    * @param unknown $filtros - um array contendo os filtros usados na busca. Ex: array("idPergunta"=>5);
    * */
    public function alterar($dados, $filtros){
        $query = "UPDATE pergunta SET ";

        foreach($dados as $chave=>$valor){
            $query .= $chave.'='."'$valor',";
        }

        $query = substr($query, 0, -1);

        if(count($filtros) > 0){
            $query .= " WHERE ";
            $aux = array();

            foreach($filtros as $chave=>$valor){
                $aux[] = $chave." = "."'$valor'";
            }

            $query .= implode(" AND ",$aux);
        }
        
        $this->PDO->query($query);
    }

    /**
    * Remove uma pergunta do banco de dados;
    * @param unknown $filtros - um array contendo os filtros usados na identificação da pergunta. Ex: array("idPergunta"=>5);
    * */
    public function remover($filtros){
        $query = "DELETE FROM pergunta WHERE ";

        if(count($filtros) > 0){
            $aux = array();

            foreach($filtros as $chave=>$valor){
                $aux[] = $chave." = "."'$valor'";
            }

            $query .= implode(" AND ",$aux);
        }

        $this->PDO->query($query);
    }

  /**
    * Busca uma ou várias pesquisas no banco de dados;
    * @param unknown $campos - um array contendo os campos desejados
    * @param unknown $filtros - um array contendo os filtros usados na busca. Ex: array("idPergunta"=>5);
    * @return unknown $perguntas - um array contendo as perguntas retornados na busca
    */
    public function buscar($campos, $filtros){
        $query = "SELECT ";

        if(count($campos) == 0){
            $campos = array("*");
        }

        $query .= implode(',',$campos)." FROM pergunta";

        if(count($filtros) > 0){
            $query .= " WHERE ";
            $aux = array();

            foreach($filtros as $chave=>$valor){
                $aux[] = $chave."="."'$valor'";
            }
            
            $query .= implode(" AND ",$aux);
        }

        $result = $this->PDO->query($query);
        
        $perguntas = array();
        if(!empty($result) && $result->rowCount() > 0){
            foreach($result->fetchAll() as $item){
                $perguntas[] = new Pergunta(
                    isset($item['idPergunta'])?$item['idPergunta']:null,
                    isset($item['titulo'])?$item['titulo']:null,
                    isset($item['tipo'])?$item['tipo']:null,
                    isset($item['opcional'])?$item['opcional']:null
                    
                );
            }    
        } 
        
        return $perguntas;
    }

    public function getIdUltimaPergunta(){
        return $this->idUltimaPergunta;
    }
}

?>