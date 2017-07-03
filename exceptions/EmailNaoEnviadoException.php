<?php
namespace exceptions;

/**
 * Classe responsável por representar uma exceção lançada quando um erro ocorre durante o envio de email de confirmação.
 * @author MItologhic Software
 *
 */
class EmailNaoEnviadoException extends \Exception
{
    /**
     * @var String código do erro.
     */
    protected $codigo;

    /**
     * Construtor da classe.
     *
     */
    public function __construct() {
        parent::__construct("Não foi possível enviar um email de confirmação. Tente novamente mais tarde ou contate-nos");
    }
}