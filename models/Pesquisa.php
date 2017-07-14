<?php
namespace models;
/**
 * Classe responsável por representar um formulario de pesquisa no contexto do sistema.
 * @author MItologhic Software
 *
 */
class Pesquisa {
    
    private $idPesquisa;
    private $titulo;
    private $estaAtiva;

    /**
     * Construtor da classe
     * @param unknown $idPesquisa - Id da pesquisa     
     * @param unknown $titulo - Título da pesquisa
     * @param unknown $estaAtiva - Diz se a pesquisa tá ativa ou não
     */
    public function __construct($idPesquisa, $titulo, $estaAtiva) {
        $this->idPesquisa = $idPesquisa;
        $this->titulo = $titulo;
        $this->estaAtiva = $estaAtiva;
    }

    /**
     * Obtém o id da pesquisa.
     * @return idPesquisa
     */
    public function getIdPesquisa(){
        return $this->idPesquisa;
    }

    /**
     * Obtém o titulo da pesquisa.
     * @return titulo
     */
    public function getTitulo(){
        return $this->titulo;
    }

    /**
     * Configura o titulo da pesquisa.
     * @param unknown $titulo - titulo da pesquisa
     */
    public function setTitulo($titulo){
        $this->titulo = $titulo;
    }

    /**
     * Verfica se a pesquisa está ativa.
     * @return estaAtiva
     */
    public function getEstaAtiva(){
        return $this->estaAtiva;
    }

    /**
     * Configura a validade da pesquisa.
     * @param unknown $estaAtiva - Validade da pesquisa
     */
    public function setEstaAtiva($estaAtiva){
        $this->estaAtiva = $estaAtiva;
    }
}
?>