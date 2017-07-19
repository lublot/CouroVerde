<?php
namespace exceptions;

/**
 * Classe responsável por representar uma exceção lançada quando um usuário tenta realizar uma ação que não tem privilégios.
 * @author MItologhic Software
 *
 */

class PermissaoNaoConcedidaException extends \Exception
{
    
    /**
	* Construtor da classe.
	*/
    public function __construct()
    {
        parent::__construct("Infelizmente esse usuário não permissão para fazer esta ação");
    }
}