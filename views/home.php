<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1 user-scalable=no">
		<title>Sertour</title>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<!--JavaScript do materialize responsavel pela dinamica do painel de noticias-->
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/js/materialize.min.js"></script>
		<!-- CSS do materialize resposavel pela aparencia do painel de noticias-->
		<link rel="stylesheet" type="text/css" href=<?php $this->path('assets/css/materialize.min.css');?>>
		<link rel="stylesheet" type ="text/css" href=<?php $this->path('assets/css/bootstrap.css')?>>
        <link rel="stylesheet" type ="text/css" href=<?php $this->path('assets/css/bootstrap-theme.css')?>>
        <link rel="stylesheet" type ="text/css" href=<?php $this->path('assets/css/estilo.css')?>>
        <link rel="stylesheet" type ="text/css" href=<?php $this->path('assets/css/topo.css')?>>
        <link rel="stylesheet" type ="text/css" href=<?php $this->path('assets/css/bootstrap-social.css')?>>
        <link rel="stylesheet" type ="text/css" href=<?php $this->path('assets/css/site.css')?>>
        <link rel="stylesheet" type ="text/css" href=<?php $this->path('assets/css/site.min.css')?>>
        <script type ="text/javascript" src=<?php $this->path('assets/js/jquery-3.2.1.min.js')?>></script>
        <script type="text/javascript" src=<?php $this->path('assets/js/bootstrap.js');?>></script>
		<!--Fonte do materialize para o painel de noticias-->
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	</head>
    <body>

    <?php $this->carregarCabecalho();?>
        
    	<!--Divisão responsavel pelo panel rotativo-->	
    	<div class="slider">
    	<!--<div class="slider fullscreen">-->
    		<!--ul responsvel por receber a lista de imagens do painel-->
    		<ul class="slides">
      			
    		</ul>
  		</div>

  		<!-- Codigo responsavel por inserir  dinamicamente as imagens e os textos das noticias-->
  		<!--<?php
  			/* SELECT * FROM nome_da_tabela .....*/
  		 	$result_carousel = "SELECT * FROM noticias ORDER BY id ASC";
            /* 
              *connn se refere a variavel do arquivo conexao.php, a mesma recebe o seguinte valor -> $conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
             */
            $resultado_carousel = mysqli_query($conn, $result_carousel);
            while($row_carousel = mysqli_fetch_assoc($resultado_carousel)){?>
            	<!--Adiciona as imagens na ul, que pertence a class slides-->
            	<script type="text/javascript">
            		$(document).ready(function(){
            			//$row_carousel['caminho'] recebe o caminho da imagem, alterar o campo 'caminho' pelo campo correspondente no banco
            			//alterar o campo subtitulo, pelo campo correspondente no banco a descrição da noticia
            			$('.slides').append("<li><img src=\"imagens/noticias/<?php echo $row_carousel['caminho']; ?>.jpg\"><div class=\"caption left-align\"><h3><?php echo $row_carousel['titulo']; ?></h3><h5 class=\"light grey-text text-lighten-3\"><?php echo $row_carousel['subtitulo']; ?></h5></div></li>");
            		});
            	</script>
            	<?php
            }
        ?> -->

        <?php $this->carregarRodape()?>

		<script type="text/javascript">
	 		//Inicializa o "slide" das noticias
	 		$(document).ready(function(){
	 			//full_Width: true indica que as imagens devem ocupar toda a largura da tela
      			$('.slider').slider({full_width: true});
    		});
		</script>
    </body>
</html>