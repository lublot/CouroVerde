<?php
namespace models;

/**
 * Classe responsável por representar uma classificação da obra no contexto do sistema.
 * @author MItologhic Software
 *
 */
class Classificacao {
    /* Atributos da classificação */
    private $id;
    private $nome;

    /**
     * Construtor da classe
     * @param unknown $id - Id da classificação     
     * @param unknown $nome - Nome da classificação
     */
    public function __construct($id, $nome) {
        $this->id = $id;
        $this->nome = $nome;
    }

    /**
     * Obtém o id da classificação.
     * @return id
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Obtém o nome da classificação.
     * @return nome
     */
    public function getNome() {
        return $this->nome;
    }

    /**
     * Configura o nome da classificação.
     * @param unknown $nome - Nome da classificação
     */
    public function setNome($nome) {
        $this->nome = $nome;
    }
}

?>