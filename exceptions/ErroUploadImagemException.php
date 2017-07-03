<?php
namespace exceptions;

/**
 * Classe responsável por representar uma exceção lançada quando ocorre um erro durante o upload da imagem.
 * @author MItologhic Software
 *
 */

class ErroUploadImagemException extends \Exception
{
    
    /**
	* Construtor da classe.
    * @param String $causa causa do erro
	*/
    public function __construct($causa)
    {
        parent::__construct($causa);
    }
}
