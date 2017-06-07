<?php
class UsuarioDAO extends Database{

    //Não seria bom se as classes DAO fosse Singleton? Vi uma implementação que era assim e faz sentido, a gente não precisa de vários objetos

    public function inserir(){

    }

    public function alterar(){

    }

    public function remover(){

    }

    public function buscar($campos=array("nome","teste"),$filtros=array("id"=>1)){
        $query = "SELECT ";

        if(count($campos) == 0){
            $campos = array("*");
        }

        $query .= implode(',',$campos)."FROM usuarios";

        if(count($filtros) > 0){
            $query .= " WHERE ";
            $colunas = array_keys($filtros);
            $valores = array_values($campos);
            $aux = array();

            foreach($colunas as $chave){
                $aux[] = $chave." = ?";
            }
            $query .= implode(" AND ",$aux);
        }

        echo get_parent_class($this);
        $query = $this->PDO->prepare($query);
        $query->execute($valores);

        $usuarios = array();
        if($query->rowCount() > 0){
            foreach($query->fetchAll() as $item){
                $usuarios[] = new Usuario($item);
            }    
        }
        return $usuarios;
    }
}
?>