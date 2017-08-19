<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <!--Codificação dos caracteres: UTF-8-->
    <meta charset="utf-8" />
    <!--Descrição da página: Sertour-->
    <meta name="description" content="Setour" />
    <!--Regulando a visão da tela para a largura relativa à tela utilizada-->
    <meta name=viewport content="width=device-width, initial-scale=1" />

    <title>Gerenciamento de Obra</title>

    <link rel="stylesheet" href=<?php echo '"'.VIEW_BASE.'assets/css/datepicker.css"' ?>/>
    <!--Importação do Javascript pessoal e jQuery  -->
    <script src=<?php echo '"'.VIEW_BASE.'assets/js/bootstrap-datepicker.js"' ?>></script>
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
                <h4 class="text-center">Gerenciamento da Obra</h4>
            </div>
            <!--Fim do título da caixa-->

            <?php
                require_once 'vendor/autoload.php';                                                        
                use \models\Obra as Obra;
                use \DAO\ObraDAO as ObraDAO;
                use \models\Colecao as Colecao;
                use \controllers\obraController as ObraController;                
                
                $obraController = new ObraController();
                $colecoes = $obraController->obterColecoes();                

                if(isset($_GET['i'])) {
                    $obraDAO = new ObraDAO();
                    $obra = $obraDAO->buscar(array(), array('numeroInventario' => $_GET['i']))[0];
                }  
            ?>

            <!--Div com o contorno e organização dos elementos no centro-->
            <div id="contorno">
                    <!--Formulário de cadastro-->
                    <form id="form-obra">
                        <!--Botão de Ajuda-->
                        <a href="#" class="direita">Ajuda  <span></span></a>
                        
                        <!--Página 1: Informações da Obra-->
                        <div id="page_1">

                            <!--Título da página -->
                            <h3 class="text-center">Identificação do Objeto</h3>
                            <br>

                            <!--Section com os elementos agrupados no centro-->
                            <section id="caixa">

                                <!--Campos para o cadastro de obra-->
                                <fieldset>

                                    <!--Linha 1-->
                                    <div class="row">
                                        <!--Tamanho dos campos é definido pelo bootstrap. Cada um dos campos da linha devem ter 6 blocos de largura-->
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <!--Text: Nome do Objeto-->
                                                <?php
                                                    if(isset($_GET['i'])) {
                                                        echo '<input class="form-control" type="text" value="'.$obra->getNome().'" required="required" name="nome" placeholder="Nome do Objeto (*)">';
                                                    } else {
                                                        echo '<input class="form-control" type="text" required="required" name="nome" placeholder="Nome do Objeto (*)">';                                                        
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <!--Text: Título-->
                                                <?php
                                                    if(isset($_GET['i'])) {
                                                        echo '<input class="form-control" type="text" value="'.$obra->getTitulo().'" required="required" name="titulo" placeholder="Título (*)">';
                                                    } else {
                                                        echo '<input class="form-control" type="text" required="required" name="titulo" placeholder="Título (*)">';                                                        
                                                    }
                                                ?>                                                
                                            </div>
                                        </div>
                                    </div>

                                    <!--Linha 2-->
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <!--Text: Número do Inventário-->
                                                <?php
                                                    if(isset($_GET['i'])) {
                                                        echo '<input class="form-control" type="number" value="'.$obra->getNumInventario().'"  required="required" id="numeroInventario" name="numeroInventario" placeholder="Número do Inventário (*)">';
                                                    } else {
                                                        echo '<input class="form-control" type="number" required="required" id="numeroInventario" name="numeroInventario" placeholder="Número do Inventário (*)">';                                                        
                                                    }
                                                ?>                                                      
                                                
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <!--Select: Coleção-->
                                                <select class="form-control" required="required" id="select-colecao" name="idColecao" onchange="cadastroColecao()">
                                                    <!--A lista de opções tem que ser baixada diretamente das opções do banco de dados utilizando PHP-->
                                                    <option>Coleção (*)</option>
                                                    <?php


                                                        foreach($colecoes as $colecao) {
                                                            if(isset($_GET['i'])) {
                                                                echo "<option value='".$colecao->getId()."' selected>".$colecao->getNome()."</option>";
                                                            } else {
                                                                echo "<option value='".$colecao->getId()."'>".$colecao->getNome()."</option>";                    
                                                            }                                                            
                                                            
                                                        }
                                                    ?>
                                                    <option value="add-col" >Adicionar nova opção...</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!--Linha 3-->
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <!--Text: Origem-->
                                                <input class="form-control" type="text" name="origem" placeholder="Origem">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <!--Text: Procedência-->
                                                <?php
                                                    if(isset($_GET['i'])) {
                                                        echo '<input class="form-control" type="text" value="'.$obra->getProcedencia().'" name="procedencia" placeholder="Procedência">';
                                                    } else {
                                                        echo '<input class="form-control" type="text" name="procedencia" placeholder="Procedência">';                                                        
                                                    }
                                                ?>                                                                   
                                                
                                            </div>
                                        </div>
                                    </div>

                                    <!--Linha 4-->
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <!--Select: Classificação-->
                                                <select class="form-control" required="required" id="select-classificacao" name="idClassificacao" onchange="cadastroClassificacao()">
                                                    <!--A lista de opções tem de ser baixada do banco de dados-->
                                                    <option>Classificação (*)</option>
                                                    <?php
                                                        use \models\Classificacao as Classificacao;

                                                        $classificacoes = $obraController->obterClassificacoes();

                                                        foreach($classificacoes as $classificacao) {
                                                            if(isset($_GET['i'])) {
                                                                echo "<option value='".$classificacao->getId()."' selected>".$classificacao->getNome()."</option>";
                                                            } else {
                                                                echo "<option value='".$classificacao->getId()."'>".$classificacao->getNome()."</option>";                                                        
                                                            }
                                                        }
                                                    ?>                                                    
                                                    <option value="add-cla">Adicionar nova opção...</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <!--Text: Função-->
                                                <?php
                                                    if(isset($_GET['i'])) {
                                                        echo '<input class="form-control" type="text" value="'.$obra->getFuncao().'" name="funcao" placeholder="Função"> </div>';
                                                    } else {
                                                        echo ' <input class="form-control" type="text" name="funcao" placeholder="Função"> </div>';                                                        
                                                    }
                                                ?>                                                  
                                        </div>
                                    </div>

                                    <!--Linha 5-->
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <!--Text: Tags-->
                                            <?php
                                                    if(isset($_GET['i'])) {
                                                        echo '<input class="form-control" type="text" value="'.$obra->getPalavrasChave().'" name="tags" placeholder="Palavras-chave" align="justify">';
                                                    } else {
                                                        echo '<input class="form-control" type="text" name="tags" placeholder="Palavras-chave" align="justify">';                                                        
                                                    }
                                                ?>                                              
                                            
                                        </div>
                                    </div>
                                    <!--Linha 6-->
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <!--Textarea: Descrição-->
                                            <?php
                                                    if(isset($_GET['i'])) {
                                                        echo '<textarea class="form-control" id="fixa" rows="3" name="descricao" value="'.$obra->getDescricao().'" placeholder="Descrição"></textarea>';
                                                    } else {
                                                        echo '<textarea class="form-control" id="fixa" rows="3" name="descricao" placeholder="Descrição"></textarea>';                                                        
                                                    }
                                                ?>                                              
                                            
                                        </div>
                                    </div>

                                </fieldset>
                                <!--Fim dos campos do formulário-->

                            </section>
                            <!--Fim da seção com os campos do cadastro-->

                        </div>
                        <!-- /Página 1  -->

                        <!--Página 2: Dimensões e Características Estilísticas -->
                        <div class="page" id="page_2">

                            <!--Título do Primeiro Bloco  -->
                            <h3 class="text-center">Dimensões</h3>
                            <br>

                            <!--Seção: Dimensões  -->
                            <section id="caixa">

                                <!--Campos para cadastro da obra  -->
                                <fieldset>

                                    <!--Linha 1  -->
                                    <div class="row">
                                        <!-- Tamanho dos componentes é fixado em 4 para o alinhamento na linha  -->
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <!--Text: Altura  -->
                                                <?php
                                                    if(isset($_GET['i'])) {
                                                        echo '<input class="form-control" type="number" value="'.$obra->getAltura().'" name="altura" placeholder="Altura">';
                                                    } else {
                                                        echo '<input class="form-control" type="number" name="altura" placeholder="Altura">';                                                        
                                                    }
                                                ?>                                                  
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <!--Text: Largura  -->
                                                <?php
                                                    if(isset($_GET['i'])) {
                                                        echo '<input class="form-control" type="number" value="'.$obra->getLargura().'" name="largura" placeholder="Largura">';
                                                    } else {
                                                        echo '<input class="form-control" type="number" name="largura" placeholder="Largura">';                                                        
                                                    }
                                                ?>                                                  
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <!--Text: Diâmetro  -->
                                                <?php
                                                    if(isset($_GET['i'])) {
                                                        echo '<input class="form-control" type="number" value="'.$obra->getDiametro().'" name="diametro" placeholder="Diâmetro">';
                                                    } else {
                                                        echo '<input class="form-control" type="number" name="diametro" placeholder="Diâmetro">';                                                        
                                                    }
                                                ?>                                                  
                                            </div>
                                        </div>

                                    </div>
                                    <!--/Linha 1  -->

                                    <!--Linha 2  -->
                                    <div class="row">

                                        <!--Tem um bloco de tamanho 2 em cada lado da linha para que a linha 2, que tem 2 elementos, fique alinhada com a linha 1, que tem 3 elementos, e as duas mantenham elementos de mesmo tamanho  -->
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <!--Text: Peso -->
                                                <?php
                                                    if(isset($_GET['i'])) {
                                                        echo '<input class="form-control" type="number" value="'.$obra->getPeso().'" name="peso" placeholder="Peso">';
                                                    } else {
                                                        echo '<input class="form-control" type="number" name="peso" placeholder="Peso">';                                                        
                                                    }
                                                ?>                                                  
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <!--Text: Comprimento  -->
                                                
                                                <?php
                                                    if(isset($_GET['i'])) {
                                                        echo '<input class="form-control" type="number" value="'.$obra->getComprimento().'" name="comprimento" placeholder="Comprimento">';
                                                    } else {
                                                        echo '<input class="form-control" type="number" name="comprimento" placeholder="Comprimento">';                                                        
                                                    }
                                                ?>                                                  
                                            </div>
                                        </div>
                                        <div class="col-lg-2"></div>

                                    </div>
                                    <!--/Linha 2  -->

                                </fieldset>
                                <!-- Fim dos campos de Dimensões  -->

                            </section>
                            <!-- Fim da Seção: Dimensões -->

                            <!--Título do Segundo bloco  -->
                            <h3 class="text-center">Características Estilísticas</h3>
                            <br>

                            <!--Seção: Características Estilísticas  -->
                            <section id="caixa">

                                <!--Campos para cadastro da obra  -->
                                <fieldset>

                                    <div class="row">
                                        <!--Elementos tem o tamanho fixo 4 para o alinhamento na linha  -->
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <!--TextArea: Materiais Contitutivos  -->
                                                <?php
                                                    if(isset($_GET['i'])) {
                                                        echo '<textarea class="form-control" id="fixa" rows="3" name="materiaisContruidos" value="'.$obra->getMateriais().'"  placeholder="Materiais Constitutivos"></textarea>';
                                                    } else {
                                                        echo '<textarea class="form-control" id="fixa" rows="3" name="materiaisContruidos" placeholder="Materiais Constitutivos"></textarea>';                                                        
                                                    }
                                                ?>                                                  
                                                
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <!--TextArea: Técnicas de Fabricação -->
                                                <?php
                                                    if(isset($_GET['i'])) {
                                                        echo '<textarea class="form-control" id="fixa" rows="3" name="tecnicasFabricacao" value="'.$obra->getTecnicas().'" placeholder="Técnicas de Fabricação"></textarea>';
                                                    } else {
                                                        echo '<textarea class="form-control" id="fixa" rows="3" name="tecnicasFabricacao" placeholder="Técnicas de Fabricação"></textarea>';                                                        
                                                    }
                                                ?>                                                  
                                                
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <!--TextArea: Autoria  -->
                                                <?php
                                                    if(isset($_GET['i'])) {
                                                        echo '<textarea class="form-control" id="fixa" rows="3" name="autoria" value="'.$obra->getAutoria().'" placeholder="Autoria"></textarea>';
                                                    } else {
                                                        echo '<textarea class="form-control" id="fixa" rows="3" name="autoria" placeholder="Autoria"></textarea>';                                                        
                                                    }
                                                ?>                                                  
                                                
                                            </div>
                                        </div>

                                    </div>

                                </fieldset>
                                <!-- Fim dos campos: Características Estilísticas  -->

                            </section>
                            <!-- Fim da Seção: Características Estilísticas  -->
                        </div>
                        <!-- /Página 2  -->

                        <!--Página 3: Marcas e Inscrições e Histórico do Objeto  -->
                        <div class="page" id="page_3">

                            <h3 class="text-center">Marcas e Inscrições</h3>
                            <br>

                            <!--Seção: Marcas e Inscrições-->
                            <section id="caixa">

                                <!--Campos para cadastro da obra  -->
                                <fieldset>

                                    <div class="row">
                                        <!--Elementos tem o tamanho fixo 12 para o alinhamento na linha  -->
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <!--TextArea: Marcas e Inscrições  -->
                                                <?php
                                                    if(isset($_GET['i'])) {
                                                        echo '<textarea class="form-control" id="fixa" rows="5" value="'.$obra->getMarcas().'" name="marcasInscricoes"></textarea>';
                                                    } else {
                                                        echo '<textarea class="form-control" id="fixa" rows="5" name="marcasInscricoes"></textarea>';                                                        
                                                    }
                                                ?>                                                  
                                                
                                            </div>
                                        </div>

                                    </div>

                                </fieldset>
                                <!-- Fim dos campos: Marcas e Inscrições -->

                            </section>
                            <!-- Fim da Seção: Marcas e Inscrições -->


                            <h3 class="text-center">Histórico do Objeto</h3>
                            <br>

                            <!--Seção: Histórico do Objeto-->
                            <section id="caixa">

                                <!--Campos para cadastro da obra  -->
                                <fieldset>

                                    <div class="row">
                                        <!--Elementos tem o tamanho fixo 12 para o alinhamento na linha  -->
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <!--TextArea: Histórico do Objeto  -->
                                                <?php
                                                    if(isset($_GET['i'])) {
                                                        echo '<textarea class="form-control" id="fixa" value="'.$obra->getHistorico().'" rows="5" name="historicoObjeto"></textarea>';
                                                    } else {
                                                        echo '<textarea class="form-control" id="fixa" rows="5" name="historicoObjeto"></textarea>';                                                        
                                                    }
                                                ?>                                                  
                                                
                                            </div>
                                        </div>

                                    </div>

                                </fieldset>
                                <!-- Fim dos campos:Histórico do Objeto  -->

                            </section>
                            <!-- Fim da Seção: Histórico do Objeto  -->

                        </div>
                        <!--/Página 3  -->


                        <!--Página 4: Aquisição e Estado de Conservação -->
                        <div class="page" id="page_4">

                            <h3 class="text-center">Aquisição</h3>
                            <br>

                            <!--Seção: Aquisição -->
                            <section id="caixa">

                                <!--Campos para cadastro da obra  -->
                                <fieldset>

                                    <!--Linha 1  -->
                                    <div class="row">
                                        <!-- Tamanho dos componentes é fixado em 4 para o alinhamento na linha  -->
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <!--Text: Modo de Aquisição  -->
                                                <?php
                                                    if(isset($_GET['i'])) {
                                                        echo '<input class="form-control" type="text" value="'.$obra->getModoAquisicao().'" name="modoAquisicao" placeholder="Modo de Aquisição">';
                                                    } else {
                                                        echo '<input class="form-control" type="text" name="modoAquisicao" placeholder="Modo de Aquisição">';                                                        
                                                    }
                                                ?>                                                  
                                                
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <!--Text: Data de Aquisição"-->
                                                <?php
                                                    if(isset($_GET['i'])) {
                                                        echo '<input class="form-control datepicker" id="date" type="text" value="'.$obra->getDataAquisicao().'" name="dataAquisicao" placeholder="Data de Aquisição">';
                                                    } else {
                                                        echo '<input class="form-control datepicker" id="date" type="text" name="dataAquisicao" placeholder="Data de Aquisição">';                                                        
                                                    }
                                                ?>                                               
                                                
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <!--Text: Autor  -->
                                                <?php
                                                    if(isset($_GET['i'])) {
                                                        echo '<input class="form-control" type="text" value="'.$obra->getAutor().'" name="autor" placeholder="Autor">';
                                                    } else {
                                                        echo '<input class="form-control" type="text" name="autor" placeholder="Autor">';                                                        
                                                    }
                                                ?>                                                  
                                                
                                            </div>
                                        </div>

                                    </div>
                                    <!--/Linha 1  -->

                                    <!--Linha 2  -->
                                    <div class="row">

                                        <!--Elementos tem o tamanho fixo 12 para o alinhamento na linha  -->
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <!--TextArea: Observações  -->
                                                <?php
                                                    if(isset($_GET['i'])) {
                                                        echo '<textarea class="form-control" id="fixa" rows="3" value="'.$obra->getObservacoes().'" name="observacoes"></textarea>';
                                                    } else {
                                                        echo '<textarea class="form-control" id="fixa" rows="3" name="observacoes"></textarea>';                                                        
                                                    }
                                                ?>                                                  
                                                
                                            </div>
                                        </div>

                                    </div>
                                    <!--/Linha 2  -->

                                </fieldset>
                                <!-- Fim dos campos: Aquisição  -->

                            </section>
                            <!-- Fim da Seção: Aquisição  -->

                            <h3 class="text-center">Estado de Conservação</h3>
                            <br>

                            <!--Seção: Estado de Conservação-->
                            <section id="caixa">

                                <!--Campos para cadastro da obra  -->
                                <fieldset>

                                    <div class="row">
                                        <!--Elementos tem o tamanho fixo 4 para o alinhamento na linha  -->
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <!--TextArea: Estado de Conservação  -->
                                                <?php
                                                    if(isset($_GET['i'])) {
                                                        echo '<textarea class="form-control" id="fixa" rows="5" value="'.$obra->getEstado().'" name="estadoConservacao"></textarea>';
                                                    } else {
                                                        echo '<textarea class="form-control" id="fixa" rows="5" name="estadoConservacao"></textarea>';                                                        
                                                    }
                                                ?>                                                  
                                                
                                            </div>
                                        </div>

                                    </div>

                                </fieldset>
                                <!-- Fim dos campos: Estado de Conservação  -->

                            </section>
                            <!-- Fim da Seção: Estado de Conservação -->

                        </div>
                        <!--/Página 4  -->

                        <!--Página 5: Imagens e Modelos 3D  -->
                        <div class="page" id="page_5">

                            <h3 class="text-center"> Imagens e Modelos 3D</h3>
                            <br>

                            <section id="caixa">
                                <fieldset>
                                    <div class="row">
                                        <div class="dnd1">

                                            <div id="uploadImg" hidden>
                                                <span>Imagens carregadas:</span>
                                                <span id="img1" hidden></span>
                                                <span id="img2" hidden></span>
                                                <span id="img3" hidden></span>
                                                <span id="img4" hidden></span>
                                                <span id="img5" hidden></span>                                                
                                            </div>      

                                            <!--<input type="file" multiple="multiple" accept="image/*" style="visibility: hidden">-->
                                            <div id="dropzone_img" class="dropzone">
                                                Arraste suas imagens aqui para carregá-las
                                            </div>
                                        </div>
                                        <br>
                                        <div class="dnd1">

                                            <div id="upload3D" hidden>
                                                <span id="modelo3D"></span>
                                                <span></span>                                       
                                            </div>      

                                            <!--<input type="file" multiple="multiple" accept="image/*" style="visibility: hidden">-->
                                            <div id="dropzone_3d" class="dropzone">
                                                Arraste seus arquivos referentes ao modelo 3D  aqui se desejar carregá-los também
                                            </div>
                                            <div id="uploads_3d" class="uploads"></div>
                                        </div>
                                    </div>
                                </fieldset>
                            </section>
                        </div>
                        <!--/Página 5  -->

                        <!--Página 6: Documentação Fotográfica  -->
                        <div class="page" id="page_6">

                            <h3 class="text-center">Documentação Fotográfica</h3>
                            <br>

                            <!--Seção: Documentação Fotográfica -->
                            <section id="caixa">

                                <!--Campos para cadastro da obra  -->
                                <fieldset>

                                    <div class="row">
                                        <!-- Tamanho dos componentes é fixado em 4 para o alinhamento na linha  -->
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <!--Text: Modo de Aquisição  -->
                                                <input class="form-control" type="text" name="fotografo" placeholder="Fotógrafo">
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <!--Text: Data da Fotografia  -->
                                                <input class="form-control" type="date" name="data-da-fotografia" placeholder="Data da Fotografia">
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <!--Text: Autor  -->
                                                <input class="form-control" type="text" name="fotografia_autor" placeholder="Autor">
                                            </div>
                                        </div>

                                    </div>
                                </fieldset>
                                <!-- Fim dos campos:Documentação Fotográfica  -->

                            </section>
                            <!-- Fim da Seção: Documentação Fotográfica  -->
                        </div>
                        <!--/Página 6  -->                        
                        
                        <div class="row">
                            <div class="modal-footer" style="border-top: 0; margin-right: 15px;">
                                <div class="form-group">
                                    <a type="button" href=<?php echo "'/obra/removerObra?n=".$obra->getNumInventario()."'"?> class="btn btn-danger" id="btn-remover">Remover Obra</a>                                
                                    <button type="button" class="btn btn-default" onclick="voltarPag(); atualizarTextoBotao()" id="btn-cancelar">Cancelar</button>
                                    <button type="button" class="btn btn-primary" onclick="avancarPag(); atualizarTextoBotao()" id="btn-confirmar">Próximo</button>
                                </div>
                            </div>
                        </div>

                    </form>
                    <!--Fim do formulário-->

            </div>
            <!--Fim da div contorno-->

        </div>

    </div>
    <?php $this->carregarRodape();?>    
</body>
    <script src="../views/assets/js/gerenciarObra-script.js"></script>    

</html>