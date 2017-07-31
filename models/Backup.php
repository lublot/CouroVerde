<?php
namespace models;

/**
* Classe responsável por modelar um backup no contexto do sistema
* @author MItologhic Software
*
*/
class Backup implements \JsonSerializable {

    //Atributos da classe
    private $id; 
    private $dia;
    private $hora;
    private $caminho;

     /**
     * Construtor da classe
     * @param int $id - id do backup      
     * @param String $dia - dia em que o backup foi realizado   
     * @param String $hora - hora em que o backup foi realizado
     * @param String $caminho - caminho em que o backup está armazenado
     */
    public function __construct($id = null, $dia, $hora, $caminho) {
        $this->id = $id;
        $this->dia = $dia;
        $this->hora = $hora;
        $this->caminho = $caminho;
    }

    /**
     * Obtém o id do backup;
     * @return $id
     */
    public function getId() {
        return $this->id;
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

    /**
     * Define como os dados da classe serão utilizados na conversão para um json.
     * @return dados da classe em formato .json
     */
    public function jsonSerialize() {
        return [
            'idBackup' => $this->id,
            'dia' => $this->dia,
            'hora' => $this->hora,
            'caminho' => $this->caminho            
        ];
    }    

}