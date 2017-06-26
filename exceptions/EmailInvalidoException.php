<?php
namespace exceptions;

/**
 * Classe responsável por representar uma exceção lançada quando o email é preenchido de forma incorreta durante o cadastro de usuário.
 * @author MItologhic Software
 *
 */

class EmailInvalidoException extends Exception
{
    
    /**
	* Construtor da classe.
	*/
    public function __construct()
    {
        parent::__construct("Informe um endereço de email existente.");
    }
}
