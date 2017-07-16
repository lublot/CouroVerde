<?php
namespace DAO;

require_once dirname(__DIR__).'/vendor/autoload.php';
use \models\OpcaoPergunta as OpcaoPergunta;
use \DAO\Database as Database;

class OpcaoPerguntaDAO extends DataBase {

    public function inserir($opcaoPergunta){
        $descricao = $opcaoPergunta->getDescricao();

        $query = "INSERT INTO opcao(idOpcao, descricao) VALUES (null, '$descricao')";

        try{
            $this->PDO->query($query);
        }catch(PDOException $e){

        }
    }

    public function alterar($dados, $filtros){

    }

    public function remover($filtros){

    }

    public function buscar($campos, $filtros){

    }
}

?>