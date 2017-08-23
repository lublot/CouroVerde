<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <!--Codificação dos caracteres: UTF-8-->
    <meta charset="utf-8" />
    <!--Descrição da página: Sertour-->
    <meta name="description" content="Setour" />
    <!--Regulando a visão da tela para a largura relativa à tela utilizada-->
    <meta name=viewport content="width=device-width, initial-scale=1" />
    <title>Gerenciamento de Funcionários</title>

    <?php $this->carregarDependencias()?>
    <script type="text/javascript" src=<?php $this->path("assets/js/gerenciarFuncionario-script.js")?>></script>
    <script type="text/javascript" src=<?php $this->path("assets/js/validator.js")?>></script>


</head>

<body style="background-color: rgb(241, 242, 246);">

    <?php $this->carregarCabecalho()?>
    <!-- Container  -->
    <div class="container">
        <!-- Painel -->
        <div class="col-xs-3">
            <?php $this->carregarPainel()?>
        </div>

        <!-- Div cadastro-funcionários -->
        <div id='cadastro-funcionários' class="col-md-9 col-lg-9">

            <!--Título da caixa-->
            <div id="titulo">
                <h4 class="text-center">Gerenciamento de Funcionários</h4>
            </div>
            <!--Fim do título da caixa-->

            <!-- Contorno -->
            <div id="contorno">
                <!--Botão de Ajuda-->
                <a href="#ajudafuncionario" data-toggle="modal" class="direita">Ajuda  <span></span></a>
                <!-- Caixa interna -->
                <section id="caixa">
                    <?php if(isset($this->dados['alerta'])){echo '<div class="alert alert-warning" role="alert">'.$this->dados['alerta'].'</div>';}?>
                    
                    <!-- Formulário de cadastro de funcionários -->
                    <form data-toggle="validator" id="form" role="form" class="form-horizontal" method="POST"<?php if(isset($this->dados['alerta'])){echo 'style="display:none"';}?>>
                        
                        <!-- Linha com duas entradas -->
                        <div class="form-group row">

                            <!-- Entrada do Nome -->
                            <div class="col-xs-6">
                                <input class="form-control" name="nome" type="text" placeholder="Nome(*)" id="inputName" data-error="Preencha este campo" required value="<?php if(isset($this->dados['nome'])){echo htmlentities($this->dados['nome']);}?>">
                            </div>

                            <!-- Entrada do sobrenome -->
                            <div class="col-xs-6">
                                <input class="form-control" name="sobrenome" type="text" placeholder="Sobrenome(*)" value="<?php if(isset($this->dados['sobrenome'])){echo $this->dados['sobrenome'];}?>">
                            </div>

                            <!-- Fim Linha com duas entradas -->
                        </div>

                        <!-- Entrada de email -->
                        <div>
                            <input class="form-control" name="email" type="text" placeholder="Email" value="<?php if(isset($this->dados['email'])){echo $this->dados['email'];}?>">
                        </div>

                        <br />

                        <!-- Linha com duas entradas -->
                        <div class="form-group row">

                            <!-- Entrada do Número de Matrícula -->
                            <div class="col-xs-6">
                                <input class="form-control" name="matricula" disabled type="text" placeholder="Número de Matrícula(*)" id="inputName" data-error="Preencha este campo" required value="<?php if(isset($this->dados['matricula'])){echo $this->dados['matricula'];}?>">
                            </div>

                            <!-- Entrada da Função -->
                            <div class="col-xs-6">
                                <input class="form-control" name="funcao" type="text" placeholder="Função(*)" id="inputName" data-error="Preencha este campo" required value="<?php if(isset($this->dados['funcao'])){echo $this->dados['funcao'];}?>">
                            </div>

                            <!-- Fim Linha com duas entradas -->
                        </div>

                        <h6>(*) Campos obrigatórios</h6>

                        <div id="notify">
                        <?php if(isset($this->dados['exception']) && !empty($this->dados['exception'])){
                                echo '<h6 class="text-danger text-center">'.$this->dados['exception'].'</h6>';
                            }
                        ?>
                        </div>
                        <!-- Subtítulo -->
                        <div class="form-group">
                            <h5 class="text-center">Privilégios administrativos</h5>
                        </div>

                        <!-- Checkboxes de privelégios -->
                        <div class="control-group col-xs-12" style="padding-left: 3vh; padding-bottom: 5vh">

                            <!-- Opções relacionadas a funcionário -->
                            <div class="col-xs-4">
                                <div class="controls span2">
                                    <label for="inlineCheckbox1"class="checkbox">
                                        <input type="checkbox" name="cadastroObra"  id="inlineCheckbox1" <?php if($this->dados['podeCadastrarObra'] == "1"){echo 'checked';}?> > Cadastrar Obra
                                    </label>
                                    <label class="checkbox">
                                        <input type="checkbox" name="gerenciarObra"  id="inlineCheckbox2" <?php if($this->dados['podeGerenciarObra'] == "1"){echo 'checked';}?>> Gerenciar Obra
                                    </label>
                                    <label class="checkbox">
                                        <input type="checkbox" name="remocaoObra"  id="inlineCheckbox3" <?php if($this->dados['podeRemoverObra'] == "1"){echo 'checked';}?>> Remover Obra
                                    </label>
                                </div>
                            </div>

                            <div class="col-xs-4">
                                <div class="controls span2">
                                    <label class="checkbox">
                                        <input type="checkbox" name="cadastroNoticia" id="inlineCheckbox1" <?php if($this->dados['podeCadastrarNoticia'] == "1"){echo 'checked';}?>> Inserir notícias
                                    </label>
                                    <label class="checkbox">
                                        <input type="checkbox" name="gerenciarNoticia" id="inlineCheckbox2" <?php if($this->dados['podeGerenciarNoticia'] == "1"){echo 'checked';}?>> Gerenciar notícias
                                    </label>
                                    <label class="checkbox">
                                        <input type="checkbox" name="remocaoNoticia" id="inlineCheckbox3" <?php if($this->dados['podeRemoverNoticia'] == "1"){echo 'checked';}?>> Remover notícias
                                    </label>
                                </div>
                            
                            </div>

                            <div class="col-xs-4">
                                <div class="controls span2">
                                    <label class="checkbox">
                                        <input type="checkbox" name="realizarBackup" value="realizarBackup" id="inlineCheckbox1" <?php if($this->dados['podeRealizarBackup'] == "1"){echo 'checked';}?>> Realizar Backup
                                    </label>
                                </div>
                            </div>
                                <!-- Opções relacionadas a notícias -->
                        </div>

                        <!-- Linha com botões -->
                        <div class="form-group row modal-footer">

                            <!-- Botão cancelar -->
                            <button type="button" id="remover" class="pull-right btn btn-danger">Remover</button>

                            <!-- Botão cadastrar -->
                            <button type="button" id="confirmar" class="pull-right btn btn-primary" style="margin-right:5px">Atualizar Informações</button>
                        </div>

                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Deseja realmente remover este funcionário?</h4>
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
                        <!-- Fim do Formulário de cadastro de notícias  -->
                    </form>

                    <!-- Fim da Caixa interna -->
                </section>

                <!-- Fim do contorno -->
            </div>

            <!-- Fim Div cadastro-noticias -->
        </div>
        <div class="modal fade" id="ajudafuncionario" role="dialog">

            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Tiítulo do modal -->
                    <div class="modal-header">
                        <h2 style="margin-bottom: 1px;">Suporte ao usuário - Funcionário</h2>
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
                                            Como cadastrar um novo funcionário?
                                        </a>
                                        </h4>
                                    </div>

                                    <!-- Corpo do tópico -->
                                    <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                        <div class="card-block">
                                            <ol>
                                                <li>Na barra lateral esquerda, clique em <strong>funcionários</strong> e em seguida
                                                    em <strong>cadastrar funcionário.</strong></li>
                                                <li>Preencha os campos com as informações do novo funcionário. Campos com * são obrigatórios e não podem ser deixados em branco.</li>
                                                <li>Marque as caixas com as permissões que você deseja que o novo funcionário possua</li>
                                                <li>clique em <img src=<?php $this->path("assets/images/cadastrar.png")?> style="width: 18%; height: 18%" /img> para finalizar o cadastro do funcionário</li>
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
                                            Como alterar o cadastro de um funcionário?
                                        </a>
                                        </h4>
                                    </div>
                                    <!-- Corpo do tópico -->
                                    <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                                        <div class="card-block">
                                            <ol>
                                                <li>Na barra lateral esquerda, clique em <strong>funcionários</strong> e em seguida
                                                    em <strong>gerenciar funcionários</strong></li>
                                                <li>Selecione o funcionário cujo cadastro deseja alterar</li>
                                                <li>Modifique os campos que deseja alterar com as novas informações e marque/desmarque autorizações que você deseja conceder ou remover</li>
                                                <li>Clique em <img src=<?php $this->path("assets/images/atualizarInformacoes.png")?> style="width: 30%; height: 30%" /img> para salvar as modificações</li>
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
                                            Como remover o cadastro de um funcionário?
                                        </a>
                                        </h4>
                                    </div>
                                    <!-- Corpo do tópico -->
                                    <div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree">
                                        <div class="card-block">

                                            <ol>
                                                <li>Na barra lateral esquerda, clique em <strong>funcionários</strong> e em seguida
                                                    em <strong>gerenciar funcionários</strong></li>
                                                <li>Selecione o funcionário que você deseja excluir</li>
                                                <li>Clique em <img src=<?php $this->path("assets/images/remover.png")?> style="width: 20%; height: 20%" /img> para salvar as modificações</li>
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
        <!-- Fim do container  -->
    </div>

    <!-- Footer -->
    <?php $this->carregarRodape()?>
    <!-- /Footer -->

</body>

</html>