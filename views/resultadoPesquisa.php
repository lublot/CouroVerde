<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8" />

        <meta name="description" content="Setour" />
        <meta name=viewport  content="width=device-width, initial-scale=1" />

        <title>Sertour</title>
        <?php $this->carregarDependencias()?>
        <script type="text/javascript" src=<?php $this->path("assets/js/resultadoBusca-script.js")?>></script>

    </head>
    <body>

        <?php $this->carregarCabecalho()?>
        <div class="container">
            
            <div class="col-xs-3">
                
            
                <div class="panel">
                    <div class="panel-heading text-center">
                        <h4>
                            Filtros
                        </h4>
                        <hr>
                        <h4 class="panel-title">
                            <a data-toggle="collapse" id="autor" class="collapsed" style="cursor:pointer">
                                <span  class="glyphicon glyphicon-camera"></span> Autor
                            </a>
                        </h4>
                        <br>
                        <h4 class="panel-title">
                            <a data-toggle="collapse" id="tag" class="collapsed" style="cursor:pointer">
                                <span  class="glyphicon glyphicon-camera"></span> Palavras-Chave
                            </a>
                        </h4>
                        <br>
                        <h4 class="panel-title">
                            <a data-toggle="collapse" id="titulo" class="collapsed" style="cursor:pointer">
                                <span class="glyphicon glyphicon-camera"></span> Título da Obra
                            </a>
                        </h4>
                        <hr>
                        <h5>
                            Busca Avançada
                        </h5>
                        <h4 class="panel-title">
                            <a data-toggle="collapse" id="classificacao" class="collapsed" style="cursor:pointer">
                                <span class="glyphicon glyphicon-camera"></span> Classificação
                            </a>
                        </h4>
                        <br>
                        <h4 class="panel-title">
                            <a data-toggle="collapse" id="colecao" class="collapsed" style="cursor:pointer">
                                <span class="glyphicon glyphicon-camera"></span> Coleção
                            </a>
                        </h4>
                        <br>
                    </div>
                </div>
            </div>
            
            <div class="col-xs-9">
                <div id="pagina"></div>
            </div>
        
        </div>

        <?php $this->carregarRodape()?>
    </body>
    <!--  -->

</html>