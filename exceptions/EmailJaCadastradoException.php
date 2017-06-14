<?php
/**
 * Classe responsável por representar uma exceção lançada quando já existe usuário cadastrado com o email informado.
 * @author MItologhic Software
 *
 */
class EmailJaCadastradoException extends Exception
{
    
    /**
	* Construtor da classe.
	*/
    public function __construct()
    {
        parent::__construct("O email informado já foi cadastrado no sistema.");
    }
}