<?php
namespace controllers;

require_once dirname(__DIR__).'/vendor/autoload.php';
use \models\Backup as Backup;
use exceptions\BackupNaoEncontradoException as BackupNaoEncontradoException;
use exceptions\FormatoHoraIncorretoException as FormatoHoraIncorretoException;
use exceptions\FormatoDataIncorretoException as FormatoDataIncorretoException;


class backupController extends mainController {

    /**
    * Realiza o backup completo do sistema.
    */
    public function realizarBackup() {
        $caminhoReal = realpath('\media');

        $zip = new ZipArchive(); //obtém um objeto zip
        
        date_default_timezone_set('America/Sao_Paulo'); 
        $diaBackup =  date("Y-m-d");
        $horaBackup = date("H-i-s"); //hora com formato aceito para nome de arquivo
        $nomeArquivoBackup = "backup_" . $diaBackup . $horaBackup . ".zip";

        $zip->open($nomeArquivoBackup, ZipArchive::CREATE | ZipArchive::OVERWRITE); //define as configurações iniciais

        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($caminhoReal), RecursiveIteratorIterator::LEAVES_ONLY);

        foreach ($files as $name => $file) {
            if (!$file->isDir() and substr_count($file->getRealPath(), 'PCD')) { //os diretórios vão ser adicionados automaticamente, logo eles podem ser pulados
                $filePath = $file->getRealPath(); //obtém o caminho real do arquivo que vai ser zipado
                $relativePath = substr($filePath, strlen($caminhoReal) + 1); //obtém o caminho relativo do arquivo que vai ser zipado
                $zip->addFile($filePath, $relativePath); //adiciona o arquivo ao zip
            }
        }
    
        $caminhoBackupBD = backupBanco();
        $zip->addFile(getcwd().'/'.$caminhoBackupBD, $caminhoBackupBD);
        $zip->close();
        unlink(getcwd().'/'.$caminhoBackupBD); //remove o arquivo inicial do backup do banco, após dele ser inserido no zip completo do backup
        
        $horaBackuBD = explode($horaBackup, '-');

        $backup = new Backup(null, $data, "$horaBackupBD[0]:$horaBackuBD[1]:$horaBackuBD[2]", "media/$nomeArquivoBackup");

