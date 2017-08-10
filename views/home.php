<html lang="pt-br">
    <head>
        <title>Sertour</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1">
        
       <?php $this->carregarDependencias()?>
    </head>
    <body>
      <?php $this->carregarCabecalho()?>
      
      <div class="container-fluid">
      
      <div id="carousel-example-generic" class="carousel slide col-xs-12" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            <div class="item active">
            <img src=<?php $this->path('/assets/images/adm.png')?> alt="..." style="max-height:20%">
            <div class="carousel-caption">
                ...
            </div>
            </div>
            <div class="item">
            <img src="..." alt="...">
            <div class="carousel-caption">
                ...
            </div>
            </div>
            ...
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
        </div>
        </div>
      <?php $this->carregarRodape()?>
    </body>
</html>