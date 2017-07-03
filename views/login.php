<!DOCTYPE html>
<html lang="pt-BR">
  <head>

    <!-- Configurações de página -->
    <meta charset="utf-8" />
    <meta name="description" content="Setour" />
    <meta name=viewport  content="width=device-width, initial-scale=1 user-scalable=no" />

    <!-- Título da página -->
    <title>Sertour</title>

    <!-- Importação dos estilos CSS -->
    <link rel="stylesheet" type ="text/css" href=<?php $this->path('assets/css/bootstrap.css')?>>
    <link rel="stylesheet" type ="text/css" href=<?php $this->path('assets/css/bootstrap-theme.css')?>>
    <link rel="stylesheet" type ="text/css" href=<?php $this->path('assets/css/estilo.css')?>>
    <link rel="stylesheet" type ="text/css" href=<?php $this->path('assets/css/topo.css')?>>
    <link rel="stylesheet" type ="text/css" href=<?php $this->path('assets/css/bootstrap-social.css')?>>
<<<<<<< HEAD
    <link rel="stylesheet" type ="text/css" href=<?php $this->path('assets/css/site.mim.css')?>>
    <link rel="stylesheet" type ="text/css" href=<?php $this->path('assets/css/bootstrap.min.css')?>>

    <!-- Importação do javascript -->
=======
    <link rel="stylesheet" type ="text/css" href=<?php $this->path('assets/css/site.css')?>>
    <link rel="stylesheet" type ="text/css" href=<?php $this->path('assets/css/site.min.css')?>>
>>>>>>> 174ec95771076c413b32720a9ece369d2e3bfd9e
    <script type ="text/javascript" src=<?php $this->path('assets/js/jquery-3.2.1.min.js')?>></script>
    <script type="text/javascript" src=<?php $this->path('assets/js/bootstrap.js');?>></script>
    <script type="text/javascript" src=<?php $this->path('assets/js/login-script.js');?>></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">



  </head>
  <body>

<<<<<<< HEAD
    <!-- Importação do cabecalho -->
    <?php $this->carregarCabecalho()?>

    <!-- Container principal -->
=======
>>>>>>> 174ec95771076c413b32720a9ece369d2e3bfd9e
    <div id="container">

      <!-- Logo da pág 140x140 px -->
      <img src=<?php $this->path('assets/images/logo.jpg')?>  class="img-rounded" id="logo">

      <!-- Caixa de login -->
      <section id="caixa-login">

        <!-- Título na caixa -->
          <h4 class="text-center">Login</h4>

<<<<<<< HEAD
          <!-- Formulário de login -->
            <form class="form-horizontal " id="formLogin" method="POST" action=<?php $this->paginaAtual()?>>

              <!-- Entrada de e-mail -->
=======
            <form class="form-horizontal " id="formLogin" method="POST">
>>>>>>> 174ec95771076c413b32720a9ece369d2e3bfd9e
                <div class="form-group col-xs-12.3">
                    <input type="email" class="form-control" name="email" placeholder="Email">
                </div>

                <!-- Entrada da senha -->
                <div class="form-group col-xs-12.3">
                    <input type="password" class="form-control" name="senha" placeholder="Senha">
                </div>

                <!-- Botão de entrar -->
                <div class="form-group">
                  <div class="col-sm-offset-4 col-sm-5">
                    <button type="submit" class="btn btn-default btn-md center">Entrar</button>
                  </div>
                </div>
<<<<<<< HEAD

=======
                <h6 class="text-center text-danger">
                  <?php 
                  if(isset($this->dados) && !empty($this->dados)){
                    if(isset($this->dados['exception']) && !empty($this->dados['exception'])){
                      echo $this->dados['exception'];
                    }
                  }?>
                </h6>
>>>>>>> 174ec95771076c413b32720a9ece369d2e3bfd9e
          </form>
          <!-- /Formulário de login -->

          <!-- Link para cadastro -->
          <a href="mailto:#"> <h5 class="text-center">Cadastre-se <br/> </h5></a>

          <!-- Link para redefinição de senha -->
          <a href="mailto:#"> <h5 class="text-center" style="padding-bottom: 15px;"> Esqueci a minha senha</h5></a>

          <!-- Login por redes sociais -->
          <h6 class="text-center">Outras opções de Login</h6>

          <!-- Div com botões para login com rede social -->
          <div class="center" style="margin: 0 auto; width:43%">

<<<<<<< HEAD
            <!-- Login com facebook -->
              <a class="btn btn-social-icon btn-lg btn-facebook ">
             <Span class = "fa fa-facebook"> </ span>
              </a>
=======
          <a class="btn btn-social-icon btn-lg btn-facebook " id='btn-facebook'>
         <span class = "fa fa-facebook"> </span>
          </a>
>>>>>>> 174ec95771076c413b32720a9ece369d2e3bfd9e

              <!-- Imagem que separa os botões -->
              <img src=<?php $this->path('assets/images/divisor.jpg')?>>

<<<<<<< HEAD
              <!-- Login com Google plu -->
              <a class="btn btn-social-icon btn-lg btn-google-plus ">
             <Span class = "fa fa-google-plus"> </ span>
              </a>
=======
          <a class="btn btn-social-icon btn-lg btn-google-plus " href=<?php echo "http://".$_SERVER["HTTP_HOST"].$_SERVER['REQUEST_URI'].'/acessoGoogle';?>>
         <span class = "fa fa-google-plus"> </span>
>>>>>>> 174ec95771076c413b32720a9ece369d2e3bfd9e

        </div>
        <!-- /Div com botões para login com rede social -->

      </section>
      <!-- /Caixa de login -->

    </div>
    <!-- /Container principal -->

    <!-- Carrega rodapé -->
    <?php $this->carregarRodape()?>
    
  </body>
</html>
