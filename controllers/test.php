<?php


require_once dirname(__FILE__).'/../vendor/autoload.php';

use \PHPUnit\Framework\TestCase;
use \DAO\backupDAO as backupDAO;
use \controllers\backupController as backupController;
use \exceptions\DadosCorrompidosException as DadosCorrompidosException;
use \exceptions\BackupNaoEncontradoException as BackupNaoEncontradoException;
use \exceptions\FormatoDataIncorretoException as FormatoDataIncorretoException;
use \exceptions\FormatoHoraIncorretoException as FormatoHoraIncorretoException;
use \models\Backup as Backup;


$c = new backupController();
$c->realizarBackup();




























$c->realizarBackup();





























$c->realizarBackup();
