<html>
    <head>
        <title>Sertour</title>
        <meta charset="utf-8">
        <meta name=viewport  content="width=device-width, initial-scale=1" />

        <title>Registro de Pesquisa</title>

        <?php $this->carregarDependencias()?>
        <script src=<?php $this->path("assets/js/cadastroPesquisa-script.js")?>></script>
       

    </head>

    <body style="background-color: rgb(241, 242, 246);">
        <?php $this->carregarCabecalho()?>
        <div class="container">
            
            <div class="col-sm-3">
                <?php $this->carregarPainel()?>
            </div>
            <div class="col-sm-9">
                <!--Título da caixa-->
                <div id="titulo">
                    <h4 class="text-center">Registro de Pesquisa</h4>
                </div>
                <!--Fim do título da caixa-->

                <!--Div com o contorno e organização dos elementos no centro-->
                <div id="contorno">
                    <a href="#ajudapesquisa" data-toggle="modal" class="direita">Ajuda  <span></span></a><br><br>
                    <form class="form-horizontal" id="principal">
                        <div class="container" style="margin-left:5%">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input type="text" id="tituloPesquisa" name="tituloPesquisa" class="form-control" placeholder="Título da Pesquisa">
                                    </div>
                                </div>
                            </div>
                            <div class="row">                        
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input type="text" id="descricaoPesquisa" name="descricaoPesquisa" class="form-control" placeholder="Descrição da Pesquisa">
                                    </div>
                                </div>
                            </div>

                        <div id='guia-pergunta' class="form-group">
                            
                            <h5>
                            <span aria-hidden="true" data-toggle="modal" data-target="#myModal" style="cursor:pointer;">Adicione uma pergunta 
                                <span id="addPergunta" class="fa fa-plus-circle fa-lg" style="color:#3bafe1;" > </span>
                            </span>
                            </h5>
                        </div>
                        
                        <div class="form-group"> 
                            <button id="botaoEnvio" disabled='false' type="button" class="btn btn-primary">Pronto</button>
                        </div>
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
                            <input type="radio" class="iradio_flat" tipo='ABERTA' name="tipoPergunta" value="Aberta"> Aberta <br>
                            <input type="radio" class="iradio_flat" tipo='MULTIPLA ESCOLHA' name="tipoPergunta" value="Múltipla Escolha"> Múltipla Escolha <br>
                            <input type="radio" class="iradio_flat" tipo='UNICA ESCOLHA' name="tipoPergunta" value="Única Escolha"> Única Escolha <br>
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
        </div>
        <?php $this->carregarRodape()?>
    </body>
</html>