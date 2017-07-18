<?php
namespace DAO;

require_once dirname(__DIR__).'/vendor/autoload.php';
use \models\RelatorioSistema as RelatorioSistema;
use \DAO\Database as Database;

if(!isset($_SESSION)){
    session_start();
}
class relatorioSistemaDAO extends Database{

    /**
    * Insere um relatório no banco de dados;
    * @param unknown $relatorio - o relatorio a ser inserido no banco;
    * */
    public function inserir($relatorio){
        $idAutor = $relatorio->getAutor();
        $acao = $relatorio->getAcao();
        $idAlvo = $relatorio->getIdAlvo();
        $tipoAlvo = $relatorio->getTipoAlvo();
        $horario = $relatorio->getHorario();

        $query = "INSERT INTO logalteracoes(idLogAlteracoes, idFuncionario, idItemAlterado, tipoItemAlterado, descricao, dataHora) VALUES (null, '$idAutor', '$idAlvo', '$tipoAlvo', '$acao', $horario)";
        try{
            $this->PDO->query($query);
        }catch(PDOException $e){

        }
    }

    /**
    * Altera informações de um relatório no banco de dados;
    * @param unknown $dados - um array contendo as colunas e valores para a alteração. Ex: array("acao"=>"Cadastrou");
    * @param unknown $filtros - um array contendo os filtros usados na busca. Ex: array("idRelatorio"=>5);
    * */
    public function alterar($dados,$filtros){
        $query = "UPDATE logaIteracoes SET ";

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
    * Remove um relatório do banco de dados;
    * @param unknown $filtros - um array contendo os filtros usados na identificação do relatório. Ex: array("idRelatorio"=>5);
    * */
    public function remover($filtros){
        $query = "DELETE FROM logaIteracoes WHERE ";

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
    * Busca um ou vários relatórios no banco de dados;
    * @param unknown $campos - um array contendo os campos desejados
    * @param unknown $filtros - um array contendo os filtros usados na busca. Ex: array("idLogAlteracao"=>5);
    * @return unknown $relatorios - um array contendo os relatórios retornados na busca
    */
    public function buscar($campos,$filtros){
        $query = "SELECT ";

        if(count($campos) == 0){
            $campos = array("*");
        }

        $query .= implode(',',$campos)." FROM logaIteracoes";

        if(count($filtros) > 0){
            $query .= " WHERE ";
            $aux = array();

            foreach($filtros as $chave=>$valor){
                $aux[] = $chave."="."'$valor'";
            }
            
            $query .= implode(" AND ",$aux);
        }

        $result = $this->PDO->query($query);

        $relatorios = array();
        if(!empty($result) && $result->rowCount() > 0){
            foreach($result->fetchAll() as $item){
                $relatorios[] = new RelatorioSistema(isset($item['idLogAlteracoes'])?$item['idLogAlteracoes']:null,
                                          isset($item['idFuncionario'])?$item['idFuncionario']:null,
                                          isset($item['idItemAlterado'])?$item['idItemAlterado']:null,
                                          isset($item['tipoItemAlterado'])?$item['tipoItemAlterado']:null,
                                          isset($item['descricao'])?$item['descricao']:null,
                                          isset($item['dataHora'])?$item['dataHora']:null);
            }    
        }
        return $relatorios;
    }
}
?>
