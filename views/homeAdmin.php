<html>
    <head>
        <!--Codificação dos caracteres: UTF-8-->
        <meta charset="utf-8" />
        <!--Descrição da página: Sertour-->
        <meta name="description" content="Setour" />
        <!--Regulando a visão da tela para a largura relativa à tela utilizada-->
        <meta name=viewport content="width=device-width, initial-scale=1" />

        <title>SERTOUR - Painel Administrativo</title>
        <?php $this->carregarDependencias()?>

    </head>

    <body style="background-color: rgb(241, 242, 246);">
        <?php $this->carregarCabecalho()?>
        <div class="container">
            <div class="col-xs-3">
                <?php $this->carregarPainel()?>
            </div>
            <div class="col-xs-9">
                <h2>Bem-vindo ao módulo administrativo!</h2>
                <h4>Aqui você pode gerenciar e visualizar as informações do sistema</h4>
            </div>
        </div>
        <?php $this->carregarRodape()?>
    </body>
</html>