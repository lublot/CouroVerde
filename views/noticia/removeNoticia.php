<?php
    require_once("../../controllers/noticiasController.php");

    use exceptions\DadosCorrompidosException as DadosCorrompidosException;
    use exceptions\NoticiaNaoEncontradaException as NoticiaNaoEncontradaException;
     
    if(isset($_POST['btnApagaNoticia'])){
         unset($_POST['btnApagaNoticia']);
         
         $noticiaController = new noticiasController();

        try {
             $noticiaController->alterarNoticia();
        } catch (NoticiaNaoEncontradaException $e){
                echo '<script>alert('.$e.');<script>';
        } catch (DadosCorrompidosException $e){
                echo '<script>alert("Os dados passados estão corrompidos. Não foi possível remover a noticia...");</script>';
        }

        echo '<script>alert("Remoção da noticia realizada com sucesso!");</script>';

        header("location:../homeAdmin.php");

    }
    else {
        header("location:../homeAdmin.php");
    }
?>
