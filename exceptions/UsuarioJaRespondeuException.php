<?php
namespace exceptions;

/**
 * Classe responsável por representar uma exceção lançada quando um usuário já respondeu a uma pesquisa específica
 * @author MItologhic Software
 *
 */

class UsuarioJaRespondeuException extends \Exception
{
    
    /**
	* Construtor da classe.
	*/
    public function __construct()
    {
        parent::__construct("Você já respondeu esta pesquisa");
    }
}
