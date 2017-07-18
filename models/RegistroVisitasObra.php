<?php
namespace models;

/**
 * Classe responsável por representar o registro de visitas a uma obra.
 * @author MItologhic Software
 *
 */
class RegistroVisitasObra {
    /* Atributos da visita */
    private $numeroInventario;
    private $quantidadeVisitas;

    /**
    * Construtor da classe.
    */
    public function __construct($numeroInventario, $quantidadeVisitas) {
        $this->numeroInventario = $numeroInventario;
        $this->quantidadeVisitas = $quantidadeVisitas;
    }

    /**
     * Obtém o id da obra em questão
     * @return $numeroInventario
     */
    public function getNumeroInventario() {
        return $this->numeroInventario;
    }    

    /**
     * Obtém a quantidade de visistas
     * @return $quantidadeVisitas
     */
    public function getQuantidadeVisitas() {
        return $this->quantidadeVisitas;
    }


}

?>