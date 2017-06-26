<?php
namespace exceptions;

/**
 * Classe responsável por representar uma exceção lançada quando um erro ocorre durante um cadastro.
 * @author MItologhic Software
 *
 */
class ErroCadastroException extends \Exception
{

    /**
     * Construtor da classe.
     *
     */
    public function __construct() {
        parent::__construct("Infelizmente o seu cadastro não foi bem sucedido. Tente novamente!");
    }
}