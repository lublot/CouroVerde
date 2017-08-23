<?php
namespace DAO;

require_once dirname(__DIR__).'/vendor/autoload.php';
use \models\Pesquisa as Pesquisa;
use \DAO\Database as Database;
use \exceptions\PesquisaJaExistenteException as PesquisaJaExistenteException;

class RespostaDAO extends Database{

    /**
    * Insere uma pesquisa no banco de dados;
    * @param unknown $pesquisa - a pesquisa deve ser inserida no banco;
    * */
    public function inserir($idUsuario,$idPesquisa,$idPergunta,$tipoPergunta,$resposta){
        $resposta = utf8_encode($resposta);
        
        if(strcmp($tipoPergunta,"ABERTA")==0){
            $query = "INSERT INTO respostaaberta(idUsuario, idPesquisa, idPergunta, descricao) VALUES ('$idUsuario', '$idPesquisa', '$idPergunta', '$resposta')";
            try{
                $this->PDO->query($query);
            }catch(PDOException $e){

            }
        }else if(strcmp($tipoPergunta,"MULTIPLA ESCOLHA")==0){
            foreach($resposta as $resp){
                $query = "INSERT INTO respostafechada(idUsuario, idPesquisa, idPergunta, idOpcao) VALUES ('$idUsuario', '$idPesquisa', '$idPergunta', '$resp')";
                
                try{
                    $this->PDO->query($query);
                }catch(PDOException $e){

                }
            }
        }else if(strcmp($tipoPergunta,"UNICA ESCOLHA")==0){
            $query = "INSERT INTO respostafechada(idUsuario, idPesquisa, idPergunta, idOpcao) VALUES ('$idUsuario', '$idPesquisa', '$idPergunta', '$resposta')";
            try{
                $this->PDO->query($query);
            }catch(PDOException $e){

            }
        }       
        
    }

    public function buscarRespostaAberta($campos, $filtros){
        $query = "SELECT ";

        if(count($campos) == 0){
            $campos = array("*");
        }

        $query .= implode(',',$campos)." FROM respostaaberta INNER JOIN pergunta ON respostaaberta.idPergunta = pergunta.idPergunta";

        if(count($filtros) > 0){
            $query .= " WHERE ";
            $aux = array();

            foreach($filtros as $chave=>$valor){
                $aux[] = 'respostaaberta.'.$chave."="."'$valor'";
            }
            
            $query .= implode(" AND ",$aux);
        }
       
        $result = $this->PDO->query($query);

        $pesquisas = array();
        if(!empty($result) && $result->rowCount() > 0){
            foreach($result->fetchAll() as $item){
                $pesquisa = array();
                $pesquisa['idPergunta'] = isset($item['idPergunta'])?$item['idPergunta']:null;
                $pesquisa['tituloPergunta'] = isset($item['titulo'])?utf8_encode($item['titulo']):null;
                $pesquisa['opcional'] = isset($item['opcional'])?$item['opcional']:null;
                $pesquisa['tipoPergunta'] = isset($item['tipo'])?$item['tipo']:null;
                $pesquisa['resposta'] = isset($item['descricao'])?utf8_encode($item['descricao']):null;
  
                array_push($pesquisas,$pesquisa);              
            }    
        } 

        return $pesquisas;
    }

    public function buscarRespostaFechada($idPesquisa){
        $query = "SELECT COUNT(RespostaFechada.idOpcao),RespostaFechada.idPergunta,RespostaFechada.idOpcao,Pergunta.titulo,Pergunta.opcional,Pergunta.tipo,Opcao.descricao FROM (RespostaFechada INNER JOIN Pergunta ON Pergunta.idPergunta = RespostaFechada.idPergunta) INNER JOIN Opcao ON Opcao.idOpcao = RespostaFechada.idOpcao WHERE RespostaFechada.idPergunta in (SELECT idPergunta FROM PerguntaPesquisa WHERE idPesquisa = '$idPesquisa') GROUP BY RespostaFechada.idPergunta,RespostaFechada.idOpcao;";
        $result = $this->PDO->query($query);
        $respostas = array();
        if(!empty($result) && $result->rowCount() > 0){
            foreach($result->fetchAll() as $item){
                $resposta = array();
                
                $resposta['idPergunta'] = isset($item['idPergunta'])?$item['idPergunta']:null;
                $resposta['tituloPergunta'] = isset($item['titulo'])?utf8_encode($item['titulo']):null;
                $resposta['opcional'] = isset($item['opcional'])?$item['opcional']:null;
                $resposta['tipoPergunta'] = isset($item['tipo'])?$item['tipo']:null;
                $resposta['idOpcao'] = isset($item['idOpcao'])?$item['idOpcao']:null;
                $resposta['resposta'] = isset($item['descricao'])?utf8_encode($item['descricao']):null;
                $resposta['qtdRespostas'] = isset($item['COUNT(RespostaFechada.idOpcao)'])?$item['COUNT(RespostaFechada.idOpcao)']:null;
                array_push($respostas,$resposta);              
            }    
        } 
        return $respostas;
    }

    //Verifica se um usuário já respondeu uma pesquisa
    public function usuarioRespondeu($idUsuario,$idPesquisa){
        $query = "SELECT * FROM respostaAberta WHERE idUsuario = '$idUsuario' && idPesquisa = '$idPesquisa'";
        $result = $this->PDO->query($query);
        
        if(!empty($result) && $result->rowCount()>0){ // Verifica se o usuário respondeu alguma pergunta aberta
            return true;
        }

        $query = "SELECT * FROM respostaFechada WHERE idUsuario = '$idUsuario' && idPesquisa = '$idPesquisa'";
        $result = $this->PDO->query($query);
        
        if(!empty($result) && $result->rowCount()>0){ // Verifica se o usuário respondeu alguma pergunta fechada
            return true;
        }

        return false;
    }
     
}

?>