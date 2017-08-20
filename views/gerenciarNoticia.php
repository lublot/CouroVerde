<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <!--Codificação dos caracteres: UTF-8-->
    <meta charset="utf-8" />
    <!--Descrição da página: Sertour-->
    <meta name="description" content="Setour" />
    <!--Regulando a visão da tela para a largura relativa à tela utilizada-->
    <meta name=viewport content="width=device-width, initial-scale=1" />

    <title>Gerenciamento de Notícias</title>

    <?php $this->carregarDependencias()?>

    <script src=<?php $this->path("assets/js/gerenciarNoticia-script.js");?>></script>


</head>

<body style="background-color: rgb(241, 242, 246);">

    <?php $this->carregarCabecalho()?>
    <!-- Container  -->
    <div class="container">

        <!-- Painel -->
        <div class="col-xs-3">
            <?php $this->carregarPainel()?>
        </div>

        <!-- Div cadastro-noticias -->
        <div id='cadastro-noticias' class="col-md-9 col-lg-9">

            <!--Título da caixa-->
            <div id="titulo">
                <h4 class='text-center'>Edição de Notícias</h4>
            </div>
            <!--Fim do título da caixa-->

            <!-- Contorno -->
            <div id="contorno">

                <!-- Caixa interna -->
                <section id="caixa">
                    <input type="hidden" id="idNoticia" value="<?php if(isset($this->dados['noticia'])){echo $this->dados['noticia']->getIdNoticia();} ?>"></input>
                     <?php if(isset($this->dados['alerta'])){echo '<div class="alert alert-warning" role="alert">'.$this->dados['alerta'].'</div>';}?>
                    
                    <!-- Formulário de cadastro/alteração de notícias -->
                    <form data-toggle="validator" role="form" method="POST" enctype="multipart/form-data" <?php if(isset($this->dados['alerta'])){echo "style='display:none'";}?>>

                        <!-- Subtítulo -->
                        <div class="form-group">
                            <h5 class="text-center">Informações</h5>
                        </div>

                        <!-- Upload da imagem -->
                        <div class="form-group">
                            <div class="form-control " id="caixa-img" style="background:url(<?php echo ROOT_URL.$this->dados['noticia']->getCaminhoImagem()?>);background-size:contain;background-repeat:no-repeat;background-position:center">
                            </div>
                        </div>

                        <!-- Linha com duas entradas -->
                        <div class="form-group row">

                            <!-- Entrada do título -->
                            <div class="col-xs-6">
                                <input class="form-control" type="text" placeholder="Título(*)" value="<?php if(isset($this->dados['noticia'])){echo $this->dados['noticia']->getTitulo();} ?>" name="titulo" id="inputName" data-error="Preencha este campo" required>
                            </div>

                            <!-- Entrada do subtítulo -->
                            <div class="col-xs-6">
                                <input class="form-control" type="text" placeholder="Subtitulo" value="<?php if(isset($this->dados['noticia'])){echo $this->dados['noticia']->getSubtitulo();} ?>" name="subtitulo">
                            </div>

                            <!-- Fim Linha com duas entradas -->
                        </div>

                        <!-- TextArea com entrada da descrição -->
                        <div class="form-group ">
                            <textarea class="form-control" placeholder="Conteúdo(*)" type="text" rows="5" name="descricao" required><?php if(isset($this->dados['noticia'])){echo $this->dados['noticia']->getDescricao();} ?></textarea>
                        </div>

                        <h6>(*) Campos obrigatórios</h6>

                        <!-- Linha com botões -->
                        <div class="row modal-footer">

                            <!-- Botão cancelar -->
                            <?php if(isset($this->dados['podeRemoverNoticia'])){
                                echo '<button type="button" id="remover" class="pull-right btn btn-danger" name="btnCancelar"> REMOVER </button>';
                            }?>
                            <!-- Botão cadastrar ou botão alterar-->
                            <?php if(isset($this->dados['podeGerenciarNoticia'])){
                                echo '<button type="button" id="confirmar" class="pull-right btn btn-success" style="margin-right:5px" name="btnCadNoticia"> ATUALIZAR INFORMAÇÕES </button>';
                            }?>
                        
                        </div>

                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Deseja realmente remover esta notícia?</h4>
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

    <?php $this->carregarRodape()?>
</body>

</html>