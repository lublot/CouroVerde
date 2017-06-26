<?php
namespace exceptions;

/**
 * Classe responsável por representar uma exceção lançada quando a senha e a confirmação da senha são diferentes durante a redefinição.
 * @author MItologhic Software
 *
 */

class SenhaInconsistenteException extends Exception
{
    
    /**
	* Construtor da classe.
	*/
    public function __construct()
    {
        parent::__construct("As duas senhas não são iguais.");
    }
}