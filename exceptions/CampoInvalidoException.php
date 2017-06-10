<?php
/**
 * Classe responsável por representar uma exceção lançada quando um campo é preenchida de forma inválida.
 * @author MItologhic Software
 *
 */

class CampoInvalidoException extends Exception
{
    /**
	* Construtor da classe.
    * @param unknown $campo campo inválido
	*/
    public function __construct($campo)
    {
        parent::__construct("O campo ".$campo." não foi preenchido. Tente novamente!");
    }
}
