<?php
namespace DAO;

require_once dirname(__DIR__).'/vendor/autoload.php';
use \DAO\Database as a;
use \models\Usuario as Usuario;

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
        $cadastroConfirmado = $usuario->confirmouCadastro() == false ? 0 : 1;

        $query = "INSERT INTO usuario(idUsuario, nome, sobrenome, email, senha, cadastroConfirmado) VALUES (null, '$nome', '$sobrenome', '$email', '$senha', $cadastroConfirmado)";

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
    * Insere um usuário na tabela especifica de usuários da rede social especificada
    * @param String $idRedeSocial - o id da conta da rede social do usuário
    * @param int $idUsuario - o usuário já inserido no banco
    * @param String $redeSocial - nome da rede social usada pelo usuário no cadastro
    * */
    public function inserirUsuarioContaExterna($idRedeSocial,$idUsuario,$redeSocial){
        $query = "INSERT INTO `usuario".$redesocial."`(`idUsuarioGoogle`, `idUsuario`) 
                  VALUES ('$idRedeSocial','$idUsuario')";
        try{
            $this->PDO->query($query);
        }catch(PDOException $e){

        }
    }

   /**
    * Busca um ou vários usuários, cadastrados por conta externa (facebook ou google), no banco de dados
    * @param array $camposTabela - um array contendo os campos desejados da tabela referente aos usuarios da rede social especifica
    * @param array $camposTabelaUsuario - um array contendo os campos desejados da tabela 'usuario'
    * @param array $filtros - um array contendo os filtros usados na busca. Ex: array("idUsuario"=>5);
    * @param String $redeSocial - rede social usada no cadastro do usuário. Ex: array("idUsuario"=>5);
    * @return array $usuarios - um array contendo os usuários retornados na busca
    */
    public function buscarUsuarioContaExterna($camposTabela,$camposTabelaUsuario,$filtros,$redeSocial){
        $query = "SELECT ";
        
        if(strcmp($redeSocial, 'facebook') == 0) {
            $tabela1 = "usuariofacebook";
            $redeSocial = 'Facebook'; //renomeando com a inicial maiuscula pra usar depois
        } else if(strcmp($redeSocial, 'google') == 0) {
            $tabela1 = "usuariogoogle";
            $redeSocial = 'Google'; //renomeando com a inicial maiuscula pra usar depois
        }

        $tabela2 = "usuario";
        $campos;
        $camposTabela1 = array();
        $camposTabela2 = array();

        if(count($camposTabela) == 0){ //Prepara a string do campo desejado
            $camposTabela1 = $tabela1.'.'."*";
        }else{
            foreach($camposTabela as $key){
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


        $query .= " INNER JOIN $tabela2 ON $tabela1.idUsuario".$redeSocial. " = $tabela2.idUsuario";

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
