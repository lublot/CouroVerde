<html>
    <head>
        <title>Erro 404</title>
        <?php $this->carregarDependencias()?>
        
    </head>
    <body>

        <?php $this->carregarCabecalho()?>
        <div class="container">
            <a href="../index.php"> <h4 class="text-center"> Voltar à pagina inicial </h4></a>
            <img src=<?php $this->path("assets/images/erro404.jpg")?> class="img-responsive center-block">
        </div>
        <?php $this->carregarRodape()?>
    </body>
</html>