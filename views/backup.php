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
    
    <?php $this->carregarDependencias();?>
    <script src="views/assets/js/backup-script.js"></script>

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
                            <img src="views/assets/images/if_backup_383184.png"> 
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
                                                    <button onclick=window.location.href="../'.$backup->caminho.'" class="btn btn-default">
                                                        <img src="../views/assets/images/download-2-xxl.png" style="width: 30px"></img>
                                                    </button>
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
    <?php $this->carregarRodape();?>    
</body>

</html>
