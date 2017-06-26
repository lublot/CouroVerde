<?php
namespace exceptions;

/**
 * Classe responsável por representar uma exceção lançada quando os dados do cadastro não são recebidos corretamente.
 * @author MItologhic Software
 *
 */

class DadosCorrompidosException extends Exception
{
    
    /**
	* Construtor da classe.
	*/
    public function __construct()
    {
        parent::__construct("Os dados do seu cadastro não foram recebidos corretamente. Tente novamente!");
    }
}
