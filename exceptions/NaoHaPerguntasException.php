<?php
namespace exceptions;

/**
 * Classe responsável por representar uma exceção lançada quando não há perguntas associadas a uma pesquisa.
 * @author MItologhic Software
 *
 */
class NaoHaPerguntasException extends \Exception
{

    /**
     * Construtor da classe.
     *
     */
    public function __construct()
    {
        parent::__construct("Não é possível cadastrar uma pesquisa sem ao menos uma pergunta.");
    }
}