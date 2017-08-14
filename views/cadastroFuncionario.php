<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <!--Codificação dos caracteres: UTF-8-->
    <meta charset="utf-8" />
    <!--Descrição da página: Sertour-->
    <meta name="description" content="Setour" />
    <!--Regulando a visão da tela para a largura relativa à tela utilizada-->
    <meta name=viewport content="width=device-width, initial-scale=1" />

    <title>Cadastro de Funcionários</title>

    <?php $this->carregarDependencias()?>
    <script type="text/javascript" src="assets/js/validator.js"></script>


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
                <h4 class="text-center">Cadastro de Funcionários</h4>
            </div>
            <!--Fim do título da caixa-->

            <!-- Contorno -->
            <div id="contorno">

                <!-- Caixa interna -->
                <section id="caixa">

                    <!-- Formulário de cadastro de funcionários -->
                    <form data-toggle="validator" role="form" class="form-horizontal" method="POST">

                        <!-- Linha com duas entradas -->
                        <div class="form-group row">

                            <!-- Entrada do Nome -->
                            <div class="col-xs-6">
                                <input class="form-control" name="nome" type="text" placeholder="Nome(*)" id="inputName" data-error="Preencha este campo" required>
                            </div>

                            <!-- Entrada do sobrenome -->
                            <div class="col-xs-6">
                                <input class="form-control" name="sobrenome" type="text" placeholder="Sobrenome(*)">
                            </div>

                            <!-- Fim Linha com duas entradas -->
                        </div>

                        <!-- Entrada de email -->
                        <div>
                            <input class="form-control" name="email" type="text" placeholder="Email">
                        </div>

                        <br />

                        <!-- Linha com duas entradas -->
                        <div class="form-group row">

                            <!-- Entrada do Número de Matrícula -->
                            <div class="col-xs-6">
                                <input class="form-control" name="matricula" type="text" placeholder="Número de Matrícula(*)" id="inputName" data-error="Preencha este campo" required>
                            </div>

                            <!-- Entrada da Função -->
                            <div class="col-xs-6">
                                <input class="form-control" name="funcao" type="text" placeholder="Função(*)" id="inputName" data-error="Preencha este campo" required>
                            </div>

                            <!-- Fim Linha com duas entradas -->
                        </div>

                        <!-- Linha com duas entradas -->
                        <div class="form-group row">

                            <!-- Entrada de senha -->
                            <div class="col-xs-6">
                                <input class="form-control" name="senha" type="password" placeholder="Senha(*)" id="inputName" data-error="Preencha este campo" required>
                            </div>

                            <!-- Entrada de confirmação de senha -->
                            <div class="col-xs-6">
                                <input class="form-control" type="password" placeholder="Digite a senha novamente(*)" id="inputName" data-error="Preencha este campo" required>
                            </div>

                            <!-- Fim Linha com duas entradas -->
                        </div>

                        <h6>(*) Campos obrigatórios</h6>

                        
                        <?php if(isset($this->dados['exception']) && !empty($this->dados['exception'])){
                                echo '<h6 class="text-danger text-center">'.$this->dados['exception'].'</h6>';
                            }
                        ?>
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
                                        <input type="checkbox" name="cadastroObra"  id="inlineCheckbox1"> Cadastrar Obra
                                    </label>
                                    <label class="checkbox">
                                        <input type="checkbox" name="gerenciarObra"  id="inlineCheckbox2"> Gerenciar Obra
                                    </label>
                                    <label class="checkbox">
                                        <input type="checkbox" name="remocaoObra"  id="inlineCheckbox3"> Remover Obra
                                    </label>
                                </div>
                            </div>

                            <div class="col-xs-4">
                                <div class="controls span2">
                                    <label class="checkbox">
                                        <input type="checkbox" name="cadastroNoticia" id="inlineCheckbox1"> Inserir notícias
                                    </label>
                                    <label class="checkbox">
                                        <input type="checkbox" name="gerenciarNoticia" id="inlineCheckbox2"> Gerenciar notícias
                                    </label>
                                    <label class="checkbox">
                                        <input type="checkbox" name="remocaoNoticia" id="inlineCheckbox3"> Remover notícias
                                    </label>
                                </div>
                            
                            </div>

                            <div class="col-xs-4">
                                <div class="controls span2">
                                    <label class="checkbox">
                                        <input type="checkbox" name="realizarBackup" value="realizarBackup" id="inlineCheckbox1"> Realizar Backup
                                    </label>
                                </div>
                            </div>
                                <!-- Opções relacionadas a notícias -->
                        </div>

                        <!-- Linha com botões -->
                        <div class="form-group row modal-footer">

                            <!-- Botão cancelar -->
                            <button class="pull-right btn btn-default">CANCELAR</button>

                            <!-- Botão cadastrar -->
                            <button type="submit" class="pull-right btn btn-default" style="margin-right:5px">CADASTRAR </button>
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