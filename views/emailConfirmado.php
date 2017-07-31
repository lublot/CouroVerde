<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8" />

    <meta name="description" content="Sertour" />
    <meta name=viewport  content="width=device-width, initial-scale=1" />

    <title>Sertour</title>

    <?php $this->carregarDependencias();?>


  </head>
  <body>

    <h1 class="text-center">Pronto!</h1>
    <center> <img src=<?php $this->path("assets/images/emailConfirmado.png")?> align="middle" id="emailConfirmado"> </center>
    <h3 class="text-center">Seu e-mail foi verificado com sucesso!</h3>
    <h5 class="text-center">Por que você não experimenta começar por <a href=<?php echo ROOT_URL.'login'?>> aqui?</a></h5><br/>
      

    <!-- Footer -->
  </body>
  <?php $this->carregarRodape();?>
</html>