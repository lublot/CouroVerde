<?php
namespace DAO;

require_once dirname(__DIR__).'/vendor/autoload.php';
use \models\RegistroVisitasObra as registroVisitasObra;
use \models\Visita as Visita;
use \DAO\Database as Database;

class usuarioAcessoDAO extends Database {


    /**
    * Insere uma visita no banco de dados
    * @param Visita $visita - visita a ser inserida no banco de dados
    * */
    public function inserir($visita){
        $numeroInventario = $visita->getNumeroInventario();
        $idVisitante = $visita->getIdVisitante();

        $query = "INSERT INTO usuarioacessoobra(numeroInventario, idUsuario) VALUES ('$numeroInventario', '$idsVisitantes')";

        try{
            $this->PDO->query($query);
        }catch(PDOException $e){
            
        }
    }
    

    /**
    * Remove uma ou mais visitas do banco de dados;
    * @param unknown $filtros - um array contendo os filtros usados na identificação da visita. Ex: array("idObra"=>5);
    * */
    public function remover($filtros){
        $query = "DELETE FROM usuarioacessoobra ";

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
    * Busca uma ou várias visitas no banco de dados;
    * @param unknown $campos - um array contendo os campos desejados
    * @param unknown $filtros - um array contendo os filtros usados na busca. Ex: array("idObra"=>5);
    * @return unknown $visitas - um array contendo as visitas retornados na busca
    */
    public function buscar($campos,$filtros){
        $query = "SELECT ";

        if(count($campos) == 0){
            $campos = array("*");
        }

        $query .= implode(',',$campos)."FROM usuarioacessoobra";

        if(count($filtros) > 0){
            $query .= " WHERE ";
            $aux = array();

            foreach($filtros as $chave=>$valor){
                $aux[] = $chave."="."'$valor'";
            }
            
            $query .= implode(" AND ",$aux);
        }

        
        $result = $this->PDO->query($query);

        $visitas = array();
        if(!empty($result) && $result->rowCount() > 0){
            foreach($result->fetchAll() as $item){
                $visitas[] = new Visita(isset($item['numeroInventario']) ? $item['numeroInventario']:null,
                                          isset($item['idUsuario']) ? $item['idUsuario']:null);
            }    
        }
        
        return $visitas;
    }

    /**
    * Obtém os registros das obras mais visitadas.
    * @param unknown $campos - um array contendo os campos desejados
    * @param unknown $filtros - um array contendo os filtros usados na busca. Ex: array("idObra"=>5);
    * @return unknown $visitas - um array contendo as visitas retornados na busca
    */
    public function buscarObraMaisVisitada(){
        $query = "SELECT numeroInventario, COUNT(numeroInventario) FROM usuarioacessoobra GROUP BY numeroInventario ORDER BY COUNT(numeroInventario) DESC";  

        $result = $this->PDO->query($query);

        $visitasObra = array();
        if(!empty($result) && $result->rowCount() > 0){
            foreach($result->fetchAll() as $item) {
                if(!isset($numMaxVisitas)) {
                    $numMaxVisitas = $item["COUNT(numeroInventario)"];
                }

                if($item["COUNT(numeroInventario)"] == $numMaxVisitas) {
                    $resultados[] = new RegistroVisitasObra($item["numeroInvenatio"], $item["COUNT(numeroInventario)"]);
                }
            }   
        }
        
        return $resultado;
    }
    /**
    * Obtém os registros das obras menos visitadas.
    * @param unknown $campos - um array contendo os campos desejados
    * @param unknown $filtros - um array contendo os filtros usados na busca. Ex: array("idObra"=>5);
    * @return unknown $visitas - um array contendo as visitas retornados na busca
    */
    public function buscarObraMenosVisitada(){
        $query = "SELECT numeroInventario, COUNT(numeroInventario) FROM usuarioacessoobra GROUP BY numeroInventario ORDER BY COUNT(numeroInventario) ASC";  

        $result = $this->PDO->query($query);

        $visitasObra = array();
        if(!empty($result) && $result->rowCount() > 0){
            foreach($result->fetchAll() as $item) {
                if(!isset($numMaxVisitas)) {
                    $numMaxVisitas = $item["COUNT(numeroInventario)"];
                }

                if($item["COUNT(numeroInventario)"] == $numMaxVisitas) {
                    $resultados[] = new RegistroVisitasObra($item["numeroInvenatio"], $item["COUNT(numeroInventario)"]);
                }
            }   
        }
        
        return $resultado;
    }

}


?>
