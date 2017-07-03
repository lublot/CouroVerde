<?php
namespace exceptions;

/**
 * Classe responsável por representar uma exceção lançada quando um usuário não tem acesso à uma parte do sistema
 * @author MItologhic Software
 *
 */
class NivelDeAcessoInsuficienteException extends \Exception
{

    /**
     * Construtor da classe.
     *
     */
    public function __construct() {
        parent::__construct("Você não tem permissão para acessar essa funcionalidade");
    }
}