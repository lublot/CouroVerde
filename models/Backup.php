<?php
namespace models;

/**
* Classe responsável por modelar um backup no contexto do sistema
* @author MItologhic Software
*
*/
class Backup {

    //Atributos da classe
    private $id; 
    private $data;
    private $hora;
    private $caminho;

     /**
     * Construtor da classe
     * @param int $id - id do backup      
     * @param String $data - data em que o backup foi realizado   
     * @param String $hora - hora em que o backup foi realizado
     * @param String $caminho - caminho em que o backup está armazenado
     */
    public function __construct($id = null, $data, $hora, $caminho) {
        $this->id = $id;
        $this->data = $data;
        $this->hora = $hora;
        $this->caminho = $caminho;
    }

    /**
     * Obtém o id do backup;
     * @return $id
     */
    public function getCaminho() {
        return $this->id;
    }
    

    /**
     * Obtém o data em que foi realizado o backup.
     * @return $data
     */
    public function getdata() {
        return $this->data;
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