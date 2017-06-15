<?php

class UsuarioDAO extends Database{

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
    * Altera informações de um usuário no banco de dados;
    * @param unknown $dados - um array contendo as colunas e valores para a alteração. Ex: array("nome"=>"João");
    * @param unknown $filtros - um array contendo os filtros usados na busca. Ex: array("idUsuario"=>5);
    * */
    public function alterar($dados,$filtros){
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

    /**
    * Remove um usuário do banco de dados;
    * @param unknown $filtros - um array contendo os filtros usados na identificação do usuário. Ex: array("idUsuario"=>5);
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
    * Busca um ou vários usuários no banco de dados;
    * @param unknown $campos - um array contendo os campos desejados
    * @param unknown $filtros - um array contendo os filtros usados na busca. Ex: array("idUsuario"=>5);
    * @return unknown $usuarios - um array contendo os usuários retornados na busca
    */
    public function buscar($campos,$filtros){
        $query = "SELECT ";

        if(count($campos) == 0){
            $campos = array("*");
        }

        $query .= implode(',',$campos)." FROM usuario";

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
                $usuarios[] = new Usuario(isset($item['idUsuario'])?$item['idUsuario']:null,
                                          isset($item['email'])?$item['email']:null,
                                          isset($item['nome'])?$item['nome']:null,
                                          isset($item['sobrenome'])?$item['sobrenome']:null,
                                          isset($item['senha'])?$item['senha']:null,
                                          isset($item['cadastroConfirmado'])?$item['cadastroConfirmado']:null);
            }    
        }
        
        return $usuarios;
    }


    /**
    * Insere um usuário na tabela usuariogoogle;
    * @param unknown $idGoogle - o id da conta Google do usuário
    * @param unknown $idUsuario - o usuário já inserido no banco;
    * */
    public function inserirUsuarioGoogle($idGoogle,$idUsuario){
        $query = "INSERT INTO `usuariogoogle`(`idUsuarioGoogle`, `idUsuario`) 
                  VALUES ('$idGoogle','$idUsuario')";
        try{
            $this->PDO->query($query);
        }catch(PDOException $e){

        }
    }


    /**
    * Busca um ou vários usuários no banco de dados;
    * @param unknown $camposTabelaGoogle - um array contendo os campos desejados da tabela 'usuariosGoogle'
    * @param unknown $camposTabelaUsuario - um array contendo os campos desejados da tabela 'usuario'
    * @param unknown $filtros - um array contendo os filtros usados na busca. Ex: array("idUsuario"=>5);
    * @return unknown $usuarios - um array contendo os usuários retornados na busca
    */
    public function buscarUsuarioGoogle($camposTabelaGoogle,$camposTabelaUsuario,$filtros){
        $query = "SELECT ";
        $tabela1 = "usuariogoogle";
        $tabela2 = "usuario";
        $campos;
        $camposTabela1 = array();
        $camposTabela2 = array();

        if(count($camposTabelaGoogle) == 0){ //Prepara a string do campo desejado
            $camposTabela1 = $tabela1.'.'."*";
        }else{
            foreach($camposTabelaGoogle as $key){
                $camposTabela1[] = $tabela1.'.'.$key;
            }
        }

        if(count($camposTabelaUsuario)==0){ //Prepara a string do campo desejado
            $camposTabela2 = $tabela2.'.'."*";
        }else{
            foreach($camposTabelaUsuario as $key){
                $camposTabela2[] = $tabela2.'.'.$key;
            }
        }

       
        
        while(!empty($camposTabela1) || !empty($camposTabela2)){//Adiciona os campos desejados da tabela 1 no array
            if(count($camposTabela1)>0){
                $campos[] = array_shift($camposTabela1);
            }

            if(count($camposTabela2)>0){
                $campos[] = array_shift($camposTabela2);
            }
        }       

        $query .= implode(', ',$campos)." FROM $tabela1";

        $query .= " INNER JOIN $tabela2 ON $tabela1.idUsuarioGoogle = $tabela2.idUsuario";

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
                $usuarios[] = new Usuario(isset($item['idUsuario'])?$item['idUsuario']:null,
                                          isset($item['email'])?$item['email']:null,
                                          isset($item['nome'])?$item['nome']:null,
                                          isset($item['sobrenome'])?$item['sobrenome']:null,
                                          isset($item['senha'])?$item['senha']:null,
                                          isset($item['cadastroConfirmado'])?$item['cadastroConfirmado']:null);
            }    
        }
        
        return $usuarios;
    }
}
?>
