<?php
namespace controllers;

class mainController{

    /**
    * Este método carrega o conteúdo principal da página desejada
    * @param unknown $nomeArquivo - Recebe o nome do arquivo ".php" a ser carregado
    * @param unknown $dados - Recebe os dados a serem apresentados na página
    */
    protected function carregarConteudo($nomeArquivo,$dados = array()){
        extract($dados);
        include ABSPATH.'/views/'.$nomeArquivo.'.php';
    }

    /**
    * Este método carrega o cabeçalho do sistema
    */
    protected function carregarCabecalho(){
        include ABSPATH.'/views/cabecalho.php';
    }

    /**
    * Este método carrega o rodapé do sistema
    */
    protected function carregarRodape(){
        include ABSPATH.'/views/rodape.php';
    }

    protected function carregarDependencias(){
        
        echo '<link rel="stylesheet" type ="text/css" href='.VIEW_BASE."assets/css/bootstrap.css".'>';
        echo '<link rel="stylesheet" type ="text/css" href='.VIEW_BASE."assets/css/bootstrap-theme.css".'>';
        // echo '<link rel="stylesheet" type ="text/css" href='.VIEW_BASE."assets/css/bootstrap.min.css".'>';
        echo '<link rel="stylesheet" type ="text/css" href='.VIEW_BASE."assets/css/bootstrap-social.css".'>';

        echo '<link rel="stylesheet" type ="text/css" href='.VIEW_BASE."assets/css/estilo.css".'>'; 
        echo '<link rel="stylesheet" type ="text/css" href='.VIEW_BASE."assets/css/site.css".'>';
        echo '<link rel="stylesheet" type ="text/css" href='.VIEW_BASE."assets/css/site.min.css".'>';
        echo '<link rel="stylesheet" type ="text/css" href='.VIEW_BASE."assets/css/topo.css".'>';

        echo  '<script type ="text/javascript" src='.VIEW_BASE."assets/js/jquery-3.2.1.min.js".'></script>';
        echo  '<script type="text/javascript" src='.VIEW_BASE."assets/js/bootstrap.js".'></script>';
        echo  '<script type ="text/javascript" src='.VIEW_BASE."assets/js/validator.js".'></script>';
    }
    /**
    * Este método indica a url atual, funciona como um refresh interno
    */
    protected function paginaAtual(){
        echo 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
    }

    /**
    * Este método indica o caminho das dependências da view do sistema
    * @param unknow $caminho - Indica o caminho relativo do arquivo
    */
    protected function path($caminho){
        echo VIEW_BASE.$caminho;
    }

    /**
    * Este método redireciona o usuário para uma url informada
    * @param unknown $url - URL para a qual o usuário será redirecionado 
    */
    protected function redirecionarPagina($url){
        echo "<script>location.href='".ROOT_URL.$url."'</script>";
    }
   
}

?>