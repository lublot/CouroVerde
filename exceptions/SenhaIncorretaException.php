<?php
namespace exceptions;

/**
 * Classe responsável por representar uma exceção lançada quando a senha está incorreta.
 * @author MItologhic Software
 *
 */

class SenhaIncorretaException extends \Exception
{
    
    /**
	* Construtor da classe.
	*/
    public function __construct()
    {
        parent::__construct("Senha incorreta");
    }
}