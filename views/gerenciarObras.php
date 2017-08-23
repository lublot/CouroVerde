<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <!--Codificação dos caracteres: UTF-8-->
    <meta charset="utf-8" />
    <!--Descrição da página: Sertour-->
    <meta name="description" content="Setour" />
    <!--Regulando a visão da tela para a largura relativa à tela utilizada-->
    <meta name=viewport content="width=device-width, initial-scale=1" />

    <title>Gerenciamento de Obra</title>


    <!--Importação do Javascript pessoal e jQuery  -->
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/js/cadObras-script.js"></script>
    <?php $this->carregarDependencias();?>
</head>

<body style="background-color: rgb(241, 242, 246);">
    <?php $this->carregarCabecalho();?>    

    <div class="container">

        <!-- Painel -->
        <div class="col-md-3 col-lg-3">
            <?php $this->carregarPainel();?>             
        </div>

        <div class="col-md-9 col-lg-9">

            <!--Título da caixa-->
            <div id="titulo">
                <h4 class="text-center">Gerenciamento de Obras</h4>
            </div>
            <!--Fim do título da caixa-->

            <!-- Contorno -->
            <div id="contorno">

                <!-- Caixa interna -->
                <section id="caixa">

                    <?php
                        require_once 'vendor/autoload.php';                                                        
                        use \controller\obraController as ObraController;
                        use \models\Obra as Obra;
                        use \DAO\ObraDAO as ObraDAO;

                            $obraDAO = new ObraDAO();
                            $obras = $obraDAO->buscar(array(), array());
    
                            $numLinhas = 1;
                            $numObras = 0;
                            $numObrasLinha = 0;
    
                            if(isset($_GET['u'])) {
                                $obraAnterior = $obraDAO->buscar(array(), array('numeroInventario' => $_GET['u']))[0];
                            }
    
                            $cont = 0;
    
                            foreach($obras as $obra) {
                                if(!isset($achou) && isset($obraAnterior)) {
                                    if($obra->getNumInventario() == $obraAnterior->getNumInventario()) {
                                        $achou = true;
                                    }
                                } else {
                                    $achou = true;
                                }
    
    
                                if(isset($achou) && $achou == true) {
                                    $proximoNumInv = $obra->getNumInventario();
                                    
                                    if($numObrasLinha == 4) {
                                        echo '</div>';
                                        $numObrasLinha = 0;
                                        $numLinhas++;
                                    }
        
                                    if($numLinhas == 4) {
                                        break;
                                    }
                                                                
                                    if($numObrasLinha == 0) {
                                        echo '<!-- Inicio da galeria -->';
                                        echo '<div class="row" align="center">';
                                    }

                                    echo '<!--um <col-xs-6 col-md-3> para cada imagem de obra a ser exibida-->
                                    <div class="col-xs-6 col-md-3">
                                        <!--#href contendo o caminho para exibição da obra-->
                                        <a href="'.ROOT_URL.'obra/gerenciaobra?i='.$obra->getNumInventario().'" class="text-center">
                                            <div class="thumbnail">
                                                <!--Caminho da imagem exibida representando uma obra-->
                                                <img src="'.$obra->getCaminhoImagem1().'" style="height:130px"></img>
                                                <div class="caption">
                                                    <h5><dt style="color: black"><span style="display:block;width:150px;word-wrap:break-word;">'.$obra->getNome().'</span></dt></h5>
                                                </div>
                                            </div>
                                        </a>
                                    </div>';       
        
                                    $numObras++;
                                    $numObrasLinha++;                                
                                }
    
                                $cont++;
    
                            }
                            
                            if($cont != count($obras)) {
                                echo '<div class="row text-center">
                                <a href="'.ROOT_URL.'obra/gerenciar?u='.$proximoNumInv.'" type="button" class="btn btn-primary btn-mais">Mais Obras</a>
                                </div>';
                            } 
                        
                        

                    ?>
                    <!-- /FIM da Caixa interna -->
                </section>

                <!-- FIM do Contorno -->
            </div>

        </div>

    </div>

    <?php $this->carregarRodape();?>    
</body>

</html>