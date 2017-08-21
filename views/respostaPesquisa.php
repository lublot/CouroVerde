<html>
    <head>
        <title>Sertour</title>
        <meta charset="utf-8">
        <meta name=viewport content="width=device-width, initial-scale=1" />
        <?php $this->carregarDependencias()?>
        <script src=<?php $this->path("assets/js/respostaPesquisa-script.js")?>></script>
    </head>

    <body>
        <?php $this->carregarCabecalho()?>
        <div class="container">
            <div class="col-xs-3">
            </div>
            <div class="col-xs-9">
                <div class="panel">

                    <?php if(isset($dados['exception'])){
                            echo '<h4><br>'.$dados['exception'].'<br><br></h4>';
                          }else{
                            echo '<form class="panel-heading" id="pesquisa" method="POST">                       
                            </form>';
                          }
                    ?>
                    
                    

                    <!-- Modal Aviso-->
                    <div class="modal fade" id="modalWarning" tabindex="-1" role="dialog" aria-labelledby="modalWarning">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header bg-warning">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="modalWarningTitle"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Atenção!</h4>
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