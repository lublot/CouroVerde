<?php
namespace DAO;

require_once dirname(__DIR__).'/vendor/autoload.php';
use \DAO\Database as a;
use \DAO\usuarioDAO as usuarioDAO;
use \models\Usuario as Usuario;
use \models\Funcionario as Funcionario;

class FuncionarioDAO extends Database{

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
                $funcionarios[] = new funcionario(
                    isset($item['idUsuario'])?$item['idUsuario']:null,
                    isset($item['nome'])?$item['nome']:null,
                    isset($item['sobrenome'])?$item['sobrenome']:null,
                    isset($item['email'])?$item['email']:null,
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
        
        return $funcionarios;
    }

    public function buscarFuncionarioPorCampo($campo, $filtro){ //busca por nome, sobrenome, email, matricula
        if(strcmp($campo, nome) || strcmp($campo, sobrenome) || strcmp($campo, email)){ //verifica se o campo corresponde a nome, sobrenome ou email
            $query = "SELECT Usuario.*, Funcionario.*  FROM Usuario JOIN Funcionario 
                        ON Usuario.idUsuario = Funcionario.idUsuario 
                        WHERE Usuario.nome LIKE '%'.'.$campo.'.'%'"; //query procura usuario pelo nome, sobrenome ou email no banco de dados
        }else if(strcmp($campo, matricula)){
            $query = "SELECT Usuario.*, Funcionario.*  FROM Usuario JOIN Funcionario 
                        ON Usuario.idUsuario = Funcionario.idUsuario 
                        WHERE Funcionario.matricula = $campo"; //query procura o funcionario pela matricula
        }

        $result = $this->PDO->query($query); //executa a query

        $funcionarios = array(); //cria array para armazenar os resultados da consulta

        if(!empty($result) && $result->rowCount() > 0){ //verifica se existem resultados para consulta
            foreach($result->fetchAll() as $item){ //percorre as tuplas retornadas pela consulta
                $funcionarios[] = new funcionario( //cria um novo funcionario e add uma array, apartir dos dados obtidos
                    isset($item['idUsuario'])?$item['idUsuario']:null,
                    isset($item['nome'])?$item['nome']:null,
                    isset($item['sobrenome'])?$item['sobrenome']:null,
                    isset($item['email'])?$item['email']:null,
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