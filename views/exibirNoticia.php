<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <!--Codificação dos caracteres: UTF-8-->
    <meta charset="utf-8" />
    <!--Descrição da página: Sertour-->
    <meta name="description" content="Setour" />
    <!--Regulando a visão da tela para a largura relativa à tela utilizada-->
    <meta name=viewport content="width=device-width, initial-scale=1" />

    <title>Notícia</title>

    <?php $this->carregarDependencias();?>
    
</head>

<body style="background-color: rgb(241, 242, 246);">
    <?php $this->carregarCabecalho();?>    

    <div class="container">

            <!--Título da caixa-->
            <div id="titulo">
                <h3 class="text-center">NOME DA NOTÍCIAAAA</h3>
            </div>
            <!--Fim do título da caixa-->

            <!--Div com o contorno e organização dos elementos no centro-->
            <div id="contorno">

                        <!--Página 1: Informações da Obra-->
                        <div id="page_1">

                            <div class="text-center">
                                <!--Subtítulo da notícia -->
                                <h5 class="text-center">Identificação do Objeto</h5>
                                <br>

                                <!-- Imagem da notícia -->
                                <div>
                                    <img clas="img-responsive center-block" src="linkkkkk"/>
                                </div>
                                
                                <br>

                                <!-- Data da notícia -->
                                <h6 class="text-center">Identificação do Objeto</h6>
                            </div>
                            <br>
                            <!--Section com os elementos agrupados no centro-->
                            <section id="caixa">


                            </section>
                            <!--Fim da seção com os campos do cadastro-->

                        </div>

            </div>
            <!--Fim da div contorno-->

        </div>

    </div>
    <?php $this->carregarRodape();?>    
</body>

</html>