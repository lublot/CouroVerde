<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8" />

        <meta name="description" content="Sertour" />
        <meta name=viewport  content="width=device-width, initial-scale=1" />

        <title>Sertour</title>
        <link rel="stylesheet" href="assets/css/materialize.css">
        <link rel="stylesheet" href="assets/css/bootstrap.css">
        <link rel="stylesheet" href="assets/css/bootstrap-theme.css">
        <link rel="stylesheet" href="assets/css/estilo.css">
        <link rel="stylesheet" href="assets/css/bootstrap-social.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    </head>
    <body>

        <style type="text/css">
            .container{
                /*tira a galeira de baixo do painel lateral*/
                padding-left: 19%;    
            }
        </style>
            <!--Painel lateral com as categorias-->
            <ul id="slide-out" class="side-nav fixed" style="max-width:20%;">
                <!--SUGESTÃO PARA INTEGRAÇÃO-->
                <!--caso ele esteja em uma categoria, volta pra galeria geral-->
                <li><a href="#!">CLASSIFICAÇÕES</a></li>
                <li><div class="divider"></div></li>
                 <!--Um <li> para cada nova categoria-->
                <?php
                    require_once dirname(__DIR__).'/vendor/autoload.php';
                    use \controllers\obraController as ObraController;
                    use \models\Classificacao as Classificacao;

                    $obraController = new ObraController();

                    $classificacoes = $obraController->obterClassificacoes();

                    foreach($classificacoes as $classificacao) {
                        echo "<li><a class='waves-effect' href='?id=".$classificacao->getId()."'>".$classificacao->getNome()."</a></li>";
                    }


                ?>
            </ul>
            <!--Inicialização ainel lateral-->
        <script type="text/javascript">
            $(document).ready(function(){
                $(".button-collapse").sideNav();
                $('.collapsible').collapsible();
            });
        </script>
        <br>
        <!--Container que circunda a galeria-->
        <div class="container" id="pagina">
            <div class="row text-right">
                <!--Caso ele tenha escolhido alguma-->
                <h4>Categoria Atual</h4> 
            </div>
            <?php
                if(isset($_GET['id'])) {
                    $obras = $obraController->obterObrasClassificacao($_GET['id']);

                    $cont = 0;

                    foreach($obras as $obra) {
                        if($cont == 0) {
                            // 1 row para cada colona de imagens
                            echo '<div class="row"> <!-abre linha-->';
                        }

                        $cont = $cont + 1;                        

                        echo '<!--um <col-xs-6 col-md-3> para cada imagem de obra a ser exibida-->
                                <div class="col-xs-6 col-md-3">
                                    <!--#href contendo o caminho para exibição da obra-->
                                    <a href="imagens/noticias/img1.jpg">
                                        <div class="thumbnail">
                                            <!--Caminho da imagem exibida representando uma obra-->
                                            '.'aaaaaaaaaaaaaaaaaa'.$obra->getCaminhoImagem1().'
                                            <img src="'.$obra->getCaminhoImagem1().'" style="height:150px">
                                            <div class="caption">
                                                <h5>
                                                    <!--Nome da obra-->
                                                    '.$obra->getNome().'
                                                </h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>';

                        if($cont == 4) {
                            echo '</div><!-fecha linha-->';                            
                            $cont = 0;
                        }  
                                              
                    }
                }                
            ?>
            <div class="row text-center">
                <button type="button" class="btn btn-sm btn-danger">Carregar mais</button>
            </div>
        </div>
    </body>
    <!--  -->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.js"></script>
    <script type="text/javascript" src="assets/js/materialize.js"></script>
    <script type="text/javascript" src="assets/js/galeria-script.js"></script>    
</html>