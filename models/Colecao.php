<?php
namespace models;

/**
 * Classe responsável por representar uma coleção da obra no contexto do sistema.
 * @author MItologhic Software
 *
 */
class Colecao {
    /* Atributos da coleção */
    private $id;
    private $nome;

    /**
     * Construtor da classe
     * @param unknown $id - Id da coleção     
     * @param unknown $nome - Nome da coleção
     */
    public function __construct($id, $nome) {
        $this->id = $id;
        $this->nome = $nome;
    }

    /**
     * Obtém o id da coleção.
     * @return id
     */
    public function getid() {
        return $this->id;
    }

    /**
     * Obtém o nome da coleção.
     * @return nome
     */
    public function getNome() {
        return $this->nome;
    }

    /**
     * Configura o nome da coleção.
     * @param unknown $nome - Nome da coleção
     */
    public function setNome($nome) {
        $this->nome = $nome;
    }
}

?>