<?php
namespace exceptions;

/**
 * Classe responsável por representar uma exceção lançada quando o login por meio externo não é permitido pelo usuário.
 * @author MItologhic Software
 *
 */
class AcessoExternoErroException extends \Exception
{

    /**
     * Construtor da classe.
     *
     * @param String codigo código do erro ocorrido
     */
    public function __construct()
    {
        parent::__construct("Login não autorizado!");
    }
}