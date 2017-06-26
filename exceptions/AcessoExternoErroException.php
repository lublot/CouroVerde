<?php
namespace exceptions;

/**
 * Classe responsável por representar uma exceção lançada quando um erro ocorre durante o login por meio externo.
 * @author MItologhic Software
 *
 */
class AcessoExternoErroException extends Exception
{
    /**
     * @var String código do erro.
     */
    protected $codigo;

    /**
     * Construtor da classe.
     *
     * @param String codigo código do erro ocorrido
     */
    public function __construct(String $codigo=NULL) {
        if(isset($codigo)) {
            parent::__construct("Algo deu errado!<br>Consulte o servidor externo de login para mais informações.<br>Código do erro:".$codigo);
        } else {
            parent::__construct("Algo deu errado!<br>Consulte o servidor externo de login para mais informações.<br>Código do erro:".$codigo);
        }

    }
}