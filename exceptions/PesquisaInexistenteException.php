<?php
namespace exceptions;

/**
 * Classe responsável por representar uma exceção lançada quando não existe uma pesquisa cadastrada no sistema
 * @author MItologhic Software
 *
 */
class PesquisaInexistenteException extends \Exception
{
    
    /**
	* Construtor da classe.
	*/
    public function __construct()
    {
        parent::__construct("Pesquisa não encontrada");
    }
}