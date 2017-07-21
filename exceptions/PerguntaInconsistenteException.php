<?php
namespace exceptions;

/**
 * Classe responsável por representar uma pergunta com problema na sua estrutura.
 * @author MItologhic Software
 *
 */

class PerguntaInconsistenteException extends \Exception
{
    
    /**
	* Construtor da classe.
	*/
    public function __construct()
    {
        parent::__construct("Por favor, revise os campos das perguntas");
    }
}