<html lang="pt-br">
    <head>
        <title>SERTOUR</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1">
        <link rel="icon" href="../sertour/views/assets/images/icone.ico" type="image/x-icon"/>    
        
       <?php $this->carregarDependencias()?>
    </head>
    <body>
      <?php $this->carregarCabecalho()?>
      
      <div class="container-fluid" style="min-width:100%;">
        <div id="carousel-example-generic" class="carousel slide col-xs-12" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <?php
                        $cont = 0;
                        for($i =0; $i < count($this->dados['noticias']); $i++) {
                            if($i == 0) {
                                echo '<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>';
                            } else {
                                echo '<li data-target="#carousel-example-generic" data-slide-to="'.$i.'"></li>';
                            }
                        }

                    ?>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox" style="min-width:100%;background:rgba(0,0,0,0)">
                    <div class="item active" style="min-width:100%;">
                    <a href=<?php if(isset($this->dados) && count($this->dados['noticias'])>0){echo '"' . ROOT_URL . 'noticias/exibir/'.$this->dados['noticias'][0]->getIdNoticia(). '"';}?>><img src=<?php if(isset($this->dados) && count($this->dados['noticias'])>0){echo ROOT_URL.$this->dados['noticias'][0]->getCaminhoImagem();}?> alt="..." style="min-width:100%;"></a>
                        
                        <div class="carousel-caption">
                            <h4><?php if(isset($this->dados) && count($this->dados['noticias'])>0){echo utf8_encode($this->dados['noticias'][0]->getTitulo());}?></h4>
                            <h5><?php if(isset($this->dados) && count($this->dados['noticias'])>0){echo utf8_encode($this->dados['noticias'][0]->getSubtitulo());}?></h5>
                        </div>
                    </div>

                    <?php
                        for($i=1;$i<count($this->dados['noticias']);$i++){
                            echo '<div class="item" style="min-width:100%;">
                                    <a href="'.ROOT_URL.'noticias/exibir/'.$this->dados['noticias'][$i]->getIdNoticia().'"><img src="'.ROOT_URL.$this->dados['noticias'][$i]->getCaminhoImagem().'" alt="..." style="min-width:100%;"></a>
                                    
                                    <div class="carousel-caption">
                                    <h4>'.utf8_encode($this->dados['noticias'][$i]->getTitulo()).'</h4>
                                    <h5>'.utf8_encode($this->dados['noticias'][$i]->getSubtitulo()).'</h5>
                                    </div>
                                </div>';
                        }
                    
                    ?>
                </div>

                <!-- Controls -->
                <a class="left carousel-control" href="#carousel-example-generic" role="button" style="background:rgba(0,0,0,0)" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic" role="button" style="background:rgba(0,0,0,0)"data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </body>
    <?php $this->carregarRodape()?>

</html>