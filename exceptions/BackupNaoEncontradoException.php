<?php
namespace exceptions;

/**
 * Classe responsável por representar uma exceção lançada quando não há backups cadastrados no sistema e uma busca é realizada.
 * @author MItologhic Software
 *
 */
class BackupNaoEncontradoException extends \Exception
{

    /**
     * Construtor da classe.
     *
     * @param String codigo código do erro ocorrido
     */
    public function __construct()
    {
        parent::__construct("Não foram encontrados backups no sistema");
    }
}