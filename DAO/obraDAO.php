<?php

namespace DAO;


class ObraDAO {

    /**
    * Insere um usuário no banco de dados;
    * @param unknown $usuario - o usuário a ser inserido no banco;
    * */
    public function inserir($usuario){
        
        $nome = $usuario->getNome();
        $sobrenome = $usuario->getSobrenome();
        $email = $usuario->getEmail();
        $senha = $usuario->getSenha();
        $cadastroConfirmado = $usuario->confirmouCadastro();

        $query = "INSERT INTO `usuario`(`idUsuario`, `nome`, `sobrenome`, `email`, `senha`, `cadastroConfirmado`) 
                  VALUES (null,'$nome','$sobrenome','$email','$senha','$cadastroConfirmado')";
        try{
            $this->PDO->query($query);
        }catch(PDOException $e){

        }
    }

    /**
    * Altera informações de uma obra no banco de dados;
    * @param unknown $dados - um array contendo as colunas e valores para a alteração. Ex: array("nomeObra"=>"Couro");
    * @param unknown $filtros - um array contendo os filtros usados na busca. Ex: array("idObra"=>5);
    * */
    public function alterar($dados,$filtros){
        $query = "UPDATE obra SET ";

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

    /**
    * Remove uma obra do banco de dados;
    * @param unknown $filtros - um array contendo os filtros usados na identificação do usuário. Ex: array("idObra"=>5);
    * */
    public function remover($filtros){
        $query = "DELETE FROM usuario WHERE ";

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
    * Busca uma ou várias obras no banco de dados;
    * @param unknown $campos - um array contendo os campos desejados
    * @param unknown $filtros - um array contendo os filtros usados na busca. Ex: array("idUsuario"=>5);
    * @return unknown $usuarios - um array contendo os usuários retornados na busca
    */
    public function buscar($campos,$filtros){
        $query = "SELECT ";

        if(count($campos) == 0){
            $campos = array("*");
        }

        $query .= implode(',',$campos)."FROM obra";

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
               // $usuarios[] = new Usuario($item['idUsuario'],$item['email'],$item['nome'],$item['sobrenome'],$item['senha'],$item['cadastroConfirmado']);
            }    
        }
        
        return $usuarios;
    }

    /**
    * Busca um ou várias obras aleatórias no banco de dados;
    * @param unknown $campos - um array contendo os campos desejados, caso receba um valor vazio ou null considera que esteja solicitando todos os campos
    * @param unknown $limite - o número máximo de retornos de uma busca
    * @return unknown $obras - um array contendo as notícias retornados na busca
    */
    public function buscarAleatoria($campos,$limite=0){

        $query = "SELECT ";

        if(count($campos) == 0){
            $campos = array("*");
        }

        $query .= implode(',',$campos)."FROM obra";

        $query .= "ORDER BY RAND() ";

        if($limite > 0 ){
            $query .= "LIMIT ".$limite;
        }

        $result = $this->PDO->query($query);

        $obras = array();
        if(!empty($result) && $result->rowCount() > 0){
            foreach($result->fetchAll() as $item){
                $obras[] = new Obra($item['idNoticia'],$item['email'],$item['nome'],$item['sobrenome'],$item['senha'],$item['cadastroConfirmado']);
            }    
        }
        
        return $obras;
    }
}


?>