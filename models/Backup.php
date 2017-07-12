<?php
namespace models;

/**
* Classe responsável por modelar um backup no contexto do sistema
* @author MItologhic Software
*
*/
class Backup {

    //Atributos da classe
    private $dia;
    private $hora;
    private $caminho;

     /**
     * Construtor da classe
     * @param unknown $dia - dia em que o backup foi realizado   
     * @param unknown $hora - hora em que o backup foi realizado
     * @param unknown $caminho - caminho em que o backup está armazenado
     */
    public function __construct($dia, $hora, $caminho) {
        $this->dia = $dia;
        $this->hora = $hora;
        $this->caminho = $caminho;
    }

    /**
     * Obtém o dia em que foi realizado o backup.
     * @return $dia
     */
    public function getDia() {
        return $this->dia;
    }

    /**
     * Obtém a hora na qual o backup foi realizado.
     * @return $hora
     */
    public function getHora() {
        return $this->hora;
    }

    /**
     * Obtém o caminho no qual o backup está armazenado.
     * @return $hora
     */
    public function getCaminho() {
        return $this->caminho;
    }

}