<?php

namespace DAO;

class funcionarioDAO extends Database{

    /**
    * Insere um funcionário no banco de dados;
    * @param unknown $funcionario - o funcionário a ser inserido no banco;
    * */
    public function inserir($funcionario){
        
        $nome = $funcionario->getNome();
        $sobrenome = $funcionario->getSobrenome();
        $email = $funcionario->getEmail();
        $senha = $funcionario->getSenha();
        $cadastroConfirmado = 1;

        $query = "INSERT INTO funcionario(matricula, funcao, cadastraObra, gerenciaObra, removeObra, cadastraNoticia, gerenciaNoticia, removeNoticia,backup) VALUES (null, '$nome', '$sobrenome', '$email', '$senha', $cadastroConfirmado)";

        try{
            $this->PDO->query($query);
        }catch(PDOException $e){

        }
    }

    /**
    * Altera informações de um funcionário no banco de dados;
    * @param unknown $dados - um array contendo as colunas e valores para a alteração. Ex: array("nome"=>"João");
    * @param unknown $filtros - um array contendo os filtros usados na busca. Ex: array("matricula"=>5);
    * */
    public function alterar($dados,$filtros){
        $query = "UPDATE funcionario SET ";

        foreach($dados as $chave=>$valor){
            $query .= $chave.'='."'$valor',";
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
    * Remove um funcionário do banco de dados;
    * @param unknown $filtros - um array contendo os filtros usados na identificação do funcionário. Ex: array("matricula"=>5);
    * */
    public function remover($filtros){
        $query = "DELETE FROM funcionario WHERE ";

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
    * Busca um ou vários funcionários no banco de dados;
    * @param unknown $campos - um array contendo os campos desejados
    * @param unknown $filtros - um array contendo os filtros usados na busca. Ex: array("matricula"=>5);
    * @return unknown $funcionarios - um array contendo os funcionários retornados na busca
    */
    public function buscar($campos,$filtros){
        $query = "SELECT ";

        if(count($campos) == 0){
            $campos = array("*");
        }

        $query .= implode(',',$campos)." FROM funcionario";

        if(count($filtros) > 0){
            $query .= " WHERE ";
            $aux = array();

            foreach($filtros as $chave=>$valor){
                $aux[] = $chave."="."'$valor'";
            }
            
            $query .= implode(" AND ",$aux);
        }

        $result = $this->PDO->query($query);

        $funcionarios = array();
        if(!empty($result) && $result->rowCount() > 0){
            foreach($result->fetchAll() as $item){
                $funcionarios[] = new funcionario(isset($item['matricula'])?$item['matricula']:null,
                                          isset($item['email'])?$item['email']:null,
                                          isset($item['nome'])?$item['nome']:null,
                                          isset($item['sobrenome'])?$item['sobrenome']:null,
                                          isset($item['senha'])?$item['senha']:null,
                                          isset($item['cadastroConfirmado'])?$item['cadastroConfirmado']:null);
            }    
        }
        
        return $funcionarios;
    }   
}

?>