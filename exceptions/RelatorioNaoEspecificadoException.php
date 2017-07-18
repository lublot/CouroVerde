<?php
namespace exceptions;

/**
 * Classe responsável por representar uma exceção lançada quando um relatório de sistema é procurado sem nehum filtro de busca
 * @author MItologhic Software
 *
 */

 class RelatorioNaoEspecificadoException extends \Exception {
    /**
	* Construtor da classe.
	*/
    public function __construct()
    {
        parent::__construct("Não foi possível encontrar o relatório de sistema!");
    }
 }

?>

