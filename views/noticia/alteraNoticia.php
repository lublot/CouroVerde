<?php
    require_once("../../controllers/noticiasController.php");

    use exceptions\CampoNoticiaInvalidoException as CampoNoticiaInvalidoException;
    use exceptions\DadosCorrompidosException as DadosCorrompidosException;
    use exceptions\ErroUploadImagemException as ErroUploadImagemException;
    use exceptions\NoticiaNaoEncontradaException as NoticiaNaoEncontradaException;
     
    if(isset($_POST['btnCadNoticia'])){
         unset($_POST['btnCadNoticia']);
         
         $noticiaController = new noticiasController();

        try {
             $noticiaController->alterarNoticia();
        } catch (ErroUploadImagemException $e){
                echo '<script>alert('.$e.');<script>';
        } catch (CampoNoticiaInvalidoException $u){
                echo '<script>alert('.$u.');<script>';
        } catch (DadosCorrompidosException $e){
                echo '<script>alert("Os dados passados estão corrompidos. Não foi possível alterar a noticia...");</script>';
        }

        echo '<script>alert("Alteração da noticia realizada com sucesso!");</script>';

        header("location:../homeAdmin.php");

    }
    else {
        header("location:../homeAdmin.php");
    }
?>
