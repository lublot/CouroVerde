<?php
namespace DAO;

require_once dirname(__DIR__).'/vendor/autoload.php';
use \models\Pergunta as Pergunta;
use \DAO\Database as Database;

class PerguntaDAO extends DataBase {

    public function inserir($pergunta){
        $titulo = $pergunta->getTitulo();
        $tipo = $pergunta->getTipo();
        $opcional = $pergunta->getIsOpcional();

        $query = "INSERT INTO pergunta(idPergunta, titulo, tipo, opcional) VALUES (null, '$titulo', '$tipo', '$opcional')";

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