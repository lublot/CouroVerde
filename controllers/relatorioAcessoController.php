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

    /**
    * Redireciona para a página de visualização do relatório de acesso.
    */
    public function index() {
        $this->carregarConteudo('relatorioAcesso',array());
    }

    /**
    * Configura o ambiente para testes.
    * @param $idUsuario - id de um usuário
    * @param $numInventario - número de inventário 
    */
    public function configuraAmbienteParaTeste($idUsuario, $numInventario){
        $_POST['idUsuario'] = $idUsuario;
        $_POST['numeroInventario'] = $numeroInventario;
    }

    /**
    * Gera o relatório de acesso das obras do sistema.
    */
    public function gerarRelatorioAcesso() {
        $this->numInventarioJaRegistrados = array(); //reinicia os numeros de inventário já registrados 

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

        $todosRegistros = $this->montarTodosRegistros(); //monta todos os registros de todas obras     

        $registrosMaisVisitadas = $usuarioAcessoDAO->buscarObraMaisVisitada(); //busca registros das obras mais visitadas
        $linhasObrasMaisVisitadas = $this->construirLinhas($registrosMaisVisitadas); //obtém as linhas correspondentes as obras mais visitadas
        $linhasObrasMaisVisitadas = count($linhasObrasMaisVisitadas) > 0 ? $linhasObrasMaisVisitadas : array();

        if (count($linhasObrasMaisVisitadas) > 0) { //caso a existam linhas para as obras mais visitadas
            //configura o subtitulo
            $pdf->Ln();
            $pdf->Cell(20, 10, "I. OBRA(S) MAIS ACESSADA(S)");
            $pdf->SetFont('Times', 'B', 13);
            $pdf->Ln();
            $cabecalhoSessao = array(utf8_decode("Nº de Inventário"), utf8_decode("Nome"), utf8_decode("Nº de Visitas"));
            
            foreach ($cabecalhoSessao as $col) { //para cada coluna
                $pdf->Cell(65, 7, $col, 1);
            }

            $pdf->Ln();

            //adiciona as linhas das obras mais visitadas
            foreach ($linhasObrasMaisVisitadas as $row) {
                foreach ($row as $col) {
                    $pdf->Cell(65, 6, $col, 1);
                }
                $pdf->Ln();
            }
        }

        if($todosRegistros[0] != null) { //se houver registros de obras sem visita
            $linhasObrasMenosVisitadas = $this->construirLinhas($todosRegistros[0]); //as obras menos visitadas são as obras sem visita
        } else {
            $registrosMenosVisitadas = $usuarioAcessoDAO->buscarObraMenosVisitada(); //busca registros das obras menos visitadas            
            $linhasObrasMenosVisitadas = $this->construirLinhas($registrosMenosVisitadas);            
        }        
        
        if(count($linhasObrasMenosVisitadas) > 0) { //caso a existam linhas para as obras menos visitadas
            //configura o subtitulo        
            $pdf->Ln();                               
            $pdf->Cell(20,10,"II. OBRA(S) MENOS ACESSADA(S)");
            $pdf->SetFont('Times','B',13);                
            $pdf->Ln();                                                         
            $cabecalhoSessao = array(utf8_decode("Nº de Inventário"), utf8_decode("Nome"), utf8_decode("Nº de Visitas")); 
            
            foreach($cabecalhoSessao as $col) { //para cada coluna
                $pdf->Cell(65,7,$col,1);
            }        

            $pdf->Ln();       

            //adiciona as linhas das obras mais visitadas
            foreach($linhasObrasMenosVisitadas as $row) {
                foreach($row as $col) {
                    $pdf->Cell(65,6,$col,1);
                }
                $pdf->Ln();
            }  
        }  

        if($todosRegistros[1] != null) { //caso existam registros que não sejam de obras mais ou menos visitadas e não nulos
            $todosRegistrosNaoNulos = $todosRegistros[1]; 
            $linhasOutrasObras = $this->construirLinhas($todosRegistrosNaoNulos); //obtém as linhas dos registros não nulos           
        } else {
            $linhasOutrasObras = array();
        }        

        if(count($linhasOutrasObras) > 0) { //caso a existam linhas para o restante das obras
            //configura o subtitulo                    
            $pdf->Ln();                                                         
            $pdf->Cell(20,10,"III. OUTRA(S) OBRA(S)");
            $pdf->SetFont('Times','B',13);      
            $pdf->Ln();                                                                   
            $cabecalhoSessao = array(utf8_decode("Nº de Inventário"), utf8_decode("Nome"), utf8_decode("Nº de Visitas")); 
            
            foreach($cabecalhoSessao as $col) { //para cada coluna
                $pdf->Cell(65,7,$col,1);
            }        

            $pdf->Ln();       

            //adiciona as linhas das obras mais visitadas
            foreach($linhasOutrasObras as $row) {
                foreach($row as $col) {
                    $pdf->Cell(65,6,$col,1);
                }
                $pdf->Ln();
            }  
        } 

        $nomeArquivo = "C:\wamp64\www\sertour\media/relatorioacesso/relatorioAcesso.pdf";
 
        $pdf->Output($nomeArquivo, 'F');
    }

    /**
    * Monta os registros referentes a todas obras do sistema.
    * @return array contendo os registros de obras visitadas e não visitadas
    */
    private function montarTodosRegistros() {
        $obraDAO = new obraDAO();
        $todasObras = $obraDAO->buscar(array("numeroInventario"), array()); //obtém o número de inventário de todas as obras

        $usuarioAcessoDAO = new usuarioAcessoDAO();

        foreach ($todasObras as $obra) { //para cada obra
            $numeroInventario = $obra->getNumInventario();
            $qtdVisitas = ($usuarioAcessoDAO->buscar(array(), array("numeroInventario" => $obra->getNumInventario())) != null) ? count($usuarioAcessoDAO->buscar(array(), array("numeroInventario" => $obra->getNumInventario()))) : 0;
            
            if($qtdVisitas == 0) { //se a obra não possuir visitas
                $registrosVisitasZerado[] = new RegistroVisitasObra($numeroInventario, $qtdVisitas);
            } else {
                $registrosVisitasObras[] = new RegistroVisitasObra($numeroInventario, $qtdVisitas);
            }

        }

        return array(isset($registrosVisitasZerado) ? $registrosVisitasZerado : null, isset($registrosVisitasObras) ? $registrosVisitasObras : null);
    }

    /**
    * Constroi as linhas das tabelas que serão exibidas no relatório.
    * @param $registros - registros que deseja-se transformar em linhas
    * @return array contendo as linhas da tabela
    */
    private function construirLinhas($registros) {
        $obraDAO = new obraDAO();

        foreach ($registros as $registro) {
            $numeroInventario = $registro->getNumeroInventario();  //adiciona o número de inventário à lista dos números de inventário que já foram registrados no documento
            
            if (!in_array($numeroInventario, $this->numInventarioJaRegistrados)) { //se ainda não tiver sido adicionado ao documento
                $obra = $obraDAO->buscar(array("nome"), array("numeroInventario" => $numeroInventario));
                $nomeObra = $obra[0]->getNome();
                $quantidadeVisitas = $registro->getQuantidadeVisitas();
                $linhas[] = array($numeroInventario, $nomeObra, $quantidadeVisitas);
                $this->numInventarioJaRegistrados[] = $numeroInventario; //armazena o numero de inventario da obra na lista dos numeros de inventario que ja foram armazenados
            }
        }

        if (!isset($linhas)) {
            $linhas = array();
        }

        return $linhas;
    }

    /**
    * Armazena uma visita.
    */
    public function adicionarVisita() {
        if(isset($_POST['idUsuario']) && isset($_POST['numeroInventario'])) {
            $usuarioAcessoDAO = new usuarioAcessoDAO();

            if(count($usuarioAcessoDAO->buscar(array(), array('numeroInventario' => $_POST['numeroInventario'], 'idUsuario' => $_POST['idUsuario']))) == 0) { //caso a vista do usuario a essa obra não tenha sido armazenada ainda
                $usuarioAcessoDAO->inserir(new Visita($_POST['idUsuario'], $_POST['numeroInventario']));
            }

        }
    }
}
