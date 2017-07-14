<?php
namespace DAO;

require_once dirname(__DIR__).'/vendor/autoload.php';
use \models\Backup as Backup;
use \DAO\Database as Database;

class backupDAO extends Database {
    /**
    * Insere um backup no banco de dados;
    * @param Backup $backup - backup a ser inserido no banco;
    * */
    public function inserir($backup){
        $data = $backup->getData();
        $hora = $backup->getHora();
        $caminho = $backup->getCaminho();

        $query = "INSERT INTO backup(data, dataHora, caminho) VALUES (null, '$data $hora', '$caminho')";

        try{
            $this->PDO->query($query);
        }catch(PDOException $e){

        }
    }


    /**
    * Remove um backup do banco de dados
    * @param unknown $filtros - um array contendo os filtros usados na busca. Ex: array("caminho"=>'umCaminhoNovo');
    * */
    public function remover($filtros){
        $query = "DELETE FROM backup ";

        if(count($filtros) > 0){
            $query = $query . 'WHERE ';
            $aux = array();

            foreach($filtros as $chave=>$valor){
                $aux[] = $chave." = "."'$valor'";
            }

            $query .= implode(" AND ",$aux);
        }

        $this->PDO->query($query);
    }

    /**
    * Busca uma ou vários backups no banco de dados
    * @param unknown $campos - um array contendo os campos desejados
    * @param unknown $filtros - um array contendo os filtros usados na busca. Ex: array("caminho"=>'umCaminhoNovo');
    * @return unknown $backup - um array contendo os backups retornados na busca
    */
    public function buscar($campos = array(),$filtros = array()){
        $query = "SELECT ";

        if(count($campos) == 0){
            $campos = array("*");
        }

        $query .= implode(',',$campos)."FROM backup";

        if(count($filtros) > 0){
            $query .= " WHERE ";
            $aux = array();

            foreach($filtros as $chave=>$valor){
                $aux[] = $chave."="."'$valor'";
            }
            
            $query .= implode(" AND ",$aux);
        }

        $result = $this->PDO->query($query);

        $backup = array();
        if(!empty($result) && $result->rowCount() > 0){
            foreach($result->fetchAll() as $item){
                $dataHora = explode(' ', $item['dataHora']);
                
                $data = $dataHora[0];
                $hora = $dataHora[1];

                $backup[] = new Backup(isset($item['idbackup']) ? $item['idbackup'] : null,
                isset($item['data']) ? $item['data'] : null,
                isset($item['hora']) ? $item['hora'] : null,
                isset($item['caminho']) ? $item['caminho'] : null);
            }    
        }
        
        return $backup;
    }


     /**
    * Busca um ou vários backups mais recentes no banco de dados;
    * @param unknown $campos - um array contendo os campos desejados, caso receba um valor vazio ou null considera que esteja solicitando todos os campos
    * @param unknown $filtros - um array contendo os filtros usados na busca. Ex: array("caminho"=>'umCaminhoNovo');
    * @return unknown $backup - um array contendo os backups retornados na busca
    */
    public function buscarMaisRecente($campos = array(),$filtros = array(),$limite=0){


        $query = "SELECT ";

        if(count($campos) == 0){
            $campos = array("*");
        }

        $query .= implode(',',$campos)."FROM backup";

        if(count($filtros) > 0){
            $query .= " WHERE ";
            $aux = array();

            foreach($filtros as $chave=>$valor){
                $aux[] = $chave."="."'$valor'";
            }
            
            $query .= implode(" AND ",$aux);
        }

        $query .= "ORDER BY data DESC";

        if($limite > 0 ){
            $query .= "LIMIT ".$limite;
        }

        $result = $this->PDO->query($query);

        $backup = array();
        if(!empty($result) && $result->rowCount() > 0){
            foreach($result->fetchAll() as $item){
                
                if(isset($item['dataHora'])) {
                    $dataHora = explode(' ', $item['dataHora']);
                    
                    $data = $dataHora[0];
                    $hora = $dataHora[1];                    
                } else {
                    $data = null;
                    $hora = null;
                }

                $backup[] = new Backup(isset($item['idbackup']) ? $item['idbackup']:null,
                                          isset($item['data']) ? $item['data']:null,
                                          isset($item['hora']) ? $item['hora']:null,
                                          isset($item['caminho']) ? $item['caminho']:null);
            }    
        }
        
        return $backup;
    }
}


?>
