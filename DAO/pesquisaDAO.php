<?php
namespace DAO;

require_once dirname(__DIR__).'/vendor/autoload.php';
use \models\Pesquisa as Pesquisa;
use \DAO\Database as Database;

class PesquisaDAO extends DataBase{

    public function inserir($pesquisa){
        $titulo = $pesquisa->getTitulo();
        $estaAtiva = $pesquisa->getEstaAtiva();

        $query = "INSERT INTO pesquisa(idPesquisa, titulo, estaAtiva) VALUES (null, '$titulo', '$estaAtiva')";

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