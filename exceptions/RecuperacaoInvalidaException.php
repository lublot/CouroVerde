<?php
namespace exceptions;

/**
 * Classe responsável por representar uma exceção lançada quando um email de conta externa tenta a recuperação de senha
 * @author MItologhic Software
 *
 */

class RecuperacaoInvalidaException extends \Exception
{
    
    /**
	* Construtor da classe.
	*/
    public function __construct()
    {
        parent::__construct("Não foi possível enviar o e-mail de recuperação!");
    }
}