<?php
namespace exceptions;

/**
 * Classe responsável por representar uma exceção lançada quando o formato da hora inserida está incorreto.
 * @author MItologhic Software
 *
 */
class FormatoHoraIncorretoException extends \Exception
{

    /**
     * Construtor da classe.
     *
     * @param String codigo código do erro ocorrido
     */
    public function __construct()
    {
        parent::__construct("Formato de hora inválido");
    }
}