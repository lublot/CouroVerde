<?php
namespace exceptions;

/**
 * Classe responsável por representar uma exceção lançada quando uma noticia é pesquisado pelo ID e não é encontrada no BD.
 * @author MItologhic Software
 *
 */

class NoticiaNaoEncontradaException extends \Exception
{
    
    /**
	* Construtor da classe.
	*/
    public function __construct()
    {
        parent::__construct("A noticia não foi encontrada..");
    }
}