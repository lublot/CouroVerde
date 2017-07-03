<!DOCTYPE html>
<html lang="pt-BR">
  <head>

    <!-- Configurações de página -->
    <meta charset="utf-8" />
    <meta name="description" content="Setour" />
    <meta name=viewport  content="width=device-width, initial-scale=1" />

    <!-- Título da página -->
    <title>Sertour</title>

    <!-- Importação dos estilos CSS -->
    <link rel="stylesheet" type ="text/css" href=<?php $this->path('assets/css/bootstrap.css')?>>
    <link rel="stylesheet" type ="text/css" href=<?php $this->path('assets/css/bootstrap-theme.css')?>>
    <link rel="stylesheet" type ="text/css" href=<?php $this->path('assets/css/estilo.css')?>>
    <link rel="stylesheet" type ="text/css" href=<?php $this->path('assets/css/cabecalho.css')?>>
    <link rel="stylesheet" type ="text/css" href=<?php $this->path('assets/css/bootstrap-social.css')?>>
    <link rel="stylesheet" type ="text/css" href=<?php $this->path('assets/css/site.mim.css')?>>
    <link rel="stylesheet" type ="text/css" href=<?php $this->path('assets/css/bootstrap.min.css')?>>

    <!-- Importação do javascript -->
    <script type ="text/javascript" src=<?php $this->path('assets/js/jquery-3.2.1.min.js')?>></script>
    <script type="text/javascript" src=<?php $this->path('assets/js/bootstrap.js');?>></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">



  </head>
  <body>

    <!-- Importação do cabecalho -->
    <?php $this->carregarCabecalho()?>

    <form id="identicalForm" class="form-horizontal">
        <div class="form-group">
            <label class="col-xs-3 control-label">Password</label>
            <div class="col-xs-5">
                <input type="password" class="form-control" name="password" />
            </div>
        </div>

        <div class="form-group">
            <label class="col-xs-3 control-label">Retype password</label>
            <div class="col-xs-5">
                <input type="password" class="form-control" name="confirmPassword" />
            </div>
        </div>
    </form>

    <script>
      $(document).ready(function() {
          $('#identicalForm').formValidation({
              framework: 'bootstrap',
              icon: {
                  valid: 'glyphicon glyphicon-ok',
                  invalid: 'glyphicon glyphicon-remove',
                  validating: 'glyphicon glyphicon-refresh'
              },
              fields: {
                  confirmPassword: {
                      validators: {
                          identical: {
                              field: 'password',
                              message: 'The password and its confirm are not the same'
                          }
                      }
                  }
              }
          });
      });
    </script>


    <!-- Carrega rodapé -->
    <?php $this->carregarRodape()?>

  </body>
</html>
