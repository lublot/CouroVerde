<?php
require_once dirname(__FILE__).'/../../vendor/autoload.php';

use \PHPUnit\Framework\TestCase;
use \DAO\backupDAO as backupDAO;
use \controllers\backupController as backupController;
use \exceptions\DadosCorrompidosException as DadosCorrompidosException;
use \exceptions\BackupNaoEncontradoException as BackupNaoEncontradoException;
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
        $this->instancia->configurarAmbienteParaTeste();
        $this->expectException(BackupNaoEncontradoException::class); //exceção esperada    
        $this->instancia->listarTodosBackups();
    }    

    /**
     * Testa a busca de backup com formato incorreto da data.      
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testBuscarBackupDataFormatoIncorreto() {
        $this->instancia->configurarAmbienteParaTeste("27062017", "18:00:00");
        $this->expectException(FormatoDataIncorretoException::class); //exceção esperada 
        $this->instancia->listarBackups();
    }

    /**
     * Testa a busca de backup com formato incorreto da hora.      
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testBuscarBackupHoraFormatoIncorreto() {
        $this->instancia->configurarAmbienteParaTeste("27/06/2017", "180000");
        $this->expectException(FormatoHoraIncorretoException::class); //exceção esperada 
        $this->instancia->listarBackups();
    }

    /**
     * Testa a busca de backup inexistente.      
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testBuscarBackupInexistente() {
        $this->instancia->configurarAmbienteParaTeste("27/06/2017", "18:00:00");
        $this->expectException(BackupNaoEncontradoException::class); //exceção esperada 
        $this->instancia->listarBackups();
    }

    /**
     * Testa a busca de backup com informações corrompidas.      
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testBuscaComDadosCorrompidos() {
        $this->instancia->configurarAmbienteParaTeste();
        $this->expectException(DadosCorrompidosException::class); //exceção esperada 
        $this->instancia->listarBackups();
    }


}