<html>
    <head>
        <title>Erro 404</title>
        <?php $this->carregarDependencias()?>
            
    </head>
    <body>

        <?php $this->carregarCabecalho();?>
        <div class="container" style="margin-bottom:-10vh">
            <h4 class="text-center">Ops... Você não pode passar!</h4>
            <img src=<?php $this->path("assets/images/giphy.gif")?> class="img-responsive center-block">
            <h5 class="text-center">Permissão Negada</h5>
        </div>
        
        <?php $this->carregarRodape()?>
    </body>
</html>