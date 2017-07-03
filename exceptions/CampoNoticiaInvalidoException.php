<?php
namespace exceptions;

/**
 * Classe responsável por representar uma exceção lançada quando um campo da notícia é preenchido incorretamente.
 * @author MItologhic Software
 *
 */

class CampoNoticiaInvalidoException extends \Exception
{
    
    /**
	* Construtor da classe.
    * @param String $campo campo no qual o erro ocorreu
	*/
    public function __construct($campo)
    {
        parent::__construct("O campo ".$campo." da notícia foi preenchido incorretamente.");
    }
}
