<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8" />
    <meta name="description" content="Setour" />
    <meta name=viewport  content="width=device-width, initial-scale=1" />

    <title>Sertour</title>

    <link rel="stylesheet" type ="text/css" href=<?php $this->path('assets/css/bootstrap.css')?>>
    <link rel="stylesheet" type ="text/css" href=<?php $this->path('assets/css/bootstrap-theme.css')?>>
    <link rel="stylesheet" type ="text/css" href=<?php $this->path('assets/css/estilo.css')?>>
    <link rel="stylesheet" type ="text/css" href=<?php $this->path('assets/css/topo.css')?>>
    <link rel="stylesheet" type ="text/css" href=<?php $this->path('assets/css/bootstrap-social.css')?>>
    <link rel="stylesheet" type ="text/css" href=<?php $this->path('assets/css/site.css')?>>
    <link rel="stylesheet" type ="text/css" href=<?php $this->path('assets/css/site.min.css')?>>
    <script type ="text/javascript" src=<?php $this->path('assets/js/jquery-3.2.1.min.js')?>></script>
    <script type="text/javascript" src=<?php $this->path('assets/js/bootstrap.js');?>></script>
    <script type="text/javascript" src=<?php $this->path('assets/js/login-script.js');?>></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    


  </head>
  <body>

    <div id="container">
      
      <img src=<?php $this->path('assets/images/logo.jpg')?>  class="img-rounded" id="logo">
          <section id="caixa-login">
              <h4 class="text-center">Login</h4>

                <form class="form-horizontal " id="formLogin" method="POST">
                    <div class="form-group col-xs-12.3">
                        <input type="email" class="form-control" name="email" placeholder="Email">
                    </div>

                    <div class="form-group col-xs-12.3">
                        <input type="password" class="form-control" name="senha" placeholder="Senha">
                    </div>

                    <div class="form-group">
                      <div class="col-sm-offset-4 col-sm-5">
                        <button type="submit" class="btn btn-default btn-md center">Entrar</button>
                      </div>
                    </div>
                    <h6 class="text-center text-danger">
                      <?php 
                      if(isset($this->dados) && !empty($this->dados)){
                        if(isset($this->dados['exception']) && !empty($this->dados['exception'])){
                          echo $this->dados['exception'];
                        }
                      }?>
                    </h6>
              </form>

              <a href=<?php echo ROOT_URL.'cadastro'?>> <h5 class="text-center">Cadastre-se <br/> </h5></a>
              <a href= <?php echo ROOT_URL.'login/recuperar'?>> <h5 class="text-center" style="padding-bottom: 15px;"> Esqueci a minha senha</h5></a>
              <h6 class="text-center">Outras opções de Login</h6>

              <div class="center" style="margin: 0 auto; width:43%">

                <a class="btn btn-social-icon btn-lg btn-facebook " id='btn-facebook'>
                  <span class = "fa fa-facebook"> </span>
                </a>

                <img src=<?php $this->path('assets/images/divisor.jpg')?>>

                <a class="btn btn-social-icon btn-lg btn-google-plus " href=<?php echo "http://".$_SERVER["HTTP_HOST"].$_SERVER['REQUEST_URI'].'/acessoGoogle';?>>
                  <span class = "fa fa-google-plus"> </span>
                </a>

              </div>
        </section>

    </div>
    <?php $this->carregarRodape()?>
    <!-- Footer -->
    <!--<footer class="footer-distributed">

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

    </footer>-->
    <!-- /Footer -->


    
  </body>
</html>