        $backupDAO = new BackupDAO($backup);
        $backupDAO->inserir($backup);
    }

    /**
    * Realiza o backup do banco de dados.
    * @return String $caminhoArquivoBackup - caminho do local onde está armazenado o arquivo de backup.
    */
    function backupBanco() {
        try {
            // open the connection to the database - "localhost", "root", $password, "webMuseu" should already be set
            $mysqli = new mysqli("localhost", "root", "", "webMuseu");

            // did it work?
            if ($mysqli->connect_errno) {
                throw new Exception("Failed to connect to MySQL: " . $mysqli->connect_error);
            }

            // start buffering output
            // it is not clear to me whether this needs to be done since the headers have already been set.
            // However in the PHP 'header' documentation (http://php.net/manual/en/function.header.php) it says that "Headers will only be accessible and output when a SAPI that supports them is in use."
            // rather than the possibility of falling through a real time window there seems to be no problem buffering the output anyway
            ob_start();
           
            date_default_timezone_set('America/Sao_Paulo'); 
            $caminhoArquivoBackup = "BD-webMuseu-" . date("Y-m-d") . date("H-i-s") . ".sql";
            $f_output = fopen($caminhoArquivoBackup, 'w');
            // put a few comments into the SQL file
            fwrite($f_output, "-- pjl SQL Dump\n");
            fwrite($f_output, "-- Server version:".$mysqli->server_info."\n");
            fwrite($f_output, "-- Generated: ".date('Y-m-d h:i:s')."\n");
            fwrite($f_output, '-- Current PHP version: '.phpversion()."\n");
            fwrite($f_output, '-- localhost: '."localhost"."\n");
            fwrite($f_output, '-- Database:'."webMuseu"."\n");

            //get a list of all the tables
            $aTables = array();
            $strSQL = 'SHOW TABLES';            // I put the SQL into a variable for debuggin purposes - better that "check syntax near '), "
            if (!$res_tables = $mysqli->query($strSQL)) {
                throw new Exception("MySQL Error: " . $mysqli->error . 'SQL: '.$strSQL);
            }

            while ($row = $res_tables->fetch_array()) {
                $aTables[] = $row[0];
            }

            // Don't really need to do this (unless there is loads of data) since PHP will tidy up for us but I think it is better not to be sloppy
            // I don't do this at the end in case there is an Exception
            $res_tables->free();
            fwrite($f_output, "SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;"."\n");
            fwrite($f_output, "SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;"."\n");
            fwrite($f_output, "SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';"."\n\n");
        
            fwrite($f_output, "-- -----------------------------------------------------\n-- Schema webMuseu\n-- -----------------------------------------------------\n");

            fwrite($f_output, "CREATE SCHEMA IF NOT EXISTS `webMuseu` DEFAULT CHARACTER SET utf8 ;"."\n");
            fwrite($f_output, "USE `webMuseu` ;"."\n\n");

        
            //now go through all the tables in the database
            foreach ($aTables as $table) {
                fwrite($f_output, "-- -----------------------------------------------------\n-- Table `webMuseu`.`" . $table . "`\n-- -----------------------------------------------------\n\n");


                // remove the table if it exists
                fwrite($f_output, 'DROP TABLE IF EXISTS '.$table.';');

                // ask MySQL how to create the table
                $strSQL = 'SHOW CREATE TABLE '.$table;
                if (!$res_create = $mysqli->query($strSQL)) {
                    throw new Exception("MySQL Error: " . $mysqli->error . 'SQL: '.$strSQL);
                }
                $row_create = $res_create->fetch_assoc();

                fwrite($f_output, "\n".$row_create['Create Table'].";\n");


                fwrite($f_output, "-- --------------------------------------------------------\n");
                fwrite($f_output, '-- Dump Data for `'. $table."`\n");
                fwrite($f_output, "--\n\n");
                $res_create->free();

                // get the data from the table
                $strSQL = 'SELECT * FROM '.$table;
                if (!$res_select = $mysqli->query($strSQL)) {
                    throw new Exception("MySQL Error: " . $mysqli->error . 'SQL: '.$strSQL);
                }

                // get information about the fields
                $fields_info = $res_select->fetch_fields();

                // now we can go through every field/value pair.
                // for each field/value we build a string strFields/strValues
                while ($values = $res_select->fetch_assoc()) {
                    $strFields = '';
                    $strValues = '';
                    foreach ($fields_info as $field) {
                        if ($strFields != '') {
                            $strFields .= ',';
                        }
                        $strFields .= "`".$field->name."`";

                        // put quotes round everything - MYSQL will do type convertion (I hope) - also strip out any nasty characters
                        if ($strValues != '') {
                            $strValues .= ',';
                        }
                        $strValues .= '"'.preg_replace('/[^(\x20-\x7F)\x0A]*/', '', $values[$field->name].'"');
                    }

                    // now we can put the values/fields into the insert command.
                    fwrite($f_output, "INSERT INTO ".$table." (".$strFields.") VALUES (".$strValues.");\n");
                }
                fwrite($f_output, "\n\n\n");

                $res_select->free();
            }
        } catch (Exception $e) {
            fwrite($f_output, $e->getMessage());
        }


            fwrite($f_output, ob_get_clean());
            fclose($f_output);
            $mysqli->close();
            return $caminhoArquivoBackup;
    }

    /**
    * Efetua a listagem de todos os backups
    */
    public function listarTodosBackups() {
        $backupDAO = new backupDAO();
        $backup = $backupDAO->buscar();
       
        if(count($backup) < 1) {
            throw new BackupInexistenteException();
        } 

        echo json_encode($backup);
    }

    /**
    * Efetua a listagem backups de acordo com parâmetros informados
    */
    public function listarBackups() {

        if(isset($_POST['data']) && isset($_POST['hora'])) {
            $data = $_POST['data'];
            $hora = $_POST['hora'];

            if(((count(explode($data, '/')) != 3))) { //verifica se a data está em formato correto
                if(((count(explode($hora, ':')) != 3))) { //verifica se a hora está em formato correto
                    
                    if((!is_numeric($data))) { //verifica se a data está em formato correto
                        throw new FormatoDataIncorretoException();
                    } else {
                        $arrayBusca = array(
                            "data" => $data,
                        );
                    }

                    if(!is_numeric($hora)) { //verifica se a hora está em formato correto
                        throw new FormatoHoraIncorretoException();
                    } else {
                        if(!isset($arrayBusca)) {
                            $arrayBusca = array();
                        }

                        $arrayBusca[] = array(
                            "hora" => $hora,
                        );
                    }
                } else {
                    throw new FormatoHoraIncorretoException();
                }
            } else {
                throw new FormatoDataIncorretoException();
            }

            $arrayBusca = array(
                "data" => $data,
                "hora" => $hora,
            );

        } else if(isset($_POST['data'])) {
            $data = $_POST['data'];

            if(((count(explode($data, '/'))) != 3) || !is_numeric($data)) { //verifica se a data está em formato correto
                throw new FormatoDataIncorretoException();
            }

            $arrayBusca = array(
                "data" => $data,
            );

        } else if(isset($_POST['hora'])) {
            $hora = $_POST['hora'];

            if(((count(explode($hora, ':'))) != 3) || !is_numeric($hora)) { //verifica se a hora e a data estão em formato correto
                throw new FormatoHoraIncorretoException();
            }

            $arrayBusca = array(
                "hora" => $hora,
            );
        } else {
            throw new DadosCorrompidosException();
        }

        $backupDAO = new backupDAO();
        $backup = $backupDAO->buscarMaisRecente($arrayBusca);

        if(count($backup) < 1) {
            throw new BackupInexistenteException();
        } 

        echo json_encode($backup);
    }    

}
