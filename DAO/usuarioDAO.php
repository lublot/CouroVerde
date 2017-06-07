<?php

class UsuarioDAO extends Database{

    //Não seria bom se as classes DAO fosse Singleton? Vi uma implementação que era assim e faz sentido, a gente não precisa de vários objetos

    public function inserir($usuario){
        
        $nome = $usuario->getNome();
        $sobrenome = $usuario->getSobrenome();
        $email = $usuario->getEmail();
        $senha = $usuario->getSenha();
        $confirmouCadastro = $usuario->confirmouCadastro();

        $query = "INSERT INTO `usuario`(`idUsuario`, `nome`, `sobrenome`, `email`, `senha`, `confirmouCadastro`) 
                  VALUES (null,'$nome','$sobrenome','$email','$senha','$confirmouCadastro')";
        try{
            $this->PDO->query($query);
        }catch(PDOException $e){

        }
    }

    public function alterar($dados=array("nome"=>"pedro"),$filtros=array("idUsuario"=>2,"nome"=>"Emerson")){
        $query = "UPDATE usuario SET ";

        foreach($dados as $chave=>$valor){
            $query .= $chave.'='."'$valor'";
        }

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

    public function remover(){

    }

    public function buscar($campos=array("nome","teste"),$filtros=array("id"=>1)){
        $query = "SELECT ";

        if(count($campos) == 0){
            $campos = array("*");
        }

        $query .= implode(',',$campos)."FROM usuario";

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
                $usuarios[] = new Usuario($item['idUsuario'],$item['email'],$item['nome'],$item['sobrenome'],$item['senha'],$item['confirmouCadastro']);
            }    
        }
        
        return $usuarios;
    }
}
?>