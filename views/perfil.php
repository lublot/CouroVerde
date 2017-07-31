<html>
    <head>
        <title>Sertour</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf8">
        <?php $this->carregarDependencias()?>
        <script src=<?php $this->path("assets/js/perfil-script.js")?>></script>

    </head>

    <body>
        <?php $this->carregarCabecalho()?>
        <div class="container">
           
           <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="row">
                    <h3>Gerenciar Perfil</h3>
                </div>

                <form class="form-horizontal" id="form" method="POST">
                    
                    <div class="form-group">
                        <input type="text" id="nome" placeholder="Nome" name="nome" class="form-control" value=<?php if(isset($_SESSION['nome'])){echo $_SESSION['nome'];}?>>
                    </div>

                    <div class="form-group">
                        <input type="text" id="sobrenome" placeholder="Sobrenome" name="sobrenome" class="form-control" value=<?php if(isset($_SESSION['sobrenome'])){echo $_SESSION['sobrenome'];}?>>
                    </div>

                    <div class="form-group">
                        <input type="email" id="email" class="form-control disabled" disabled placeholder="Email" value=<?php if(isset($_SESSION['email'])){echo $_SESSION['email'];}?>>
                    </div>

                    <?php if(!isset($_SESSION['redeSocial'])){
                    
                        echo '<div class="form-group">
                                <span id="expandir" class="text-info" style="cursor:pointer"><a>Deseja alterar a senha? Clique aqui!</a></span>
                                <input type="password" id="senhaAtual" placeholder="Senha Atual" name="senhaAtual" class="form-control hidden">
                              </div>

                              <div class="form-group">
                                <input type="password" id="senhaNova" placeholder="Nova Senha" name="senhaNova" class="form-control hidden">
                              </div>';                   
                    }else{
                        echo '<input type="hidden" id="senhaAtual" name="senhaAtual" disabled class="form-control hidden">
                              <input type="hidden" id="senhaAtual" name="senhaNova" disabled class="form-control hidden">';
                    }?>
                    
                    <div class="row">
                        <button type="submit" data-toggle="modal" data-target="#confirmar" id="botaoEnviar" class="btn disabled">Concluir Alteração</button>
                    </div>
                </form>
            </div>

            <div class="col-sm-6 hidden-xs"></div>
        </div>

        <?php $this->carregarRodape()?>
    </body>
</html>