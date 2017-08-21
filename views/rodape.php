<footer class="footer-distributed">

      <div class="footer-left">

        <h3>Sertour</h3>

        <p class="footer-company-name">MItologic Software® &copy; 2017</p>
      </div>

      <div class="footer-center">

        <p class="footer-links">
          <a href="<?php echo ROOT_URL.'home'?>">Home</a>
          <a href="<?php echo ROOT_URL.'galeria'?>">Galeria</a>
          <a href="<?php echo ROOT_URL.'sobre'?>">Sobre</a>
        <?php
            use \DAO\pesquisaDAO as PesquisaDAO;                                                
            use \DAO\respostaDAO as RespostaDAO;  
            if(isset($_SESSION['id'])) {
              $pesquisaDAO = new PesquisaDAO();
              $pesquisaAtiva = $pesquisaDAO->buscar(array(), array('estaAtiva' => true));
              
              if(count($pesquisaAtiva) == 1) {
                  $pesquisaAtiva = $pesquisaAtiva[0];

                  $respostaDAO = new RespostaDAO();
                  
                  if(!$respostaDAO->usuarioRespondeu($_SESSION['id'], $pesquisaAtiva->getIdPesquisa())) {
                      echo '<br><a href="'.ROOT_URL.'pesquisa/responder" >Pesquisa de Satisfação</a>';
                  }

              }

            }
        ?>
          
        </p>

      </div>

      <div class="footer-right">

        <div class="footer-icons">
          <p style="text-align: center;">
          <a href="#"><i class="fa fa-twitter"></i></a>
          <a href="#"><i class="fa fa-facebook"></i></a>
          <a href="#"><i class="fa fa-google-plus"></i></a>
          </p>

        </div>


      </div>

</footer>