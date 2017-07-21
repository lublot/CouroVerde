<?php 

class relatorioAcessoDAO extends Database{

    public function buscarMaisVisitada($campos){

        $query = "SELECT Obra.numInventario , Obra.titulo FROM Obra INNER JOIN usuarioAcessoObra ON Obra.numInventario = usuarioAcessoObra.numInventario GROUP BY usuarioAcessoObra.numInventario ORDER BY COUNT(usuarioAcessoObra.numInventario) ASC LIMIT 1";
        $result = $this->PDO->query($query);

        $obraMaisVisitada = array();
        if(!empty($result) && $result->rowCount() > 0){
            foreach($result->fetchAll() as $item){

                $obraMaisVisitada[] = array(isset($item['Obra.titulo'])?$item['Obra.titulo']:null,
                                          isset($item['Obra.numInventario'])?$item['Obra.numInventario']:null
                                          );
            }    
        }
        
        return $obraMaisVisitada;
    }

    public function buscarMenosVisitada(){

        $query = "SELECT Obra.numInventario , Obra.titulo FROM Obra INNER JOIN usuarioAcessoObra ON Obra.numInventario = usuarioAcessoObra.numInventario GROUP BY usuarioAcessoObra.numInventario ORDER BY COUNT(usuarioAcessoObra.numInventario) DESC LIMIT 1";
        $result = $this->PDO->query($query);

        $obraMenosVisitada = array();
        if(!empty($result) && $result->rowCount() > 0){
            foreach($result->fetchAll() as $item){

                $obraMenosVisitada[] = array(isset($item['Obra.titulo'])?$item['Obra.titulo']:null,
                                          isset($item['Obra.numInventario'])?$item['Obra.numInventario']:null
                                          );
            }    
        }
        
        return $obraMenosVisitada;
    }

}


?>