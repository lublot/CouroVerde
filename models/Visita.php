<?php
namespace models;
/**
 * Classe responsável por representar a visita uma obra.
 * @author MItologhic Software
 *
 */
class Visita {
    //Atributos da visita
    private $idVisitante;
    private $numeroInventario;

    /**
    * Construtor da classe.
    */
    public function __construct($idVisitante, $numeroInventario) {
        $this->idVisitante = $idVisitante;
        $this->numeroInventario = $numeroInventario;
    }

    /**
    * Obtém o id do visitante.
    */
    public function getIdVisitante() {
        return $this->idVisitante;
    }

    /**
    * Obtém o número de inventário da obra em questão.
    */
    public function getNumeroInventario() {
        return $this->numeroInventario;
    }
    

}

?>