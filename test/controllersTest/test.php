<?php
require_once dirname(__FILE__).'/../../vendor/autoload.php';

use \controllers\relatorioAcessoController as relatorioAcessoController;

$c = new relatorioAcessoController();
$c->gerarRelatorioAcesso();