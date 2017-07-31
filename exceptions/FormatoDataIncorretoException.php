<?php
namespace exceptions;

/**
 * Classe responsável por representar uma exceção lançada quando o formato da data inserida está incorreto.
 * @author MItologhic Software
 *
 */
class FormatoDataIncorretoException extends \Exception
{

    /**
     * Construtor da classe.
     *
     * @param String codigo código do erro ocorrido
     */
    public function __construct()
    {
        parent::__construct("Formato de data inválido");
    }
}