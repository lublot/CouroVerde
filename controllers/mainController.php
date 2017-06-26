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