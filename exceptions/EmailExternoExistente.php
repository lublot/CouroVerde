<?php
namespace exceptions;

/**
 * Classe responsável por representar uma exceção lançada quando já existe usuário cadastrado com o email informado.
 * @author MItologhic Software
 *
 */
class EmailExternoExistente extends \Exception
{
    
    /**
	* Construtor da classe.
	*/
    public function __construct()
    {
        parent::__construct("O email da sua conta já está cadastrado no sistema.");
    }
}