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
            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox" style="min-width:100%;background:rgba(0,0,0,0)">
            <div class="item active" style="min-width:100%;">
                <img  src="<?php if(isset($this->dados) && count($this->dados)>0){echo ROOT_URL.$this->dados['noticias'][0]->getCaminhoImagem();}?>" alt="..." style="min-width:100%;">
                   
                <div class="carousel-caption" style="color:black">
                    <h4><?php if(isset($this->dados) && count($this->dados)>0){echo $this->dados['noticias'][0]->getTitulo();}?></h4>
                    <h5><?php if(isset($this->dados) && count($this->dados)>0){echo $this->dados['noticias'][0]->getSubtitulo();}?></h5>
                </div>
            </div>

            <?php
                for($i=1;$i<count($this->dados);$i++){
                    echo '<div class="item" style="min-width:100%;">
                            <img  src=".'.ROOT_URL.$this->dados[0]["caminhoImagem"].'" alt="..." style="min-width:100%;">
                            
                            <div class="carousel-caption">
                            <h4>.'.$this->dados[$i]["titulo"].'</h4>
                            <h5>'.$this->dados['.$i.']["subtitulo"].'</h5>
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
      <?php $this->carregarRodape()?>
    </body>
</html>