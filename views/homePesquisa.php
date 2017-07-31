<html>
    <head>
        <title>Sertour</title>
        <meta charset="utf-8">
        <meta name=viewport  content="width=device-width, initial-scale=1" />

        <?php $this->carregarDependencias();?>
        <script src=<?php $this->path('assets/js/inicioPesquisa-script.js');?>></script>
    </head>

    <body>
        
        <div class="container">
            <?php $this->carregarCabecalho();?>

            <div class="col-sm-4"></div>
            <div class="col-sm-6">
                <div class="search-only form-search">
                    <i class="search-icon fa fa-search"></i>
                    <input type="text" id="campoBusca" class="form-control search-query" placeholder="Buscar Pesquisa de Satisfação">
                </div>
                <br>
                <div id="alert">

                </div>
                <div class="alert alert-warning alert-dismissible" role="alert" style="display:none;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <span id="aviso"></span>
                </div>
                <h3>Listando Resultados</h3>
                <hr>
                
                <div id="resposta"></div>
            </div>
                
            </div>
            <div class="col-sm-2"></div>
        </div>

        <!-- Modal Tipo-->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Deseja realmente remover esta pergunta?</h4>
            </div>
            <div class="modal-body">
                <h5>Por favor, informe a sua senha!</h5>
                <input id="password" name="password" type="password" class="form-control" placeholder="Insira a sua senha">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                <button id="confirmaRemover" type="button" class="btn btn-danger" data-dismiss="modal">Remover</button>
            </div>
            </div>
        </div>
        </div>

        <?php $this->carregarRodape();?>
    </body>
</html>