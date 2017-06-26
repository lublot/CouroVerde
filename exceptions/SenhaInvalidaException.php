<?php
namespace exceptions;

/**
 * Classe responsável por representar uma exceção lançada quando uma senha é preenchida de forma incorreta durante o cadastro de usuário.
 * @author MItologhic Software
 *
 */

class SenhaInvalidaException extends \Exception
{
    
    /**
	* Construtor da classe.
	*/
    public function __construct()
    {
        parent::__construct("Informe uma senha que contenha no máximo 8 e no mínimo 32 caracteres.");
    }
}
