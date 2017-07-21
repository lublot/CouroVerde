<?php
namespace DAO;

require_once dirname(__DIR__).'/vendor/autoload.php';
use \models\Opcao as Opcao;
use \DAO\Database as Database;
use \DAO\OpcaoDAO as OpcaoDAO;

class OpcaoDAO extends DataBase {

   /**
    * Insere uma opção de pergunta no banco de dados;
    * @param unknown $opcaoPergunta - a opção de pergunta deve ser inserida no banco;
    * @param unknown $idPergunta - o id da Pergunta que contém as opções;
    * */
    public function inserir($opcaoPergunta,$idPergunta){
        $descricao = $opcaoPergunta->getDescricao();
 
        $query = "INSERT INTO opcao(idOpcao, descricao) VALUES (null, '$descricao')";
        $this->PDO->query($query);

        $idOpcao = $this->PDO->lastInsertId("idOpcao"); 

        $query2 = "INSERT INTO perguntaopcao(idPergunta, idOpcao) VALUES ($idPergunta, $idOpcao)";
        $this->PDO->query($query2);
    }

    /**
    * Altera informações de uma opção de pergunta no banco de dados;
    * @param unknown $dados - um array contendo as colunas e valores para a alteração. Ex: array("descricao"=>"Qualidade muito boa");
    * @param unknown $filtros - um array contendo os filtros usados na busca. Ex: array("idOpcao"=>5);
    * */
    public function alterar($dados, $filtros){
        $query = "UPDATE opcao SET ";

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
    * Remove uma opção de pergunta do banco de dados;
    * @param unknown $filtros - um array contendo os filtros usados na identificação da opção da pergunta. Ex: array("idOpcao"=>5);
    * */
    public function remover($filtros){
        $query = "DELETE FROM opcao WHERE ";

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
    * Busca uma ou várias opções de perguntas no banco de dados;
    * @param unknown $campos - um array contendo os campos desejados
    * @param unknown $filtros - um array contendo os filtros usados na busca. Ex: array("idOpcao"=>5);
    * @return unknown $opcoes - um array contendo as opções de perguntas retornados na busca
    */
    public function buscar($campos, $filtros){
        $query = "SELECT ";

        if(count($campos) == 0){
            $campos = array("*");
        }

        $query .= implode(',',$campos)." FROM opcao";

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