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
             $noticiaController->removerNoticia();
        } catch (ErroUploadImagemException $e){
                echo '<script>alert('.$e.');<script>';
        } catch (CampoNoticiaInvalidoException $u){
                echo '<script>alert('.$u.');<script>';
        } catch (DadosCorrompidosException $e){
                echo '<script>alert("Os dados passados estão corrompidos. Não foi possível fazer o cadastro...");</script>';
        }

        echo '<script>alert("Cadastro de noticia realizado com sucesso!");</script>';

        header("location:../painel.php");

    }
    else {
        header("location:../painel.php");
    }
?>
