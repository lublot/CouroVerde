<?php
namespace exceptions;

/**
 * Classe responsável por representar uma exceção lançada quando não existem respostas para uma pesquisa cadastrada no sistema
 * @author MItologhic Software
 *
 */
class RespostaInexistenteException extends \Exception
{
    
    /**
	* Construtor da classe.
	*/
    public function __construct()
    {
        parent::__construct("Não existem respostas para esta pesquisa");
    }
}