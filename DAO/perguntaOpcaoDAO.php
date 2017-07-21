<?php

namespace DAO;

require_once dirname(__DIR__).'/vendor/autoload.php';
use \models\Opcao as Opcao;
use \models\Pergunta as Pergunta;
use \DAO\Database as Database;


class perguntaOpcaoDAO extends Database{



    /**
    * Busca uma ou várias pesquisas no banco de dados;
    * @param unknown $campos - um array contendo os campos desejados
    * @param unknown $filtros - um array contendo os filtros usados na busca. Ex: array("idPesquisa"=>5);
    * @return unknown $pesquisas - um array contendo as pesquisas retornados na busca
    */
    public function buscarPergunta($campos, $filtros){
        $query = "SELECT ";

        if(count($campos) == 0){
            $campos = array("*");
        }

        $query .= implode(',',$campos)." FROM perguntaopcao INNER JOIN pergunta ON perguntaopcao.idPergunta = pergunta.idPergunta";

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
                $obrigatorio;
                if(isset($item['obrigatorio'])){
                    $obrigatorio = $item['obrigatorio'] ? true:false;
                }
                $perguntas[] = new Pesquisa(
                    isset($item['idPergunta'])?$item['idPergunta']:null,
                    isset($item['titulo'])?$item['titulo']:null,
                    isset($item['tipo'])?$item['tipo']:null,
                    isset($item['obrigatorio'])?$obrigatorio:null
                );
            }    
        } 

        return $perguntas;
    }

    /**
    * Busca uma ou várias pesquisas no banco de dados;
    * @param unknown $campos - um array contendo os campos desejados
    * @param unknown $filtros - um array contendo os filtros usados na busca. Ex: array("idPesquisa"=>5);
    * @return unknown $pesquisas - um array contendo as pesquisas retornados na busca
    */
    public function buscarOpcao($campos, $filtros){
        $query = "SELECT ";

        if(count($campos) == 0){
            $campos = array("*");
        }

        $query .= implode(',',$campos)." FROM perguntaopcao INNER JOIN opcao ON perguntaopcao.idOpcao = opcao.idOpcao";

        if(count($filtros) > 0){
            $query .= " WHERE ";
            $aux = array();

            foreach($filtros as $chave=>$valor){
                $aux[] = $chave."="."'$valor'";
            }
            
            $query .= implode(" AND ",$aux);
        }
       
        $result = $this->PDO->query($query);
        
        $opcoes = array();
        if(!empty($result) && $result->rowCount() > 0){
            foreach($result->fetchAll() as $item){
                $opcoes[] = new Opcao(
                    isset($item['idOpcao'])?$item['idOpcao']:null,
                    isset($item['descricao'])?$item['descricao']:null
                );
            }    
        } 

        return $opcoes;
    }

    
}


?>