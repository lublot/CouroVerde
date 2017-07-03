<?php
namespace exceptions;

/**
 * Classe responsável por representar uma exceção lançada quando um arquivo essencial ao sistema não é encontrado.
 * @author MItologhic Software
 *
 */

class ArquivoNaoEncontradoException extends \Exception
{
    /**
	* Construtor da classe.
    * @param unknown $campo campo inválido
	*/
    public function __construct($campo)
    {
        parent::__construct("Um arquivo essencial do sistema não foi encontrado. Tente novamente!");
    }
}
