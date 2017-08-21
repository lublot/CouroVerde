<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <title>Sertour</title>
        <meta charset="utf-8">
        <meta name=viewport  content="width=device-width, initial-scale=1" />
        <?php $this->carregarDependenciasGaleria();?>
        <?php $this->carregarDependencias();?>
    </head>
    <body style="background-color: rgb(241, 242, 246);overflow-x:hidden">
        <style type="text/css">
            div.titulo {
                background-color: #bcd1ec;
                border-color: #e5e5e5 #333333 #eee;
                border-style: solid;
                border-width: 1px 0;
                box-shadow: inset 0 1px 12px 3px rgba(0, 0, 0, .05);
                border-radius: 4px;
            }            
        </style>
        <?php $this->carregarCabecalho();?>
        <div class="col-lg-3 col-sm-3 col-xs-3">
            <div class="titulo" style="width: 80%">
                <h5 class="text-center">CLASSIFICAÇÕES</h5>
            </div>
                <div class="panel panel-default" style="width: 80%;background-color: white;float: left; height: 420px;overflow-y: scroll; overflow-x: hidden;min-height: 100%;">
                    <?php
                        require_once dirname(__DIR__).'/vendor/autoload.php';
                        use \controllers\obraController as ObraController;
                        use \models\Classificacao as Classificacao;
                        use \DAO\ObraDAO as ObraDAO;
                        
                        $obraController = new ObraController();
                        $classificacoes = $obraController->obterClassificacoes();
                        echo '';                    
                        foreach($classificacoes as $classificacao) {
                                echo "<h4 class='panel-title'>
                                    <a href='?id=".$classificacao->getId()."' style='font-size: 14px;display:block;width:auto;word-wrap:break-word;'>".$classificacao->getNome()."</a>
                                </h4>
                                <hr>";
                        }
                    ?>                    
                </div>
            </div>
        </div>


        <div class="col-lg-9 col-sm-9 col-xs-9">
        <?php
            if(isset($_GET['id'])) {
                $obraController = new ObraController();
                $classificacaoEscolhida = $obraController->obterClassificacao($_GET['id']);
                
                echo '<!--Container que circunda a galeria-->
                        <div class="container" id="pagina" style="width:100%">
                            <div class="row text-right titulo"style="margin-bottom:20px;margin-top:-21px">
                                <!--Caso ele tenha escolhido alguma-->
                                <h4>'.$classificacaoEscolhida->getNome().'</h4> 
                            </div>
                        </div>';
            }
            
            $obraDAO = new ObraDAO();
            
            $obras = isset($_GET['id']) ? $obraController->obterObrasClassificacao($_GET['id']) : $obraDAO->buscar(array(), array());
            
            $numPag = 1;
            $numImgsLinha = 0;
            $numImgs = 0;
            
            foreach($obras as $obra) {
                $numImgs++;
                if($numImgsLinha == 0) {
                    // 1 row para cada colona de imagens
                    echo '<div class="row"> <!-abre linha-->';
                }

                $numImgsLinha = $numImgsLinha + 1;
                echo '<!--um <col-xs-6 col-md-3> para cada imagem de obra a ser exibida-->
                        <div id="img'.$numImgs.'_'.$numPag.'" class="col-xs-6 col-md-3" hidden>
                            <!--#href contendo o caminho para exibição da obra-->
                            <a href="'.ROOT_URL.'obra?num='.$obra->getNumInventario().'.php">
                                <div class="thumbnail">
                                    <!--Caminho da imagem exibida representando uma obra-->
                                    <img src="'.explode("../", $obra->getCaminhoImagem1())[1].'" style="height:130px"></img>
                                    <div class="caption">
                                        <h5>
                                            <!--Nome da obra-->
                                            '.$obra->getNome().'
                                        </h5>
                                    </div>
                                </div>
                            </a>
                        </div>';
                if($numImgsLinha == 4) {
                    echo '</div><!-fecha linha-->';                            
                    $numImgsLinha = 0;
                }
                if($numImgs == 8) {
                    $numImgs = 0;
                    $numPag++;
                }
            }
        ?>
        </div>



        </div>
        <div class="row text-center col-lg-12 col-sm-12 col-xs-12" style="margin-left: 12%;margin-bottom:2%;margin-top:0">
                <button type="button" class="btn btn-primary btn-mais">Carregar Mais</button>
                <button type="button" onclick="topFunction()" id="myBtn" class="btn btn-primary btn-voltar" style="display: none;">Voltar ao Início</a>                
        </div>    
    </body>
    <script src="views/assets/js/galeria-script.js"></script>            
</html>