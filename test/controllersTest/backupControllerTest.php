<?php
require_once dirname(__FILE__).'/../../vendor/autoload.php';

use \PHPUnit\Framework\TestCase;
use \DAO\backupDAO as backupDAO;
use \controllers\backupController as backupController;
use \exceptions\DadosCorrompidosException as DadosCorrompidosException;
use \exceptions\BackupInexistenteException as BackupInexistenteException;
use \exceptions\FormatoDataIncorretoException as FormatoDataIncorretoException;
use \exceptions\FormatoHoraIncorretoException as FormatoHoraIncorretoException;
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

    /**
     * Testa a listagem vazia de backups.      
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testListaBackupsVazio() {
         $this->expectException(BackupInexistenteException::class); //exceção esperada    
         $this->listarTodosBackups();
    }    

    /**
     * Testa a busca de backup com formato incorreto da data.      
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testBuscarBackupDataFormatoIncorreto() {
        $_POST['data'] = "27062017";
        $_POST['hora'] = "18:00:00";

        $this->expectException(FormatoDataIncorretoException::class); //exceção esperada 
        $this->listarBackups();
    }

    /**
     * Testa a busca de backup com formato incorreto da hora.      
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testBuscarBackupHoraFormatoIncorreto() {
        $_POST['data'] = "27/06/2017";
        $_POST['hora'] = "180000";

        $this->expectException(FormatoHoraIncorretoException::class); //exceção esperada 
        $this->listarBackups();
    }

    /**
     * Testa a busca de backup inexistente.      
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testBuscarBackupInexistente() {
        $_POST['data'] = "27/06/2017";
        $_POST['hora'] = "18:00:00";

        $this->expectException(BackupInexistenteException::class); //exceção esperada 
        $this->listarBackups();
    }

    /**
     * Testa a busca de backup com informações corrompidas.      
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testBuscaComDadosCorrompidos() {
        $_POST['data'] = null;
        $_POST['hora'] = null;
        
        $this->expectException(DadosCorrompidosException::class); //exceção esperada 
        $this->listarBackups();
    }

}