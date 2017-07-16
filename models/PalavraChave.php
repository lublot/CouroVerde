<?php
namespace models;

/**
 * Classe responsável por representar uma palavra-chave da obra no contexto do sistema.
 * @author MItologhic Software
 *
 */
class PalavraChave {
    /* Atributos da palavra-chave */
    private $id;
    private $descricao;

    /**
     * Construtor da classe
     * @param unknown $id - Id da palavra-chave    
     * @param unknown $descricao - Nome da palavra-chave
     */
    public function __construct($id, $descricao) {
        $this->id = $id;
        $this->descricao = $descricao;
    }

    /**
     * Obtém o id da palavra-chave.
     * @return id
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Obtém a descrição da palavra-chave.
     * @return descricao
     */
    public function getDescricao() {
        return $this->descricao;
    }

    /**
     * Configura a descrição da palavra-chave.
     * @param unknown $descricao - Descrição da palavra-chave
     */
    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }
}

?>