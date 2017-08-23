<?php if(!isset($_SESSION)){
        session_start();
      } 
?>
<script src=<?php $this->path('assets/js/cabecalho-script.js')?>></script>
<div class="container-fluid" style="background: #ffcc80;margin-bottom:5vh"> <!-- rgb(249,161,31) -->
    <div class="row">
        <div class="col-md-1 col-sm-1">
            
        </div>
        <div class="col-xs-12 col-md-9">
            <img src=<?php $this->path('assets/images/logo-header.png')?>  class="img-responsive" id="header-logo" style="width: 400px" style="height: 61; margin-top:10;">
        </div>
        <div class="col-md-2">
            <div class="form-search search-only">
                <i class="search-icon glyphicon glyphicon-search"></i>
                <input style="margin-top: 10%;" id="busca" type="text" class="form-control search-query">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 visible-xs-block" >
            <?php
                if(isset($_SESSION['nome']) && !empty($_SESSION['nome'])){
                    echo '<span style="float:right;cursor:pointer" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <b>Olá, '.$_SESSION['nome'].'! <span class="caret"></span></b>
                            </span>
                            <br>
                            <br>';
                    echo '<ul class="dropdown-menu pull-right">
                            <li><a href="'.ROOT_URL.'perfil">Gerenciar Conta</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="'.ROOT_URL.'login/logout">Sair</a></li>
                            </ul>';
                }else{
                    echo '<center><span><a href="'.ROOT_URL.'login"><strong>Fazer Login</strong></a></span> ou <span><a href="'.ROOT_URL.'cadastro"><strong> Cadastre-se!</strong></a></span></center><br>';     
                }
            ?>   
        </div>
    </div>

    <div class="row">      
        <div class="col-xs-12 visible-xs-block">
            <div class="flex">
                <span class="item-cabecalho">
                    <div class="icone-home"></div>
                    <a href=<?php echo ROOT_URL?>> Home</a>
                </span>

                <span class="item-cabecalho">
                    <div class="icone-galeria"></div>
                    <a href="<?php echo ROOT_URL.'galeria'?>"> Galeria </a>
                </span>
                  
                <span class="item-cabecalho">
                    <div class="icone-sobre"></div>
                    <a href="<?php echo ROOT_URL.'sobre'?>"> Sobre </a>
                </span>
                
                <?php
                    if(isset($_SESSION['tipoUsuario']) && !empty($_SESSION['tipoUsuario']) && $_SESSION['tipoUsuario']){
                        if($_SESSION['tipoUsuario'] == 'ADMINISTRADOR' || $_SESSION['tipoUsuario'] == 'FUNCIONARIO'){
                            echo '<span class="item-cabecalho">
                                    <i class="fa fa-cogs" aria-hidden="true"></i>
                                    <a href="'.ROOT_URL."admin".'"> Admin </a>
                                    </span>';
                        }
                    }                             
                ?>
            </div>
        </div>

        <div class="col-md-1 hidden-xs"></div>
        
        <div class="col-md-6 col-sm-8 hidden-xs">
            <div class="flex">
                <span class="item-cabecalho">
                    <div class="icone-home"></div>
                    <a href="<?php echo ROOT_URL ?>"> Home</a>
                </span>

                <span class="item-cabecalho">
                    <div class="icone-galeria"></div>
                    <a href="<?php echo ROOT_URL.'galeria'?>"> Galeria </a>
                </span>
                
                <span class="item-cabecalho">
                    <div class="icone-sobre"></div>
                    <a href="<?php echo ROOT_URL.'sobre'?>"> Sobre </a>
                </span>

                <?php
                    if(isset($_SESSION['tipoUsuario']) && !empty($_SESSION['tipoUsuario']) && $_SESSION['tipoUsuario']){
                        if($_SESSION['tipoUsuario'] == 'ADMINISTRADOR' || $_SESSION['tipoUsuario'] == 'FUNCIONARIO'){
                            echo '<span class="item-cabecalho">
                                   <div class="icone-adm"></div>
                                    <a href="'.ROOT_URL.'admin'.'">Painel Administrativo </a>
                                    </span>';
                        }
                    }
                ?>
            </div>
        </div>
        <div class="col-md-2 hidden-xs"></div>
          <div class="col-sm-4 col-md-3 hidden-xs">
                <?php
                    if(isset($_SESSION['nome']) && !empty($_SESSION['nome'])){
                        echo '<span style="float:right;cursor:pointer" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <b>Olá, '.$_SESSION['nome'].'! <span class="caret"></span></b>
                              </span>
                                <br>
                                <br>';
                        echo '<ul class="dropdown-menu pull-right">
                                <li><a href="'.ROOT_URL.'perfil">Gerenciar Conta</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="'.ROOT_URL.'login/logout">Sair</a></li>
                              </ul>';
                    }else{
                       echo '<center><span><a href="'.ROOT_URL.'login"><strong style="color: #0277f0;">Fazer Login</strong></a></span> ou <span><a href="'.ROOT_URL.'cadastro"><strong style="color: #0277f0;"> Cadastre-se!</strong></a></span></center><br>';     
                    }
                ?> 
                
          </div>
      </div>
      
  </div>
  