<html lang="pt-br">
    <head>
        <title>Sertour</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1">
        
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
                <img  src=<?php $this->path("/assets/images/5.jpeg")?> alt="..." style="min-width:100%;">
                   
                <div class="carousel-caption">
                texto
                </div>
            </div>
            <div class="item" style="min-width:100%;">
                <img  src=<?php $this->path('/assets/images/5.jpeg')?> alt="..." style="min-width:100%;" >
                <div class="carousel-caption">
                texto 2
                </div>
            </div>
            <div class="item" style="min-width:100%;">
                <img  src=<?php $this->path('/assets/images/5.jpeg')?> alt="..." style="min-width:100%;" >
                <div class="carousel-caption">
                texto 3
                </div>
            </div>
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