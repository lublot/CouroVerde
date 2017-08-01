<?php
namespace exceptions;

/**
 * Classe responsável por representar uma exceção lançada quando o sobrenome é preenchido de forma incorreta durante o cadastro de usuário.
 * @author MItologhic Software
 *
 */

class SobrenomeInvalidoException extends \Exception
{
    
    /**
	* Construtor da classe.
	*/
    public function __construct($mensagem)
    {
        parent::__construct($mensagem);
    }
}
