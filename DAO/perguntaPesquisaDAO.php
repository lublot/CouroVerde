<?php

namespace DAO;

require_once dirname(__DIR__).'/vendor/autoload.php';
use \models\Pesquisa as Pesquisa;
use \models\Pergunta as Pergunta;
use \DAO\Database as Database;


class perguntaPesquisaDAO extends Database{



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

        $query .= implode(',',$campos)." FROM perguntapesquisa INNER JOIN pergunta ON perguntapesquisa.idPergunta = pergunta.idPergunta";

        if(count($filtros) > 0){
            $query .= " WHERE ";
            $aux = array();

            foreach($filtros as $chave=>$valor){
                $aux[] = 'perguntapesquisa.'.$chave."="."'$valor'";
            }
            
            $query .= implode(" AND ",$aux);
        }
       
        $result = $this->PDO->query($query);
        
        $perguntas = array();
        if(!empty($result) && $result->rowCount() > 0){
            foreach($result->fetchAll() as $item){
                $opcional;
                if(isset($item['opcional'])){
                    $opcional = $item['opcional'] ? true:false;
                }
                $perguntas[] = new Pergunta(
                    isset($item['idPergunta'])?$item['idPergunta']:null,
                    isset($item['titulo'])?$item['titulo']:null,
                    isset($item['tipo'])?$item['tipo']:null,
                    isset($item['opcional'])?$opcional:null
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
    public function buscarPesquisa($campos, $filtros){
        $query = "SELECT ";

        if(count($campos) == 0){
            $campos = array("*");
        }

        $query .= implode(',',$campos)." FROM perguntapesquisa INNER JOIN pesquisa ON perguntapesquisa.idPesquisa = pesquisa.idPesquisa";

        if(count($filtros) > 0){
            $query .= " WHERE ";
            $aux = array();

            foreach($filtros as $chave=>$valor){
                $aux[] = 'perguntapesquisa.'.$chave."="."'$valor'";
            }
            
            $query .= implode(" AND ",$aux);
        }
       
        $result = $this->PDO->query($query);
        
        $pesquisas = array();
        if(!empty($result) && $result->rowCount() > 0){
            foreach($result->fetchAll() as $item){
                $estaAtiva;
                if(isset($item['estaAtiva'])){
                    $estaAtiva = $item['estaAtiva'] ? true:false;
                }
                $pesquisas[] = new Pesquisa(
                    isset($item['idPesquisa'])?$item['idPesquisa']:null,
                    isset($item['titulo'])?$item['titulo']:null,
                    isset($item['descricao'])?$item['descricao']:null,
                    isset($item['estaAtiva'])? $estaAtiva:null
                );
            }    
        } 

        return $pesquisas;
    }

    
}


?>