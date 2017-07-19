<?php
namespace controllers;

require_once dirname(__DIR__).'/vendor/autoload.php';
use \models\RegistroVisitasObra as registroVisitasObra;
use \DAO\usuarioAcessoDAO as usuarioAcessoDAO;
use \models\Obra as Obra;
use \models\Visita as Visita;
use \DAO\obraDAO as obraDAO;

class relatorioAcessoController extends mainController
{
    private $numInventarioJaRegistrados;

    public function gerarRelatorioAcesso()
    {
        $this->numInventarioJaRegistrados = array();

        $usuarioAcessoDAO = new usuarioAcessoDAO();

        require(dirname(__DIR__).'/plugins/FPDF/fpdf.php');

        $pdf = new \FPDF(); //obtém o objeto necessário pra criar o pdf

        //define as configurações iniciais do documento do relatório
        $pdf->AddPage();
        $pdf->Image(dirname(__DIR__).'/views/assets/images/logo.jpg', 60);
        $pdf->SetFont('Times', 'B', 30);
        $pdf->Cell(48);
        $pdf->Cell(0, 10, utf8_decode('Relatório de Acesso'));
        $pdf->Ln();
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Cell(80);
        $pdf->Cell(20, 10, utf8_decode(date("d/m/Y")));
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->SetFont('Times', 'B', 12);
        
        $registrosMaisVisitadas = $usuarioAcessoDAO->buscarObraMaisVisitada(); //busca registros das obras mais visitadas
        $linhasObrasMaisVisitadas = $this->construirLinhas($registrosMaisVisitadas); //obtém as linhas correspondentes as obras mais visitadas

        if (count($linhasObrasMaisVisitadas) > 0) {
            $pdf->Ln();
            $pdf->Cell(20, 10, "I. OBRA(S) MAIS ACESSADA(S)");
            $pdf->SetFont('Times', 'B', 13);
            $pdf->Ln();
            $header = array(utf8_decode("Nº de Inventário"), utf8_decode("Nome"), utf8_decode("Nº de Visitas"));
            
            foreach ($header as $col) {
                $pdf->Cell(65, 7, $col, 1);
            }

            $pdf->Ln();

            foreach ($linhasObrasMaisVisitadas as $row) {
                foreach ($row as $col) {
                    $pdf->Cell(65, 6, $col, 1);
                }
                $pdf->Ln();
            }
        }

        $registrosMenosVisitadas = $usuarioAcessoDAO->buscarObraMenosVisitada(); //busca registros das obras menos visitadas
        $linhasObrasMenosVisitadas = $this->construirLinhas($registrosMenosVisitadas); //obtém as linhas correspondentes as obras menos visitadas

        if(count($linhasObrasMenosVisitadas) > 0) {
            $pdf->Ln();                               
            $pdf->Cell(20,10,"II. OBRA(S) MENOS ACESSADA(S)");
            $pdf->SetFont('Times','B',13);                
            $pdf->Ln();                                                         
            $header = array(utf8_decode("Nº de Inventário"), utf8_decode("Nome"), utf8_decode("Nº de Visitas")); 
            
            foreach($header as $col) {
                $pdf->Cell(65,7,$col,1);
            }        

            $pdf->Ln();       

            foreach($linhasObrasMenosVisitadas as $row) {
                foreach($row as $col) {
                    $pdf->Cell(65,6,$col,1);
                }
                $pdf->Ln();
            }  
        }  

        $registros = $this->montarRegistros(); //busca todos os registros
        $linhasOutrasObras = $this->construirLinhas($registros); //obtém a todos os outros registros

        if(count($linhasOutrasObras) > 0) {
            $pdf->Ln();                                                         
            $pdf->Cell(20,10,"III. OUTRA(S) OBRA(S)");
            $pdf->SetFont('Times','B',13);      
            $pdf->Ln();                                                                   
            $header = array(utf8_decode("Nº de Inventário"), utf8_decode("Nome"), utf8_decode("Nº de Visitas")); 
            
            foreach($header as $col) {
                $pdf->Cell(65,7,$col,1);
            }        

            $pdf->Ln();       

            foreach($linhasOutrasObras as $row) {
                foreach($row as $col) {
                    $pdf->Cell(65,6,$col,1);
                }
                $pdf->Ln();
            }  
        } 
 
        $pdf->Output();
    }

    private function montarRegistros()
    {
        $obraDAO = new obraDAO();
        $todasObras = $obraDAO->buscar(array("numeroInventario"), array()); //obtém o número de inventário de todas as obras

        $usuarioAcessoDAO = new usuarioAcessoDAO();

        foreach ($todasObras as $obra) {
            $numeroInventario = $obra->getNumInventario();
            $qtdVisitas = ($usuarioAcessoDAO->buscar(array(), array("numeroInventario" => $obra->getNumInventario())) != null) ? count($usuarioAcessoDAO->buscar(array(), array("numeroInventario" => $obra->getNumInventario()))) : 0;
            
            $registrosVisitasObras[] = new RegistroVisitasObra($numeroInventario, $qtdVisitas);
        }


        return $registrosVisitasObras;
    }

    private function construirLinhas($registros)
    {
        $obraDAO = new obraDAO();

        foreach ($registros as $registro) {
            $numeroInventario = $registro->getNumeroInventario();  //adiciona o número de inventário à lista dos números de inventário que já foram registrados no documento
            
            if (!in_array($numeroInventario, $this->numInventarioJaRegistrados)) { //se ainda não tiver sido adicionado ao documento
                $obra = $obraDAO->buscar(array("nome"), array("numeroInventario" => $numeroInventario));
                $nomeObra = $obra[0]->getNome();
                $quantidadeVisitas = $registro->getQuantidadeVisitas();
                $linhas[] = array($numeroInventario, $nomeObra, $quantidadeVisitas);
                $this->numInventarioJaRegistrados[] = $numeroInventario;
            }
        }

        if (!isset($linhas)) {
            $linhas = array();
        }

        return $linhas;
    }
}
