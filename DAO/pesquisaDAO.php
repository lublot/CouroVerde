<?php
namespace DAO;

require_once dirname(__DIR__).'/vendor/autoload.php';
use \models\Pesquisa as Pesquisa;
use \DAO\Database as Database;

class PesquisaDAO extends DataBase{

    private static $idPesquisa;

    /**
    * Retorna o id da ultima pesquisa cadastrada
    * @return unknown $idPesquisa - Retorna o id da pesquisa
    */
    public static function getIdPesquisa(){
        return self::$idPesquisa;
    }

    /**
    * Insere uma pesquisa no banco de dados;
    * @param unknown $pesquisa - a pesquisa deve ser inserida no banco;
    * */
    public function inserir($pesquisa){
        $titulo = $pesquisa->getTitulo();
        $estaAtiva = $pesquisa->getEstaAtiva();

        $query = "INSERT INTO pesquisa(idPesquisa, titulo, estaAtiva) VALUES (null, '$titulo', '$estaAtiva')";

        try{
            $this->PDO->query($query);
        }catch(PDOException $e){

        }

        $id = $this->buscar(array("idPesquisa"), array("titulo" => $titulo));
        self::$idPesquisa = $id;
    }

    /**
    * Altera informações de uma pesquisa no banco de dados;
    * @param unknown $dados - um array contendo as colunas e valores para a alteração. Ex: array("titulo"=>"Qualidade das obras");
    * @param unknown $filtros - um array contendo os filtros usados na busca. Ex: array("idPesquisa"=>5);
    * */
    public function alterar($dados, $filtros){
        $query = "UPDATE pesquisa SET ";

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
    * Remove uma pesquisa do banco de dados;
    * @param unknown $filtros - um array contendo os filtros usados na identificação da pesquisa. Ex: array("idPesquisa"=>5);
    * */
    public function remover($filtros){
        $query = "DELETE FROM pesquisa WHERE ";

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
    * @param unknown $filtros - um array contendo os filtros usados na busca. Ex: array("idPesquisa"=>5);
    * @return unknown $pesquisas - um array contendo as pesquisas retornados na busca
    */
    public function buscar($campos, $filtros){
        $query = "SELECT ";

        if(count($campos) == 0){
            $campos = array("*");
        }

        $query .= implode(',',$campos)." FROM pesquisa";

        if(count($filtros) > 0){
            $query .= " WHERE ";
            $aux = array();

            foreach($filtros as $chave=>$valor){
                $aux[] = $chave."="."'$valor'";
            }
            
            $query .= implode(" AND ",$aux);
        }

        $result = $this->PDO->query($query);

        $pesquisas = array();
        if(!empty($result) && $result->rowCount() > 0){
            foreach($result->fetchAll() as $item){
                $pesquisas[] = new Pesquisa(
                    isset($item['idPesquisa'])?$item['idPesquisa']:null,
                    isset($item['titulo'])?$item['titulo']:null,
                    isset($item['estaAtiva'])?$item['estaAtiva']:null
                );
            }    
        } 
        return $pesquisas;
    }
}

?>