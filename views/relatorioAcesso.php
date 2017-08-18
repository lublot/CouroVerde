
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <!--Codificação dos caracteres: UTF-8-->
    <meta charset="utf-8" />
    <!--Descrição da página: Sertour-->
    <meta name="description" content="Setour" />
    <!--Regulando a visão da tela para a largura relativa à tela utilizada-->
    <meta name=viewport content="width=device-width, initial-scale=1" />

    <title>Cadastro de obras</title>

    <link rel="stylesheet" href="assets/css/datepicker.css" />

    <!--Importação do Javascript pessoal e jQuery  -->
    <script src="assets/js/bootstrap-datepicker.js"></script>
    <script>
        $(function() {
            $('.datepicker').datepicker({
                format: 'dd/mm/yyy',
            });
        });
    </script>
    <?php $this->carregarDependencias();?>
    
</head>

<body style="background-color: rgb(241, 242, 246);">
    <?php $this->carregarCabecalho();?>    
    <div class="container">

        <!-- Painel -->
        <div class="col-md-3 col-lg-3">
            <?php $this->carregarPainel();?>    
        </div>

        <div class="col-md-9 col-lg-9">
            <!--Título da caixa-->
            <div id="titulo">
                <h4 class="text-center">Relatório de Acesso</h4>
            </div>
            <!--Fim do título da caixa-->

            <!--Div com o contorno e organização dos elementos no centro-->
            <div id="contorno">
            <?php
                use \controllers\relatorioAcessoController as RelatorioAcessoController;  

                $relatorioAcessoController = new RelatorioAcessoController();
                $relatorioAcessoController->gerarRelatorioAcesso();
            ?>
            <embed src="../media/relatorioacesso/relatorioAcesso.pdf" type="application/pdf"  height="600px" width="100%">
            </div>
            <!--Fim da div contorno-->

        </div>

    </div>
    <?php $this->carregarRodape();?>    
</body>
    <script src="../views/assets/js/cadObras-script.js"></script>    

</html>