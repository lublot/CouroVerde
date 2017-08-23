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
                <a href="#" class="direita">Ajuda  <span></span></a>
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

        <!-- Fim do container  -->
    </div>

    <!-- Footer -->
    <footer class="footer-distributed">

        <div class="footer-left">

            <h3>Sertour</h3>

            <p class="footer-company-name">MItologic Software® &copy; 2017</p>
        </div>

        <div class="footer-center">

            <p class="footer-links">
                <a href="#">Home</a>
                <a href="#">Galeria</a>
                <a href="#">Sobre</a>
            </p>

        </div>

        <div class="footer-right">

            <div class="footer-icons">
                <p style="text-align: center;">
                    <a href="#"><i class="fa fa-twitter"></i></a>
                    <a href="#"><i class="fa fa-facebook"></i></a>
                    <a href="#"><i class="fa fa-google-plus"></i></a>
                </p>

            </div>


        </div>

    </footer>
    <!-- /Footer -->

</body>

</html>