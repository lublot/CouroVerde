<?php
namespace models;

/**
 * Classe responsável por representar um formulario de pesquisa no contexto do sistema.
 * @author MItologhic Software
 *
 */

class Pesquisa {
    private $idPesquisa;
    private $nome;
    private $descricao;

    /**
     * Construtor da classe
     * @param unknown $idPesquisa - Id da pesquisa     
     * @param unknown $nome - Nome da pesquisa
     * @param unknown $descricao - Descrição da pesquisa
     */
    public function __construct($idPesquisa, $nome, $descricao) {
        $this->idPesquisa = $idPesquisa;
        $this->nome = $nome;
        $this->descricao = $descricao;
    }

    /**
     * Obtém o id da pesquisa.
     * @return idPesquisa
     */
    public function getIdPesquisa(){
        return $this->idPesquisa;
    }

    /**
     * Obtém o nome da pesquisa.
     * @return nome
     */
    public function getNome(){
        return $this->nome;
    }

    /**
     * Configura o nome da pesquisa.
     * @param unknown $nome - Nome da pesquisa
     */
    public function setNome($nome){
        $this->nome = $nome;
    }

    /**
     * Obtém o descrição da pesquisa.
     * @return descricao
     */
    public function getDescricao(){
        return $this->descricao;
    }

    /**
     * Configura a descrição da pesquisa.
     * @param unknown $descricao - Descrição da pesquisa
     */
    public function setDescricao($descricao){
        $this->descricao = $descricao;
    }


}
?>