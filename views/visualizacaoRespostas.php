<html>
    <head>
        <title>Sertour</title>
        <meta charset="utf-8">
        <meta name=viewport content="width=device-width, initial-scale=1" />
        <!--Importação do CSS do Bootstrap, Bootflat e o pessoal (Estilos)-->
        <?php $this->carregarDependencias();?>
        <script src=<?php $this->path("./assets/js/d3.min.js")?>></script>
        <link rel="stylesheet" href=<?php $this->path("./assets/css/plot.css");?>>
        <script src=<?php $this->path("./assets/js/visualizarResposta-script.js");?>></script>
    </head>

    <body style="background-color: rgb(241, 242, 246);">
        <?php $this->carregarCabecalho()?>
        <div class="container">
            
            <div class="col-xs-3">
                <?php $this->carregarPainel()?>
            </div>
            <div class="col-xs-9">
                <div class="panel">
                    <h4 id="alerta"></h4>
                    <div class="panel-heading" id="pesquisa">                       
                        
                    </div>

                    <!-- Modal Aviso-->
                    <div class="modal fade" id="modalWarning" tabindex="-1" role="dialog" aria-labelledby="modalWarning">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header bg-danger">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="modalWarningTitle"><i class="fa fa-times-circle" aria-hidden="true"></i> Atenção!</h4>
                        </div>
                        <div class="modal-body">
                            <span id='descricaoErro'></span>
                        </div>
                        <div class="modal-footer">
                            <button id="confirmaAddPergunta" type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->carregarRodape()?>
    </body>
</html>