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
    <?php $this->carregarDependencias()?>

  </head>

  <body>

    <!-- Container principal -->
    <div id="container" class="container">
      
      <?php $this->carregarCabecalho()?>
          
      <!-- Formulário de senha -->
      <form data-toggle="validator" role="form" class="form-horizontal" method="POST">

        <!-- Entrada de senha -->
          <div class="form-group">
              <label class="col-xs-2 control-label" style="margin-right:-16px;">Senha:</label>
              <div class="col-xs-2">
                  <input type="password" data-minlength="8" data-maxlength="32" name="senha" class="form-control" id="inputPassword" required />
                  <div class="help-block">Mínimo 8 caracteres</div>
              </div>
          </div>

        <!-- Entrada de confirmação de senha -->
          <div class="form-group">
              <label class="col-xs-2 control-label " style="margin-right:-16px;">Repetir a senha:</label>
              <div class="col-xs-2">
                  <input type="password" class="form-control" name="confirmarSenha" id="inputPasswordConfirm" data-match="#inputPassword" data-match-error="Senhas não correspondem" required/>
                  <div class="help-block with-errors"></div>
              </div><br>
              <span><?php 
                  if(isset($this->dados['exception'])){echo $this->dados['exception'];}
                  if(isset($this->dados['redefinido'])){echo $this->dados['redefinido'];}
                ?></span>
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
