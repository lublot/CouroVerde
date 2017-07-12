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

        $resultado = $usuarioDAO->buscar(array("email"), array("email" => $email));
        $id = $resultado[0]->getId();

        //$queryUsuario = "INSERT INTO usuario(idUsuario, nome, sobrenome, email, senha, cadastroConfirmado, tipoUsuario) VALUES (null, '$nome', '$sobrenome', '$email', '$senha', $cadastroConfirmado,'$tipoUsuario')";

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