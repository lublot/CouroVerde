<?php
namespace DAO;

require_once dirname(__DIR__).'/vendor/autoload.php';
use \DAO\Database as a;
use \models\Usuario as Usuario;

class relatorioSistemaDAO extends Database{

    /**
    * Insere um relatório no banco de dados;
    * @param unknown $relatorio - o relatorio a ser inserido no banco;
    * */
    public function inserir($relatorio){
        
        $autor = $relatorio->getAutor();
        $acao = $relatorio->getAcao();
        $idAlvo = $relatorio->getIdAlvo();
        $tipoAlvo = $relatorio->getTipoAlvo();
        $horario = $relatorio->getHorario();


        $query = "INSERT INTO relatorio(idRelatorio, autor, acao, idAlvo, tipoAlvo, horario) VALUES (null, '$autor', '$acao', '$alvo', '$idAlvo','$horario')";

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
        $query = "UPDATE relatorio SET ";

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
        $query = "DELETE FROM relatorio WHERE ";

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
    * @param unknown $filtros - um array contendo os filtros usados na busca. Ex: array("idUsuario"=>5);
    * @return unknown $usuarios - um array contendo os relatórios retornados na busca
    */
    public function buscar($campos,$filtros){
        $query = "SELECT ";

        if(count($campos) == 0){
            $campos = array("*");
        }

        $query .= implode(',',$campos)." FROM relatorio";

        if(count($filtros) > 0){
            $query .= " WHERE ";
            $aux = array();

            foreach($filtros as $chave=>$valor){
                $aux[] = $chave."="."'$valor'";
            }
            
            $query .= implode(" AND ",$aux);
        }

        $result = $this->PDO->query($query);

        $usuarios = array();
        if(!empty($result) && $result->rowCount() > 0){
            foreach($result->fetchAll() as $item){
                $relatorios[] = new RelatorioSistema(isset($item['idRelatorio'])?$item['idRelatorio']:null,
                                          isset($item['email'])?$item['email']:null,
                                          isset($item['nome'])?$item['nome']:null,
                                          isset($item['sobrenome'])?$item['sobrenome']:null,
                                          isset($item['senha'])?$item['senha']:null,
                                          $cadastroConfirmado,
                                          isset($item['tipoUsuario'])?$item['tipoUsuario']:null);
            }    
        }
        
        //FALTA ALTERAR OS NOMES DOS ATRIBUTOS, AGUARDANDO ATUALIZAÇÃO DO BD
        //return $relatorios;
    }
}
?>
