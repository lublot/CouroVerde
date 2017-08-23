<html>
    <head>
        <title>Sertour</title>
        <meta charset="utf-8">
        <meta name=viewport  content="width=device-width, initial-scale=1" />

        <?php $this->carregarDependencias();?>
        <script src=<?php $this->path('assets/js/inicioPesquisa-script.js');?>></script>
    </head>

    <body style="background-color: rgb(241, 242, 246);">
        <?php $this->carregarCabecalho();?>
        <div class="container">
            <div class="col-xs-3">
                <?php $this->carregarPainel();?>
            </div>
            
            <div class="col-xs-9">
                <!--Título da caixa-->
                <div id="titulo">
                    <h4 class="text-center">Gerenciamento de Pesquisa</h4>
                </div>
                <!--Fim do título da caixa-->

                <!--Div com o contorno e organização dos elementos no centro-->
                <div id="contorno">                
                    <a href="#ajudapesquisa" data-toggle="modal" class="direita">Ajuda  <span></span></a><br><br>
                    <div class="search-only form-search">
                        <i class="search-icon fa fa-search"></i>
                        <input type="text" id="campoBusca" class="form-control search-query" placeholder="Buscar Pesquisa de Satisfação">
                    </div>
                    <br>
                    <div id="alert"> </div>
                    
                    <div class="alert alert-warning alert-dismissible" role="alert" style="display:none;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <span id="aviso"></span>
                        </div>
                        <h3>Listando Resultados</h3>
                        <hr>
                        
                        <div id="resposta"></div>
                    </div>
                </div>
                    
            </div>
        <!--<div class="col-sm-2"></div>-->
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


        <div class="modal fade" id="ajudapesquisa" role="dialog">

            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Tiítulo do modal -->
                    <div class="modal-header">
                        <h2 style="margin-bottom: 1px;">Suporte ao usuário - Pesquisas</h2>
                        <!-- Corpo do modal -->
                        <div class="modal-body">
                            <!-- Início da lista de tópicos -->
                            <div id="accordion" role="tablist" aria-multiselectable="true">

                                <!-- Novo tópico -->
                                <div class="card">
                                    <div class="card-header" role="tab" id="headingOne">
                                        <!-- Nome do tópico -->
                                        <h4 class="mb-0">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                            Como criar uma nova pesquisa?
                                        </a>
                                        </h4>
                                    </div>

                                    <!-- Corpo do tópico -->
                                    <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                        <div class="card-block">
                                            <ol>
                                                <li>Na barra lateral esquerda, clique em <strong>pesquisas</strong> e em seguida
                                                    em <strong>Criar Pesquisa</strong></li>
                                                <li>Insira o <strong>título</strong> e a <strong>descrição</strong> da pesquisa</li>
                                                <li>Clique em <img src=<?php $this->path("assets/images/adicioneUmaPergunta.png")?> style="width: 34%; height: 34%"
                                                    /img> para adicionar um novo item à sua pesquisa. Você pode inserir quantas perguntas quiser.</li>
                                                <li>Selecione o <strong>tipo</strong> da pergunta. As perguntas podem ser <strong>abertas</strong>                                                    ou de <strong>marcar</strong>, nesse último caso você pode definir se
                                                    o usuário pode <strong>marcar várias</strong> ou <strong> apenas uma </strong>                                                    das respostas.</li>
                                                <li>Insira a definição da pergunta e, caso seja de marcar, clique em <img src=<?php $this->path("assets/images/adicionarUmaOpcao.png")?>
                                                        style="width: 30%; height: 30%" /img> para adicionar uma resposta. Você
                                                    pode inserir quantas opções de resposta quiser. </li>
                                                <li>Marque a caixa abaixo da pergunta caso queira que a resposta dela seja <strong>obrigatória</strong></li>
                                                <li>Quando tiver acabado de inserir todas as perguntas e respostas desejadas,
                                                    clique em <img src=<?php $this->path("assets/images/pronto.png")?> style="width: 14%; height:14%" /img>para
                                                    salvar a sua pesquisa.</li>
                                                <li>Quando uma nova pesquisa é adicionada ela está <strong>desativada</strong>                                                    por padrão. Para saber como modificar isso veja no tópico abaixo <strong>"Como ativar ou desativar uma pesquisa".</strong></li>
                                                <li>Você pode ver as respostas da sua nova pesquisa clicando em <strong>Pesquisas</strong>, em seguida
                                                    em <strong>Gerenciar Pesquisas</strong> e então em <img src=<?php $this->path("assets/images/verRespostas.png")?>
                                                        style="width: 22%; height: 22%" /img></li>
                                            </ol>

                                        </div>
                                    </div>
                                </div>

                                <!-- Novo tópico -->
                                <div class="card">
                                    <!-- Nome do tópico -->
                                    <div class="card-header" role="tab" id="headingTwo">
                                        <h4 class="mb-0">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            Como ativar ou desativar uma pesquisa?
                                        </a>
                                        </h4>
                                    </div>
                                    <!-- Corpo do tópico -->
                                    <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                                        <div class="card-block">
                                            <ol>
                                                <li>Na barra lateral esquerda, clique em <strong>Pesquisas</strong> e em seguida
                                                    em <strong>Gerenciar Pesquisas</strong></li>
                                                <li>Encontre a pesquisa que deseja</li>
                                                <li>Clique em <img src=<?php $this->path("assets/images/ativar.png")?> style="width: 16%; height: 16%" /img> para
                                                    permitir que a pesquisa receba novas respostas ou em
                                                    <img src=<?php $this->path("assets/images/desativar.png")?> style="width: 18%; height: 18%" /img> para torná-la
                                                    indisponível</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>

                                <!-- Novo tópico -->
                                <div class="card">
                                    <!-- Nome do tópico -->
                                    <div class="card-header" role="tab" id="headingThree">
                                        <h4 class="mb-0">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            Como editar as perguntas, respostas e outras informações de uma pesquisa?
                                        </a>
                                        </h4>
                                    </div>
                                    <!-- Corpo do tópico -->
                                    <div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree">
                                        <div class="card-block">

                                            <ol>
                                                <li>Na barra lateral esquerda, clique em <strong>Pesquisas</strong> e em seguida
                                                    em <strong>Gerenciar Pesquisas</strong></li>
                                                <li>Encontre a pesquisa que deseja editar e clique em  <img src=<?php $this->path("assets/images/editar.png")?> style="width: 16%; height: 16%" /img></li>
                                                <li>Faça as alterações desejadas na pesquisa</li>
                                                <li>clique em <img src=<?php $this->path("assets/images/pronto.png")?> style="width: 14%; height:14%" /img> para salvar as modificações</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>

                                <!-- Novo tópico -->
                                <div class="card">
                                    <!-- Nome do tópico -->
                                    <div class="card-header" role="tab" id="headingFour">
                                        <h4 class="mb-0">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseTwo">
                                                Como excluir uma pesquisa?
                                            </a>
                                        </h4>
                                    </div>
                                    <!-- Corpo do tópico -->
                                    <div id="collapseFour" class="collapse" role="tabpanel" aria-labelledby="headingFour">
                                        <div class="card-block">
                                            <ol>
                                                <li>Na barra lateral esquerda, clique em <strong>Pesquisas</strong> e em seguida
                                                    em <strong>Gerenciar Pesquisas</strong></li>
                                                <li>Encontre a pesquisa que deseja excluir e clique em <img src=<?php $this->path("assets/images/remover.png")?> style="width: 18%; height:18%" /img></li>
                                                <li><strong>Insira novamente a sua senha</strong> e clique em <img src=<?php $this->path("assets/images/remover.png")?> style="width: 18%; height:18%" /img> para concluir a exclusão</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- Fim da lista de tópicos -->

                        </div>

                        <!-- Botão de fechar -->
                        <div class="modal-footer">
                            <a class="btn btn-primary" data-dismiss="modal">Voltar</a>
                        </div>
                    </div>
                </div>
            </div>

            <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
            <script src="js/bootstrap.js"></script>

        </div>
        <?php $this->carregarRodape();?>
    </body>
</html>