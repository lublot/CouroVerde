<?php
namespace exceptions;

/**
 * Classe responsável por representar uma exceção lançada quando já existe uma pesquisa criada com o mesmo título
 * @author MItologhic Software
 *
 */
class PesquisaJaExistenteException extends \Exception
{
    
    /**
	* Construtor da classe.
	*/
    public function __construct()
    {
        parent::__construct("Já existe uma pesquisa com este título");
    }
}