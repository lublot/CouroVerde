<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <!--Codificação dos caracteres: UTF-8-->
    <meta charset="utf-8" />
    <!--Descrição da página: Sertour-->
    <meta name="description" content="Setour" />
    <!--Regulando a visão da tela para a largura relativa à tela utilizada-->
    <meta name=viewport content="width=device-width, initial-scale=1" />

    <title>Backup</title>

    <!--Importação do CSS do Bootstrap, Bootflat e o pessoal (Estilos)-->
    <link rel="stylesheet" href="assets/css/bootstrap.css" />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/bootstrap-theme.css" />
    <link rel="stylesheet" href="assets/css/estilo.css" />
    <link rel="stylesheet" href="assets/css/bootstrap-social.css" />
    <link rel="stylesheet" href="assets/css/site.css" />
    <link rel="stylesheet" href="assets/css/site.min.css" />

    <!--Importação do Javascript pessoal e jQuery  -->
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/backup-script.js"></script>
    

    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>



</head>

<body style="background-color: rgb(241, 242, 246);">

    <div class="container">
         <!-- Painel -->
        <div class="col-md-3 col-lg-3"></div>

        <div class="col-md-9 col-lg-9">

            <!--Título da caixa-->
            <div id="titulo">
                <h4 class="text-center">Backup</h4>
            </div>
            <!--Fim do título da caixa-->

            <!-- Contorno -->
            <div id="contorno">

                <!-- Caixa interna -->
                <section id="caixa">

                    <!-- Backup manual -->
                    <p> Deseja fazer backup agora?
                        <!-- Botão de backup manual -->
                        <button type="button" target="_new" id="btn-backup" class="btn btn-default btn-sm">
                            <img src="assets/images/if_backup_383184.png"> 
                        </button>

                    <!-- /FIM de botão de backup manual -->
                    </button>

                        <!-- /FIM de Backup manual -->
                    </p>


                    <!-- Div onde fica localizada as caixas inferiores de histórico e backup automático -->
                    <div class="row" style="margin-top: 10vh">


                        <!-- Título da div -->
                        <div class="caixa-backup-titulo">
                            <h6>
                                Histórico de Backup
                            </h6>
                        </div>

                        <!-- Lista de históicos -->
                        <div class="table-responsive">
                            <table class="table historico-backup table-condensed">
                                <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Hora</th>
                                    <th>Download</th>
                                </tr>
                                </thead>
                                    <tbody>                                    
                                        <?php
                                            require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';
                                            use \controllers\backupController as BackupController;
                                            
                                            $backupController = new BackupController();
                                            $backups = json_decode($backupController->listarTodosBackups());

                                            foreach($backups as $backup) {
                                                echo '<tr>';
                                                echo '<td>';
                                                echo '<p>' . implode('/', array_reverse(explode('-', $backup->dia))) . '</p>';
                                                echo '</td>';    
                                                echo '<td>';
                                                echo '<p>' . $backup->hora . '</p>';
                                                echo '</td>';     
                                                echo '<td>
                                                    <button class="glyphicon glyphicon-cloud-download" onclick=window.location.href="../'.$backup->caminho.'" class="btn btn-default"></button>
                                                    </td>';    
                                                echo '</tr>';                                                                                                            
                                            }
                                        ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- / Div onde fica localizada as caixas inferiores de histórico e backup automático -->
                    </div>



                    <!-- /FIM da Caixa interna -->
                </section>

                <!-- FIM do Contorno -->
            </div>

        </div>

    </div>



    <!-- pop up -->
    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog" style="width:60vh;">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body" style="padding:40px 50px;" align="center">
                    <p class="text-center">Você tem certeza que deseja restaurar os dados para o backup de "DATA"?</p>
                    <p class="text-center">Todos os dados obtidos em datas posteriores serão perdidos.</p>
                    <button class="btn btn-default" data-toggle="modal" data-target="#confSenha" data-dismiss="modal" aria-hidden="true">Sim</button>
                    <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Não</button>

                </div>
            </div>

        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="confSenha" role="dialog">
        <div class="modal-dialog modal-sm">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body" style="padding:40px 50px;">
                    <form role="form" data-toggle="validator">
                        <div class="form-group">
                            <div>
                                <label for="psw"> Senha:</label>
                                <input type="password" class="form-control" id="psw" for="inputsm" placeholder="Digite a senha" required>
                            </div>
                            <button type="submit" class="btn btn-success " style="margin-top: 2vh;" onclick="Nova(event)"> Fazer restauração</button>
                    </form>
                    </div>
                </div>

            </div>
        </div>

</body>

<script type="text/javascript">
    function Nova(event) {
        event.preventDefault();
        console.log("entrou");
        window.location.replace("backupAndamento.html");
    }


    /*
        function Nova(event) {
            event.preventDefault();
            console.log("entrou");
            return "backupAndamento.html";
            
        }*/
</script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.5.4/bootstrap-select.js" />

</html>

</html>