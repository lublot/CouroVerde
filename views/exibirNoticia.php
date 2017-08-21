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

    <?php 
        use DAO\noticiaDAO as NoticiaDAO;            
        if(isset($this->dados['idNoticia'])) {
            $noticiaDAO = new NoticiaDAO();
            $noticia = $noticiaDAO->buscar(array(), array('idNoticia' => $this->dados['idNoticia']))[0];
            $titulo = $noticia->getTitulo();
            $subtitulo = $noticia->getSubtitulo();
            $descricao = $noticia->getDescricao();
            $caminhoImagem = $noticia->getCaminhoImagem();
            $data = $noticia->getData();
            
        } 
    ?>
  

    <div class="container">
        <!--Título da caixa-->
        <div id="titulo">
            <h3 class="text-center"><?php echo isset($titulo) ? $titulo : null; ?></h3>
        </div>
        <!--Fim do título da caixa-->

        <!--Div com o contorno e organização dos elementos no centro-->
        <div id="contorno">

            <div class="text-center">
                <!--Subtítulo da notícia -->
                <h5 class="text-center"><?php echo isset($subtitulo) ? $subtitulo : null; ?></h5>
                <br>

                <!-- Imagem da notícia -->
                <div>
                    <img clas="img-responsive center-block" src="<?php echo ROOT_URL . $caminhoImagem; ?>" alt="..." style="width:90%;height:auto !important;"/>
                </div>
                
                <br>

                <!-- Data da notícia -->
                <h6 class="text-center"><?php echo isset($data) ? $data : null; ?></h6>
                
                <section id="caixa">
                    <span style='display:block;width:auto;word-wrap:break-word;'><p style='align="justify";'><?php echo isset($descricao) ? $descricao : null; ?></p></span>
                </section>                    
            </div>
        </div>
        <!--Fim da div contorno-->
    </div>
    <?php $this->carregarRodape();?>    
</body>

</html>