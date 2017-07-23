<html>
    <head>
        
        <title>Sertour</title>
        <meta charset="utf-8">
        <meta name=viewport  content="width=device-width, initial-scale=1" />
        <script src=<?php $this->path("assets/js/gerenciaPesquisa-script.js")?>></script>
        <?php $this->carregarDependencias();?>
    </head>

    <body style="visibility:hidden">
        <div class='container'>
            <?php $this->carregarCabecalho();?>
            <div class="col-sm-3"></div>
            <div id="pesquisa" class="col-sm-9">
                <div id='alerta' class="alert alert-warning alert-dismissible" role="alert" style="display:none;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <span id="aviso"></span>
                </div>
                <form class="form-horizontal" id="principal">
                        <div class="form-group">
                            <input type="text" id="tituloPesquisa" name="tituloPesquisa" class="form-control" placeholder="Título da Pesquisa">
                        </div>

                        <div class="form-group">
                            <input type="text" id="descricaoPesquisa" name="descricaoPesquisa" class="form-control" placeholder="Descrição da Pesquisa">
                        </div>

                        <div id='guia-pergunta' class="form-group">
                        
                        <h5>
                        <span aria-hidden="true" data-toggle="modal" data-target="#myModal" style="cursor:pointer;">Adicione uma pergunta 
                            <span id="addPergunta" class="fa fa-plus-circle fa-lg" style="color:green;" > </span>
                        </span>
                        </h5>
                    </div>
                    
                    <div class="form-group"> 
                        <button id="botaoEnvio" disabled='false' type="button" class="btn btn-success">Pronto</button>
                    </div>
                    
                    <!-- Modal Tipo-->
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Qual é o tipo de resposta esperado para esta pergunta?</h4>
                        </div>
                        <div class="modal-body">
                            <input type="radio" class="iradio_flat" name="tipoPergunta" tipo="ABERTA" value="Aberta"> Aberta <br>
                            <input type="radio" class="iradio_flat" name="tipoPergunta" tipo="MULTIPLA ESCOLHA" value="Múltipla Escolha"> Múltipla Escolha <br>
                            <input type="radio" class="iradio_flat" name="tipoPergunta" tipo="UNICA ESCOLHA" value="Única Escolha"> Única Escolha <br>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button id="confirmaAddPergunta" type="button" class="btn btn-primary" data-dismiss="modal">Pronto</button>
                        </div>
                        </div>
                    </div>
                    </div>

                    <!-- Modal Erro-->
                    <div class="modal fade" id="modalError" tabindex="-1" role="dialog" aria-labelledby="modalError">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header bg-danger">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="modalErrorTitle"><i class="fa fa-times-circle" aria-hidden="true"></i> Ocorreu um erro</h4>
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
                </form>
            </div>
        </div>

        <?php $this->carregarRodape();?>
    </body>
</html>