<?php
namespace exceptions;

/**
* Classe responsável por representar uma exceção lançada quando um erro ocorre durante o envio de email de confirmação.
* @author MItologhic Software
*
*/
class MatriculaInvalidaException extends \Exception {

    public function __construct()
    {
        parent::__construct("O número de matricula não é válido.");
    }
}

?>