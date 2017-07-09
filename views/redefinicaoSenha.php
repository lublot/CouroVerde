<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <!-- Configurações de tela -->
    <meta charset="utf-8" />
    <meta name="description" content="Sertour" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Título -->
    <title>Sertour</title>

    <!-- Importação de estilo -->
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

    <!-- Container principal -->
    <div id="container">
      
      <?php $this->carregarCabecalho()?>
          
      <!-- Formulário de senha -->
      <form data-toggle="validator" role="form" class="form-horizontal">

        <!-- Entrada de senha -->
          <div class="form-group">
              <label class="col-xs-2 control-label" style="margin-right:-16px;">Senha:</label>
              <div class="col-xs-2">
                  <input type="password" data-minlength="8" class="form-control" id="inputPassword" required />
                  <div class="help-block">Mínimo 8 caracteres</div>
              </div>
          </div>

        <!-- Entrada de confirmação de senha -->
          <div class="form-group">
              <label class="col-xs-2 control-label " style="margin-right:-16px;">Repetir a senha:</label>
              <div class="col-xs-2">
                  <input type="password" class="form-control" id="inputPasswordConfirm" data-match="#inputPassword" data-match-error="Senhas não correspondem" required/>
                  <div class="help-block with-errors"></div>
              </div>
          </div>

          <!-- Botão de enviar -->
          <div class="form-group">
            <div class="col-xs-offset-2 col-xs-1">
              <button type="submit" class="btn btn-default btn-md center testar">Enviar</button>
            </div>
          </div>
      </form>
      <!-- /Formulário de senha -->
      
    </div>
    <!-- /Container principal -->
     <?php $this->carregarRodape()?>

  </body>
</html>
