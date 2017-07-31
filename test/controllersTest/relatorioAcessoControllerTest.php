<?php

require_once dirname(__FILE__).'/../../vendor/autoload.php';
use \PHPUnit\Framework\TestCase;
use \models\RegistroVisitasObra as registroVisitasObra;
use \DAO\usuarioAcessoDAO as usuarioAcessoDAO;
use \models\Obra as Obra;
use \models\Usuario as Usuario;
use \DAO\UsuarioDAO as UsuarioDAO;
use \DAO\obraDAO as obraDAO;
use \controllers\relatorioAcessoController as relatorioAcessoController;


class relatorioAcessoControllerTest extends TestCase {

    private $instancia;

    public function setup(){
        $this->instancia = new relatorioAcessoController();
    }

    /*public function testGerarRelatorio() {
        //$this->instancia->gerarRelatorioAcesso();
    }*/

    public function testAdicionarVisitaSucesso(){
        $usuario = new Usuario(null, "diegossl94@gmail.com", "Diego", "Lourenço", "12345678", "1", "ADMINISTRADOR");
        $usuarioDAO = new UsuarioDAO();
        $usuarioDAO->inserir($usuario);
        $usuarioRecuperado = $usuarioDAO->buscar(array("idUsuario"), array("email" => "diegossl94@gmail.com"));
        $idUsuario = $usuarioRecuperado[0]->getId();

        $obra = new Obra(null, 'Obra 1','Couro 1', 'Função', 'Origem', 'Procedência', 'Descrição', 1, 1, '5', '5', '5', '10', '1', 'Materiais', 'Técnicas', 'Autoria', 'Marcas', 'Histórico', 'Modo de Aquisição', '2017/07/29', 'Autor', 'Observações', 'Estado');        
        $obraDAO = new ObraDAO();
        $obraDAO->inserirObra($obra);
        $obraRecuperada = $obraDAO->buscar(array("numeroInventario"), array("nome" => "Obra 1"));
        $numInventario = $obraRecuperada[0]->getNumInventario();

        $this->instancia->configuraAmbienteParaTeste($idUsuario, $numInventario);
        $this->instancia->adicionarVisita();
    }
}

?>