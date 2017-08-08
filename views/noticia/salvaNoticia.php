<?php
    require_once("../../controllers/noticiasController.php");

    use exceptions\CampoNoticiaInvalidoException as CampoNoticiaInvalidoException;
    use exceptions\DadosCorrompidosException as DadosCorrompidosException;
    use exceptions\NoticiaNaoEncontradaException as NoticiaNaoEncontradaException;
     
    if(isset($_POST['btnCadNoticia'])){
         unset($_POST['btnCadNoticia']);
         
         $noticiaController = new noticiasController();

        try {
             $noticiaController->cadastrarNoticia();
        } catch (ErroUploadImagemException $e){
                alert($e);
        } catch (CampoNoticiaInvalidoException $u){
                alert($u);
        } catch (DadosCorrompidosException){
                alert("Os dados passados estão corrompidos. Não foi possível fazer o cadastro...");
        }

        alert("Cadastro de noticia realizado com sucesso!");

        echo "<script>history.go(-1);</script>";

    }
    else {
        echo "<script>history.go(-1);</script>";
    }
?>
