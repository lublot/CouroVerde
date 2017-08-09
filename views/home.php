<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1 user-scalable=no">
		<title>Sertour</title>
		<!-- CSS resposavel pela aparencia do painel de noticias-->
		<link rel="stylesheet" type="text/css" href=<?php $this->path('assets/css/superslides.css');?>>
		<?php $this->carregarDependencias()?>
	</head>
    <body>

    <?php $this->carregarCabecalho();?>
    	 <div id="slides">
                <ul class="slides-container">
					<!--Repetir essa estrutura (<li>) a cada noticia-->
                    <li>
                        <img src="imagens/1.jpg" alt="">
                        <div class="description">
                            <h1 class="description__title">Museo Casa do Sertão</h1>
                            <p>O melhor museo do SERTOUR</p>
                        </div>
                    </li>
                    <li>
                        <img src="imagens/4.jpg" alt="">
                        <div class="description">
                            <h1 class="description__title">EXPOSIÃO DE ARTE CLASSICA</h1>
                        </div>
                    </li>
                    <li>
                        <img src="imagens/5.jpeg" alt="">
                        <div class="description">
                            <h1 class="description__title">EXIBIÇÕES NO EXTERIOR</h1>
                            <p>ALGUM LOCAL DOS ESTADOS UNIDOS DA AMERICA</p>
                        </div>
                    </li>
                </ul>
                <nav class="slides-navigation">
                    <a href="#" class="next">&#62;</a>
                    <a href="#" class="prev">&#60;</a>
                </nav>
            </div>
            <script src="js/jquery.js"></script>
            <script src="js/jquery.superslides.js"></script>
    
        </div>

        <?php $this->carregarRodape()?>

    </body>
</html>