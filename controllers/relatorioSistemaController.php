<?php


class relatorioSistemaController extends mainController{

    public function configuraAmbienteParaTeste() {

    }

    /**
    * Este método oferece todos os relatorios do sistema;
    */
    public function listarTodosRelatorios(){
        $relatorioDAO = new RelatorioDAO();
        $relatorioDAO = $relatorioDAO->buscar(array(),array());
        
        echo json_encode($relatorioDAO);
    }

    /**
    * Este método oferece um ou vários relatórios com base em um critério de busca
    */
    public function listarRelatoriosEspecificos(){
        try{
            if(isset($_POST['filtro']) && isset($_POST['valor'])){
                $relatorioDAO = new RelatorioDAO();
                $relatorioDAO = $relatorioDAO->buscar(array(),array($_POST['filtro'] => $_POST['valor']));

                echo json_encode($relatorioDAO);
            }
        }catch(Exception $e){}
    }
}
?>