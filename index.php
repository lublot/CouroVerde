<?php
	require_once("./config.php");
?>

<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Sertour</title>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<!--JavaScript do materialize responsavel pela dinamica do painel de noticias-->
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/js/materialize.min.js"></script>
		<!-- CSS do materialize resposavel pela aparencia do painel de noticias-->
		<link rel="stylesheet" type="text/css" href="views/assets/css/materialize.min.css">
		<link rel="stylesheet" href="views/assets/css/bootstrap.css" />
		<link rel="stylesheet" href="views/assets/css/bootstrap-theme.css" />
		<link rel="stylesheet" href="views/assets/css/estilo.css" />
		<link rel="stylesheet" href="views/assets/css/bootstrap-social.css" />
		<!--Fonte do materialize para o painel de noticias-->
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	</head>
    <body>

    <!--CABEÇALHO-->
    <div class="container">
      <div class="row">
          <div class="col-md-1 col-sm-1"></div>
          <div class="col-xs-12 col-md-11">
               <h2><i class="fa fa-bars"></i> Sertour</h2>
          </div>

      </div>

      <div class="row">
          <div class="col-xs-12 visible-xs-block" >
                <?php
                    if(isset($_SESSION['nome']) && !empty($_SESSION['nome'])){
                        echo '<span style="float:right"><b>Olá, '.$_SESSION['nome'].'!</b></span><br><br>';
                    }else{
                       echo '<center><span><a href="#"><strong>Fazer Login</strong></a></span> ou <span><a href="#"><strong> Cadastre-se!</strong></a></span></center><br>';     
                    }
                ?>   
          </div>
      </div>

      <div class="row">
          
          <div class="col-xs-12 visible-xs-block">
                <div class="flex">
                  <span class="item-cabecalho">
                      <i class="fa fa-home" aria-hidden="true"></i>
                      <a href="#"> Home</a>
                  </span>

                  <span class="item-cabecalho">
                      <i class="fa fa-sign-in" aria-hidden="true"></i>
                      <a href="#"> Explorar </a>
                  </span>
                  
                  <span class="item-cabecalho">
                      <i class="fa fa-info-circle" aria-hidden="true"></i>
                      <a href="#"> Sobre </a>
                  </span>
                    
                    <?php
                        if(isset($_SESSION['tipo_usuario']) && !empty($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario']){
                            if($_SESSION['tipo_usuario'] == 'Administrador' || $_SESSION['tipo_usuario'] == 'Funcionario'){
                                echo '<span class="item-cabecalho">
                                      <i class="fa fa-cogs" aria-hidden="true"></i>
                                      <a href="#"> Admin </a>
                                      </span>';
                            }
                        }                             
                    ?>
                </div>
                
          </div>
          

          <div class="col-md-1 hidden-xs"></div>
          <div class="col-md-6 col-sm-8 hidden-xs">
              <div class="flex">
                  <span class="item-cabecalho">
                      <i class="fa fa-home" aria-hidden="true"></i>
                      <a href="#"> Home</a>
                  </span>

                  <span class="item-cabecalho">
                      <i class="fa fa-sign-in" aria-hidden="true"></i>
                      <a href="#"> Explorar </a>
                  </span>
                  
                  <span class="item-cabecalho">
                      <i class="fa fa-info-circle" aria-hidden="true"></i>
                      <a href="#"> Sobre </a>
                  </span>

                  <?php
                        if(isset($_SESSION['tipo_usuario']) && !empty($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario']){
                            if($_SESSION['tipo_usuario'] == 'Administrador' || $_SESSION['tipo_usuario'] == 'Funcionario'){
                                echo '<span class="item-cabecalho">
                                      <i class="fa fa-cogs" aria-hidden="true"></i>
                                      <a href="#">Painel Administrativo </a>
                                      </span>';
                            }
                        }
                  ?>

                </div>
          </div>
          <div class="col-sm-0 col-md-2 hidden-xs"></div>
          <div class="col-sm-4 col-md-3 hidden-xs">
                <?php
                    if(isset($_SESSION['nome']) && !empty($_SESSION['nome'])){
                        echo '<span style="float:right"><b>Olá, '.$_SESSION['nome'].'!</b></span>';
                    }else{
                       echo '<center><span><a href="#"><strong>Fazer Login</strong></a></span> ou <span><a href="#"><strong> Cadastre-se!</strong></a></span></center>';     
                    }
                ?> 
                
          	</div>
      		</div>
      		<hr>
  		</div>

  		<!--FIM CABEÇALHO-->

    	<!--Divisão responsavel pelo panel rotativo-->	
    	<div class="slider">
    	<!--<div class="slider fullscreen">-->
    		<!--ul responsvel por receber a lista de imagens do painel-->
    		<ul class="slides">
      			
    		</ul>
  		</div>

  		<!-- Codigo responsavel por inserir  dinamicamente as imagens e os textos das noticias-->
  		<?php
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
        ?> 

        <!--RODAPPE-->
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

		<!--FIM RODAPE-->

		<script type="text/javascript">
	 		//Inicializa o "slide" das noticias
	 		$(document).ready(function(){
	 			//full_Width: true indica que as imagens devem ocupar toda a largura da tela
      			$('.slider').slider({full_width: true});
    		});
		</script>
    </body>
</html>