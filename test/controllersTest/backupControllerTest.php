<?php
require_once dirname(__FILE__).'/../../vendor/autoload.php';

use \PHPUnit\Framework\TestCase;
use \DAO\backupDAO as backupDAO;
use \controllers\backupController as backupController;
use \exceptions\DadosCorrompidosException as DadosCorrompidosException;
use \models\Backup as Backup;

class backupControllerTest extends TestCase {
    private $instancia;

    public function setUp(){
        $this->instancia = new backupController(); //obtém instancia do controller
    
        //remove todos os backups anteriormente realizados antes de realizar o teste
        $backupDAO = new backupDAO();
        $backupDAO->remover(array());
    }

    /**
     * Testa a realização de backup.      
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testRealizacaoBackup() {
        $this->instancia->realizarBackup();

        $backupDAO = new backupDAO();
        $backupsObtidos = $backupDAO->buscar(); //busca todos os backups no BD

        $this->assertEquals(1, count($backupsObtidos)); //verifica se apenas um backup foi encontrado
        
        $backup = $backupsObtidos[0];

        $this->assertEquals(date("Y-m-d"), $backup->getDia()); //verifica se o dia do backup corresponde ao esperado
    }

    /**
     * Testa a realização de backup.      
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testListarTodosBackups() {
        $this->instancia->realizarBackup();

        $backupDAO = new backupDAO();
        $backupsObtidos = $backupDAO->buscar(); //busca todos os backups no BD

        $this->assertEquals(1, count($backupsObtidos)); //verifica se apenas um backup foi encontrado
        
        $backup = $backupsObtidos[0];

        $this->instancia->listarTodosBackups();
    }    



}