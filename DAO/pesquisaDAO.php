<?php
namespace DAO;

require_once dirname(__DIR__).'/vendor/autoload.php';
use \models\Pesquisa as Pesquisa;
use \DAO\Database as Database;

class PesquisaDAO extends Database{

    /**
    * Insere uma pesquisa no banco de dados;
    * @param unknown $pesquisa - a pesquisa deve ser inserida no banco;
    * */
    public function inserir($pesquisa){
        $titulo = $pesquisa->getTitulo();
        $estaAtiva = $pesquisa->getEstaAtiva()? 1:0;

        $buscarPesquisa = $this->buscar(array("idPesquisa"),array("titulo"=>$titulo,"estaAtiva"=>$estaAtiva));

        //Verifica se a pesquisa já existe no sistema
        if(count($buscarPesquisa) == 0){
            $query = "INSERT INTO pesquisa(idPesquisa, titulo, estaAtiva) VALUES (null, '$titulo', $estaAtiva)";
        }else{
            throw new PesquisaJaExistenteException();
        }
        
        try{
            $this->PDO->query($query);
        }catch(PDOException $e){

        }
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
                    isset($item['descricao'])?$item['descricao']:null,
                    isset($item['estaAtiva'])?$item['estaAtiva']:null
                );
            }    
        } 

        return $pesquisas;
    }
}

?>