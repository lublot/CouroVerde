<?php
namespace DAO;

require_once dirname(__DIR__).'/vendor/autoload.php';
use \models\Pergunta as Pergunta;
use \DAO\Database as Database;

class PerguntaDAO extends DataBase {

    private static $idPergunta;

   /**
    * Retorna o id da ultima pesquisa cadastrada
    * @return unknown $idPesquisa - Retorna o id da pesquisa
    */
    public static function getIdPergunta(){
        return $this->idPergunta;
    }

   /**
    * Insere uma ou mais perguntas no banco de dados;
    * @param unknown $listaPerguntas - a pergunta deve ser inserida no banco;
    * */
    public function inserir($listaPerguntas){
        foreach($listaPerguntas as $atual){
            
        }
        $titulo = $pergunta->getTitulo();
        $tipo = $pergunta->getTipo();
        $opcional = $pergunta->getIsOpcional();

        $query = "INSERT INTO pergunta(idPergunta, titulo, tipo, opcional) VALUES (null, '$titulo', '$tipo', '$opcional')";

        $id = PesquisaDAO::getIdPesquisa();
        $query2 = "INSERT INTO perguntapesquisa(idPergunta, idPesquisa) VALUES (null, '$id')";

        try{
            $this->PDO->query($query);
            $this->PDO->query($query2);
        }catch(PDOException $e){

        }
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
                    isset($item['opcional'])?$item['opcional']:null,
                    isset($item['tipo'])?$item['tipo']:null
                );
            }    
        } 
        return $perguntas;
    }
}

?>