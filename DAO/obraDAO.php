<?php
namespace DAO;

require_once dirname(__DIR__).'/vendor/autoload.php';
use \DAO\Database as Database;
use \models\Obra as Obra;

class ObraDAO {

    /**
    * Insere uma obra no banco de dados;
    * @param unknown $obra - a obra a ser inserida no banco;
    * */
    public function inserirObra($obra){
        
        $nome = $obra->getNome();
        $titulo = $obra->getTitulo();
        $numInventario = $obra->getNumInventario();
        $idColecao = $obra->getIdColecao();
        $origem = $obra->getOrigem();
        $procedencia = $obra->getProcedencia();
        $idClassificacao = $obra->getIdClassificacao();
        $funcao = $obra->getFuncao();
        $palavrasChave = $obra->getPalavrasChave();
        $descricao = $obra->getDescricao();
        $altura = $obra->getAltura();
        $largura = $obra->getLargura();
        $diametro = $obra->getDiametro();
        $peso = $obra->getPeso();
        $comprimento = $obra->getComprimento();
        $materiais = $obra->getMateriais();
        $tecnicas = $obra->getTecnicas();
        $autoria = $obra->getAutoria();
        $marcas = $obra->getMarcas();
        $historico = $obra->getHistorico();
        $modoAquisicao = $obra->getModoAquisicao();
        $dataAquisicao = $obra->getDataAquisicao();
        $autor = $obra->getAutor();
        $observacoes = $obra->getObservacoes();
        $estado = $obra->getEstado();
        $caminhoImagem1 = $obra->getCaminhoImagem1();
        $caminhoImagem2 = $obra->getCaminhoImagem2();
        $caminhoImagem3 = $obra->getCaminhoImagem3();
        $caminhoImagem4 = $obra->getCaminhoImagem4();
        $caminhoImagem5 = $obra->getCaminhoImagem5();
        $caminhoModelo3D = $obra->getCaminhoModelo3D();

        $query = "INSERT INTO obra(idObra, nome, titulo, numInventario, idColecao, origem, procedencia, idClassificacao,
                                    funcao, palavrasChave, descricao, altura, largura, diametro, peso, comprimento, materiais,
                                    tecnicas, autoria, marcas, historico, modoAquisicao, dataAquisicao, autor, observacoes,
                                    estado, caminhoImagem1, caminhoImagem2, caminhoImagem3, caminhoImagem4, caminhoImagem5, caminhoModelo3D) 
                  VALUES (null,'$nome','$titulo','$numInventario', '$idColecao', '$origem', '$procedencia', '$idClassificacao',
                            '$funcao', '$palavrasChave', , '$descricao', '$altura', '$largura', '$diametro', '$peso', '$comprimento', '$materiais',
                            '$tecnicas', '$autoria', '$marcas', '$historico', '$modoAquisicao', '$dataAquisicao', '$autor', '$observacoes', 
                            '$estado', '$caminhoImagem1', '$caminhoImagem2', '$caminhoImagem3', '$caminhoImagem4', '$caminhoImagem5', '$caminhoModelo3D')";
        try{
            $this->PDO->query($query);
        }catch(PDOException $e){

        }
    }

    /**
    * Altera informações de uma obra no banco de dados;
    * @param unknown $dados - um array contendo as colunas e valores para a alteração. Ex: array("nomeObra"=>"Couro");
    * @param unknown $filtros - um array contendo os filtros usados na busca. Ex: array("idObra"=>5);
    * */
    public function alterar($dados,$filtros){
        $query = "UPDATE obra SET ";

        foreach($dados as $chave=>$valor){
            $query .= $chave.'='."'$valor',";
        }

        $query = substr($query, 0, -1);

        if(count($filtros) > 0){
            $query .= " WHERE ";
            $aux = array();

            foreach($filtros as $chave=>$valor){
                $aux[] = $chave." = "."'$valor'";
            }

            $query .= implode(" AND ",$aux);
        }

        
        $this->PDO->query($query);

    }

    /**
    * Remove uma obra do banco de dados;
    * @param unknown $filtros - um array contendo os filtros usados na identificação do usuário. Ex: array("idObra"=>5);
    * */
    public function remover($filtros){
        $query = "DELETE FROM usuario WHERE ";

        if(count($filtros) > 0){
            $aux = array();

            foreach($filtros as $chave=>$valor){
                $aux[] = $chave." = "."'$valor'";
            }

            $query .= implode(" AND ",$aux);
        }

        $this->PDO->query($query);
    }

    /**
    * Busca uma ou várias obras no banco de dados;
    * @param unknown $campos - um array contendo os campos desejados
    * @param unknown $filtros - um array contendo os filtros usados na busca. Ex: array("idUsuario"=>5);
    * @return unknown $usuarios - um array contendo os usuários retornados na busca
    */
    public function buscar($campos,$filtros){
        $query = "SELECT ";

        if(count($campos) == 0){
            $campos = array("*");
        }

        $query .= implode(',',$campos)."FROM obra";

        if(count($filtros) > 0){
            $query .= " WHERE ";
            $aux = array();

            foreach($filtros as $chave=>$valor){
                $aux[] = $chave."="."'$valor'";
            }
            
            $query .= implode(" AND ",$aux);
        }

        $result = $this->PDO->query($query);

        $usuarios = array();
        if(!empty($result) && $result->rowCount() > 0){
            foreach($result->fetchAll() as $item){
               // $usuarios[] = new Usuario($item['idUsuario'],$item['email'],$item['nome'],$item['sobrenome'],$item['senha'],$item['cadastroConfirmado']);
            }    
        }
        
        return $usuarios;
    }

    /**
    * Busca um ou várias obras aleatórias no banco de dados;
    * @param unknown $campos - um array contendo os campos desejados, caso receba um valor vazio ou null considera que esteja solicitando todos os campos
    * @param unknown $limite - o número máximo de retornos de uma busca
    * @return unknown $obras - um array contendo as notícias retornados na busca
    */
    public function buscarAleatoria($campos,$limite=0){

        $query = "SELECT ";

        if(count($campos) == 0){
            $campos = array("*");
        }

        $query .= implode(',',$campos)."FROM obra";

        $query .= "ORDER BY RAND() ";

        if($limite > 0 ){
            $query .= "LIMIT ".$limite;
        }

        $result = $this->PDO->query($query);

        $obras = array();
        if(!empty($result) && $result->rowCount() > 0){
            foreach($result->fetchAll() as $item){
                $obras[] = new Obra($item['idNoticia'],$item['email'],$item['nome'],$item['sobrenome'],$item['senha'],$item['cadastroConfirmado']);
            }    
        }
        
        return $obras;
    }

    /**
    * Insere uma coleção no banco de dados;
    * @param unknown $colecao - A coleção a ser inserida no banco;
    * */
    public function inserirColecao($colecao){
        
        $nome = $colecao->getNome();

        $query = "INSERT INTO Colecao(idColecao, nome) 
                  VALUES (null,'$nome')";
        try{
            $this->PDO->query($query);
        }catch(PDOException $e){

        }
    }

    /**
    * Insere uma coleção no banco de dados;
    * @param unknown $colecao - A coleção a ser inserida no banco;
    * */
    public function inserirClassificacao($classificacao){
        
        $nome = $classificacao->getNome();

        $query = "INSERT INTO Classificacao(idClassificacao, nome) 
                  VALUES (null,'$nome')";
        try{
            $this->PDO->query($query);
        }catch(PDOException $e){

        }
    }

    /**
    * Realiza a busca de classificações no banco
    * @param unknown $campos - Campos Desejados
    * @param unknow $filtros - Filtros utilizados na busca
    * */
    public function buscarClassificacao($campos,$filtros){
        
        $query = "SELECT ";

        if(count($campos) == 0){
            $campos = array("*");
        }

        $query .= implode(',',$campos)."FROM Classificacao ORDER BY nome ASC";

        if(count($filtros) > 0){
            $query .= " WHERE ";
            $aux = array();

            foreach($filtros as $chave=>$valor){
                $aux[] = $chave."="."'$valor'";
            }
            
            $query .= implode(" AND ",$aux);
        }

        $result = $this->PDO->query($query);

        $classificacoes = array();
        if(!empty($result) && $result->rowCount() > 0){
            foreach($result->fetchAll() as $item){
                $classificacoes[] = new Classificacao(isset($item['idClassificacao'])?$item['idClassificacao']:null,
                                                      isset($item['nome'])?$item['nome']:null);
            }    
        }
        
        return $classificacoes;
    }

    /**
    * Realiza a busca de classificações no banco
    * @param unknown $campos - Campos Desejados
    * @param unknow $filtros - Filtros utilizados na busca
    * */
    public function buscarColecoes($campos,$filtros){
        
        $query = "SELECT ";

        if(count($campos) == 0){
            $campos = array("*");
        }

        $query .= implode(',',$campos)."FROM Colecoes ORDER BY nome ASC";

        if(count($filtros) > 0){
            $query .= " WHERE ";
            $aux = array();

            foreach($filtros as $chave=>$valor){
                $aux[] = $chave."="."'$valor'";
            }
            
            $query .= implode(" AND ",$aux);
        }

        $result = $this->PDO->query($query);

        $colecoes = array();
        if(!empty($result) && $result->rowCount() > 0){
            foreach($result->fetchAll() as $item){
                $colecoes[] = new Colecao(isset($item['idColecao'])?$item['idColecao']:null,
                                                      isset($item['nome'])?$item['nome']:null);
            }    
        }
        
        return $colecoes;
    }
}


?>
