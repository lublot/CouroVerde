<?php
namespace DAO;

require_once dirname(__DIR__).'/vendor/autoload.php';
use \DAO\Database as a;
use \DAO\usuarioDAO as usuarioDAO;
use \models\Usuario as Usuario;
use \models\Funcionario as Funcionario;

class FuncionarioDAO extends Database{

    /**
    * Recupera o ID do ultimo funcionário cadastrado
    * @return $idUsuario
    */
    public function getUltimoIdInserido(){
        $idUsuario = $this->PDO->query("SELECT LAST_INSERT_ID()");
        return $idUsuario;
    }

    /**
    * Insere um funcionário no banco de dados;
    * @param unknown $funcionario - o funcionário a ser inserido no banco;
    * */
    public function inserir($funcionario){
        
        $nome = $funcionario->getNome();
        $sobrenome = $funcionario->getSobrenome();
        $email = $funcionario->getEmail();
        $senha = $funcionario->getSenha();
        $cadastroConfirmado = $funcionario->confirmouCadastro();
        $tipoUsuario = $funcionario->getTipo();

        $matricula = $funcionario->getMatricula();
        $funcao = $funcionario->getFuncao();
        $cadastraObra = $funcionario->isPodeCadastrarObra();
        $gerenciaObra = $funcionario->isPodeGerenciarObra();
        $removeObra = $funcionario->isPodeRemoverObra();
        $cadastraNoticia = $funcionario->isPodeCadastrarNoticia();
        $gerenciaNoticia = $funcionario->isPodeGerenciarNoticia();
        $removeNoticia = $funcionario->isPodeRemoverNoticia();
        $backup = $funcionario->isPodeRealizarBackup();

        $usuarioDAO = new UsuarioDAO();
        $novoUsuario = new Usuario(null, $email, $nome, $sobrenome, $senha, $cadastroConfirmado, $tipoUsuario);
        $usuarioDAO->inserir($novoUsuario);

        $resultado = $usuarioDAO->buscar(array("idUsuario"), array("email" => $email));
        $id = $resultado[0]->getId();

        $queryFuncionario = "INSERT INTO funcionario(matricula, idUsuario, funcao, cadastroObra, gerenciaObra, remocaoObra, cadastroNoticia, gerenciaNoticia, remocaoNoticia, backup) VALUES ('$matricula', '$id', '$funcao', '$cadastraObra', '$gerenciaObra', '$removeObra', '$cadastraNoticia', '$gerenciaNoticia', '$removeNoticia', '$backup')";
        try{
            $this->PDO->query($queryFuncionario);
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
    public function buscar($campos, $filtros){
        $query = "SELECT ";

        if(count($campos) == 0){
            $campos = array("*");
        }

        $query .= implode(',',$campos)." FROM funcionario INNER JOIN usuario ON usuario.idUsuario = funcionario.idUsuario";

        if(count($filtros) > 0){
            $query .= " WHERE ";
            $aux = array();

            foreach($filtros as $chave=>$valor){
                if($chave == 'matricula' || $chave == 'idUsuario' || $chave == 'funcao') {
                    $aux[] = 'funcionario.'.$chave."="."'$valor'";
                } else {
                    $aux[] = 'usuario.'.$chave."="."'$valor'";
                }
            }
            
            $query .= implode(" AND ",$aux);
        }

        $myfile = fopen("C:\wamp64\www\sertour/newfile.txt", "w") or die("Unable to open file!");
        fwrite($myfile, $query);
        fclose($myfile);
        
        //Faço uma busca na tabela funcionario e retorno os valores
        $result = $this->PDO->query($query);


        
        $funcionarios = array();
        if(!empty($result) && $result->rowCount() > 0){
            foreach($result->fetchAll() as $item){
                if(isset($item['cadastroConfirmado'])) {
                    $cadastroConfirmado = strcmp($item['cadastroConfirmado'], 1)?true:false;
                } else {
                    $cadastroConfirmado = null;
                }
                $funcionarios[] = new Funcionario(
                    isset($item['idUsuario'])?$item['idUsuario']:null,
                    isset($item['email'])?$item['email']:null,
                    isset($item['nome'])?$item['nome']:null,
                    isset($item['sobrenome'])?$item['sobrenome']:null,
                    isset($item['senha'])?$item['senha']:null,
                    $cadastroConfirmado,
                    isset($item['tipoUsuario'])?$item['tipoUsuario']:null,
                    isset($item['matricula'])?$item['matricula']:null,
                    isset($item['funcao'])?$item['funcao']:null,
                    isset($item['cadastroObra'])?$item['cadastroObra']:null,
                    isset($item['gerenciaObra'])?$item['gerenciaObra']:null,
                    isset($item['remocaoObra'])?$item['remocaoObra']:null,
                    isset($item['cadastroNoticia'])?$item['cadastroNoticia']:null, 
                    isset($item['gerenciaNoticia'])?$item['gerenciaNoticia']:null,
                    isset($item['remocaoNoticia'])?$item['remocaoNoticia']:null,
                    isset($item['backup'])?$item['backup']:null
                );
            }    
        }
        return $funcionarios;
    }

    /**
    * Busca um ou vários funcionários no banco de dados pelo nome;
    * @param unknown $campos - um array contendo os campos desejados
    * @param unknown $filtros - um array contendo os filtros usados na busca. Ex: array("matricula"=>5);
    * @return unknown $funcionarios - um array contendo os funcionários retornados na busca
    */
    public function buscarLikeNome($campo){
        $query = "SELECT Usuario.*, Funcionario.*  FROM Usuario JOIN Funcionario 
        ON Usuario.idUsuario = Funcionario.idUsuario WHERE Usuario.nome LIKE '%$campo%'"; //adicionar filtro de nome, sobrenome ou email à query

        /*Caso não seja especificados filtros retorna todos os funcionarios*/

        $result = $this->PDO->query($query); //executa a query

        $funcionarios = array(); //cria array para armazenar os resultados da consulta

        if(!empty($result) && $result->rowCount() > 0){ //verifica se existem resultados para consulta
            foreach($result->fetchAll() as $item){ //percorre as tuplas retornadas pela consulta
                $funcionarios[] = new funcionario( //cria um novo funcionario e add uma array, apartir dos dados obtidos
                    isset($item['idUsuario'])?$item['idUsuario']:null,
                    isset($item['nome'])?$item['nome']:null,
                    isset($item['sobrenome'])?$item['sobrenome']:null,
                    isset($item['email'])?$item['email']:null,
                    null, //Não retorna a senha
                    isset($item['cadastroConfirmado'])?$item['cadastroConfirmado']:null,
                    isset($item['tipoUsuario'])?$item['tipoUsuario']:null,
                    isset($item['matricula'])?$item['matricula']:null,
                    isset($item['funcao'])?$item['funcao']:null,
                    isset($item['cadastroObra'])?$item['cadastroObra']:null,
                    isset($item['gerenciaObra'])?$item['gerenciaObra']:null,
                    isset($item['remocaoObra'])?$item['remocaoObra']:null,
                    isset($item['cadastroNoticia'])?$item['cadastroNoticia']:null, 
                    isset($item['gerenciaNoticia'])?$item['gerenciaNoticia']:null,
                    isset($item['remocaoNoticia'])?$item['remocaoNoticia']:null,
                    isset($item['backup'])?$item['backup']:null
                );
            }
        }

        return $funcionarios;  //retorna os resultados
    }
    /**
    * Busca um funcionario por nome, sobrenome, email ou matricula
    */

    public function buscarFuncionarioPorCampo($campo, $filtro){
        
        $query = "SELECT Usuario.*, Funcionario.*  FROM Usuario JOIN Funcionario 
        ON Usuario.idUsuario = Funcionario.idUsuario"; //criação da query base

        if(isset($campo) && isset($filtro)){ //verifica se os filtros foram especificados
            if(strcmp($campo, nome) || strcmp($campo, sobrenome) || strcmp($campo, email)){ //verifica se o campo corresponde a nome, sobrenome ou email
                $query .= " WHERE Usuario.nome LIKE '%'.'.$campo.'.'%'"; //adicionar filtro de nome, sobrenome ou email à query
            }else if(strcmp($campo, matricula)){ //verifica se o campo corresponde a matricula
                $query .= " WHERE Funcionario.matricula = $campo"; //adiciona filtro de matricula à query
            }else{
                return array(); //retorna um array vazio caso o campo não seja encontrado
            }
        }

        /*Caso não seja especificados filtros retorna todos os funcionarios*/

        $result = $this->PDO->query($query); //executa a query

        $funcionarios = array(); //cria array para armazenar os resultados da consulta

        if(!empty($result) && $result->rowCount() > 0){ //verifica se existem resultados para consulta
            foreach($result->fetchAll() as $item){ //percorre as tuplas retornadas pela consulta
                $funcionarios[] = new funcionario( //cria um novo funcionario e add uma array, apartir dos dados obtidos
                    isset($item['idUsuario'])?$item['idUsuario']:null,
                    isset($item['email'])?$item['email']:null,
                    isset($item['nome'])?$item['nome']:null,
                    isset($item['sobrenome'])?$item['sobrenome']:null,
                    isset($item['senha'])?$item['senha']:null,
                    isset($item['cadastroConfirmado'])?$item['cadastroConfirmado']:null,
                    isset($item['tipoUsuario'])?$item['tipoUsuario']:null,
                    isset($item['matricula'])?$item['matricula']:null,
                    isset($item['funcao'])?$item['funcao']:null,
                    isset($item['cadastroObra'])?$item['cadastroObra']:null,
                    isset($item['gerenciaObra'])?$item['gerenciaObra']:null,
                    isset($item['remocaoObra'])?$item['remocaoObra']:null,
                    isset($item['cadastroNoticia'])?$item['cadastroNoticia']:null, 
                    isset($item['gerenciaNoticia'])?$item['gerenciaNoticia']:null,
                    isset($item['remocaoNoticia'])?$item['remocaoNoticia']:null,
                    isset($item['backup'])?$item['backup']:null
                );
            }
        }

        return $funcionarios;  //retorna os resultados
    }

}

?>