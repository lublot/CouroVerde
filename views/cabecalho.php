<header class="container">
    <div class="row">
        <div class="col-sm-8">
            <h1><i class="fa fa-bars" aria-hidden="true"></i>  Sertour</h1>
        </div>
        <div class="col-sm-4">
            <button type="submit" class="btn btn-redondo">
                <h3><i class="fa fa-lock" aria-hidden="true"></i> Entrar</h3>
            </div>
            
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="menu">
                <h4 class="item">Home</h4>
                <h4 class="item">Explorar</h4>
                <h4 class="item">Sobre</h4>
                <?php 
                    if(isset($_SESSION['nome']) && !empty($_SESSION['nome'])){
                        echo '<h4 class="item">Painel Administrativo</h4>';
                    }else{
                       
                    }
                ?>
            </div>
            <div class="text-right">
                <?php 
                if(isset($_SESSION['nome']) && !empty($_SESSION['nome'])){
                  echo '<span class="text-right">Bem-vindo(a), '.$_SESSION['nome'].'</span>';
                }else{
                  echo '<span class="text-right"><a href="#">Não possui uma conta? Cadastre-se!</a></span>';  
                }
                ?>
            </div>  
        </div>
    </div>

    <hr>
</header>
