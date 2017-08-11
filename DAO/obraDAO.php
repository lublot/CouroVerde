<?php
namespace DAO;

require_once dirname(__DIR__).'/vendor/autoload.php';
use \DAO\Database as Database;
use \models\Obra as Obra;
use \models\Colecao as Colecao;
use \models\Fotografia as Fotografia;
use \models\Classificacao as Classificacao;


class ObraDAO extends Database {

    /**
    * Insere uma obra no banco de dados;
    * @param unknown $obra - a obra a ser inserida no banco;
    * */
    public function inserirObra($obra, $fotografia = false){
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
        $altura = $obra->getAltura() == null ? 'NULL' : $obra->getAltura();
        $largura = $obra->getLargura() == null ? 'NULL' : $obra->getLargura();
        $diametro = $obra->getDiametro() == null ? 'NULL' : $obra->getDiametro();
        $peso = $obra->getPeso() == null ? 'NULL' : $obra->getPeso();
        $comprimento = $obra->getComprimento() == null ? 'NULL': $obra->getComprimento();
        $materiais = $obra->getMateriais();
        $tecnicas = $obra->getTecnicas();
        $autoria = $obra->getAutoria();
        $marcas = $obra->getMarcas();
        $historico = $obra->getHistorico();
        $modoAquisicao = $obra->getModoAquisicao();
        $dataAquisicao = $obra->getDataAquisicao() == null ? 'NULL' : $obra->getDataAquisicao();
        $autor = $obra->getAutor();
        $observacoes = $obra->getObservacoes();
        $estado = $obra->getEstado();
        $caminhoImagem1 = $obra->getCaminhoImagem1();
        $caminhoImagem2 = $obra->getCaminhoImagem2();
        $caminhoImagem3 = $obra->getCaminhoImagem3();
        $caminhoImagem4 = $obra->getCaminhoImagem4();
        $caminhoImagem5 = $obra->getCaminhoImagem5();
        $caminhoModelo3D = $obra->getCaminhoModelo3D();

        $query = "INSERT INTO obra(numeroInventario, nome, titulo, funcao, origem, procedencia, descricao, idColecao, idClassificacao,
                                    altura, largura, diametro, peso, comprimento, materiaisContruidos, tecnicasFabricacao, autoria, 
                                    marcasInscricoes, historicoObjeto, modoAquisicao, dataAquisicao, autor, observacoes, estadoConservacao,
                                    caminhoImagem1, caminhoImagem2, caminhoImagem3, caminhoImagem4, caminhoImagem5, caminhoModelo3D) 
                  VALUES ('$numInventario', '$nome','$titulo', '$funcao', '$origem', '$procedencia', '$descricao', '$idColecao', '$idClassificacao',
                            $altura, $largura, $diametro, $peso, $comprimento, '$materiais', '$tecnicas', '$autoria', '$marcas', '$historico', 
                            '$modoAquisicao', $dataAquisicao, '$autor', '$observacoes', '$estado', '$caminhoImagem1', '$caminhoImagem2',
                            '$caminhoImagem3', '$caminhoImagem4', '$caminhoImagem5', '$caminhoModelo3D')";

   
        try{
            $this->PDO->query($query);
        }catch(PDOException $e){

        }

        if($fotografia) {
            $fotografo = $obra->getFotografo();
            $dataFotografia = $obra->getDataFotografia() == null? 'NULL' : $obra->getDataFotografia();
            $autorFotografia = $obra->getAutorFotografia();

            $query = "INSERT INTO fotografia(idFotografia, fotografo, data, autorFotografia) VALUES ($numInventario, '$fotografo', $dataFotografia, '$autorFotografia')";
            
            try{
                $this->PDO->query($query);
            }catch(PDOException $e){

            }

            echo $query;
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
        $query = "DELETE FROM obra ";

        if(count($filtros) > 0){
            $query = $query . 'WHERE ';
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
    * @param unknown $filtros - um array contendo os filtros usados na busca. Ex: array("idObra"=>5);
    * @return unknown $obras - um array contendo os usuários retornados na busca
    */
    public function buscar($campos,$filtros){
        $query = "SELECT ";

        if(count($campos) == 0){
            $campos = array("*");
        }

        $query .= implode(',',$campos)." FROM obra";

        if(count($filtros) > 0){
            $query .= " WHERE ";
            $aux = array();

            foreach($filtros as $chave=>$valor){
                $aux[] = $chave."="."'$valor'";
            }
            
            $query .= implode(" AND ",$aux);
        }

        $result = $this->PDO->query($query);

        $obras = array();
        if(!empty($result) && $result->rowCount() > 0){
            foreach($result->fetchAll() as $item){
               $obras[] = new Obra(isset($item['numeroInventario'])?$item['numeroInventario']:null,
                                    isset($item['nome'])?$item['nome']:null,
                                    isset($item['titulo'])?$item['titulo']:null,
                                    isset($item['funcao'])?$item['funcao']:null,
                                    isset($item['origem'])?$item['origem']:null,
                                    isset($item['procedencia'])?$item['procedencia']:null,
                                    isset($item['descricao'])?$item['descricao']:null,
                                    isset($item['idColecao'])?$item['idColecao']:null,
                                    isset($item['idClassificacao'])?$item['idClassificacao']:null,
                                    isset($item['altura'])?$item['altura']:null,
                                    isset($item['largura'])?$item['largura']:null,
                                    isset($item['diametro'])?$item['diametro']:null,
                                    isset($item['peso'])?$item['peso']:null,
                                    isset($item['comprimento'])?$item['comprimento']:null,
                                    isset($item['materiaisConstruidos '])?$item['materiaisConstruidos']:null,
                                    isset($item['tecnicaFabricacao'])?$item['tecnicaFabricacao']:null,
                                    isset($item['autoria'])?$item['autoria']:null,
                                    isset($item['marcasInscricoes'])?$item['marcasInscricoes']:null,
                                    isset($item['historicoObjeto'])?$item['historicoObjeto']:null,
                                    isset($item['modoAquisicao'])?$item['modoAquisicao']:null,
                                    isset($item['dataAquisicao'])?$item['dataAquisicao']:null,
                                    isset($item['autor'])?$item['autor']:null,
                                    isset($item['observacoes'])?$item['observacoes']:null,
                                    isset($item['estadoConservacao'])?$item['estadoConservacao']:null);
            }    
        }
        
        return $obras;
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
                $obras[] = new Obra(isset($item['numeroInventario'])?$item['numeroInventario']:null,
                                    isset($item['nome'])?$item['nome']:null,
                                    isset($item['titulo'])?$item['titulo']:null,
                                    isset($item['funcao'])?$item['funcao']:null,
                                    isset($item['origem'])?$item['origem']:null,
                                    isset($item['procedencia'])?$item['procedencia']:null,
                                    isset($item['descricao'])?$item['descricao']:null,
                                    isset($item['idColecao'])?$item['idColecao']:null,
                                    isset($item['idClassificacao'])?$item['idClassificacao']:null,
                                    isset($item['altura'])?$item['altura']:null,
                                    isset($item['largura'])?$item['largura']:null,
                                    isset($item['diametro'])?$item['diametro']:null,
                                    isset($item['peso'])?$item['peso']:null,
                                    isset($item['comprimento'])?$item['comprimento']:null,
                                    isset($item['materiaisConstruidos '])?$item['materiaisConstruidos']:null,
                                    isset($item['tecnicaFabricacao'])?$item['tecnicaFabricacao']:null,
                                    isset($item['autoria'])?$item['autoria']:null,
                                    isset($item['marcasInscricoes'])?$item['marcasInscricoes']:null,
                                    isset($item['historicoObjeto'])?$item['historicoObjeto']:null,
                                    isset($item['modoAquisicao'])?$item['modoAquisicao']:null,
                                    isset($item['dataAquisicao'])?$item['dataAquisicao']:null,
                                    isset($item['autor'])?$item['autor']:null,
                                    isset($item['observacoes'])?$item['observacoes']:null,
                                    isset($item['estadoConservacao'])?$item['estadoConservacao']:null);
            }    
        }
        
        return $obras;
    }

    /**
    * Insere uma coleção no banco de dados;
    * @param unknown $colecao - A coleção a ser inserida no banco;
    * */
    public function inserirColecao($colecao){
        $query = "INSERT INTO colecao(idColecao, nome) VALUES (null, '".$colecao->getNome()."')";

        try{
            $this->PDO->query($query);
        }catch(PDOException $e){
        
        }
    }

    /**
    * Insere uma classificação no banco de dados;
    * @param unknown $classificacao - A classificação a ser inserida no banco;
    * */
    public function inserirClassificacao($classificacao){
        $query = "INSERT INTO classificacao(idClassificacao, nome) VALUES (null, '".$classificacao->getNome()."')";

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
            $camposSelect = "*";
        } else {
            $camposSelect = implode(', ',$campos);
        }

        $query .= $camposSelect."FROM classificacao ORDER BY nome ASC";

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
    * Realiza a busca de coleções no banco
    * @param unknown $campos - Campos Desejados
    * @param unknow $filtros - Filtros utilizados na busca
    * */
    public function buscarColecoes($campos,$filtros){
        
        $query = "SELECT ";

        if(count($campos) == 0){
            $camposSelect = "*";
        } else {
            $camposSelect = implode(',',$campos);
        }

        $query .= $camposSelect." FROM colecao ORDER BY nome ASC";

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

    /**
    * Insere uma palavra-chave no banco de dados;
    * @param unknown $palavraChave - A palavra-chave a ser inserida no banco;
    * */
    public function inserirPalavraChave($numInventario, $descricao){

        $query = "INSERT INTO tag(idTag, descricao) VALUES (null,'".$descricao."')";
        try{
            $this->PDO->query($query);
        }catch(PDOException $e){

        }

        $idTag = $this->PDO->lastInsertId("idTag"); //pega o ultimo id de tag inserida

        $query2 = "INSERT INTO tagobra(idObra, idTag) 
                  VALUES ('$numInventario','$idTag')";

        try{
            $this->PDO->query($query2);
        }catch(PDOException $e){

        }
                
    }

    /**
    * Busca uma ou várias obras que possuem uma determinada string no titulo
    * @param unknown $campos - um array contendo os campos desejados
    * @param unknown $filtros - a string que se deseja verificar se o titulo da obra contém
    * @return unknown $obras - um array contendo as obras retornados na busca
    */
    public function buscarTituloLike($campos, $titulo){
        $query = "SELECT ";

        if(count($campos) == 0){
            $campos = array("*");
        }

        $query .= implode(',',$campos)." FROM obra";

        if($titulo != null) {
            $query .= " WHERE titulo LIKE '%$titulo%'";
        }

        $result = $this->PDO->query($query);

        echo $query;

        $obras = array();
        if(!empty($result) && $result->rowCount() > 0){
            foreach($result->fetchAll() as $item){
               $obras[] = new Obra(isset($item['numeroInventario'])?$item['numeroInventario']:null,
                                    isset($item['nome'])?$item['nome']:null,
                                    isset($item['titulo'])?$item['titulo']:null,
                                    isset($item['funcao'])?$item['funcao']:null,
                                    isset($item['origem'])?$item['origem']:null,
                                    isset($item['procedencia'])?$item['procedencia']:null,
                                    isset($item['descricao'])?$item['descricao']:null,
                                    isset($item['idColecao'])?$item['idColecao']:null,
                                    isset($item['idClassificacao'])?$item['idClassificacao']:null,
                                    isset($item['altura'])?$item['altura']:null,
                                    isset($item['largura'])?$item['largura']:null,
                                    isset($item['diametro'])?$item['diametro']:null,
                                    isset($item['peso'])?$item['peso']:null,
                                    isset($item['comprimento'])?$item['comprimento']:null,
                                    isset($item['materiaisConstruidos '])?$item['materiaisConstruidos']:null,
                                    isset($item['tecnicaFabricacao'])?$item['tecnicaFabricacao']:null,
                                    isset($item['autoria'])?$item['autoria']:null,
                                    isset($item['marcasInscricoes'])?$item['marcasInscricoes']:null,
                                    isset($item['historicoObjeto'])?$item['historicoObjeto']:null,
                                    isset($item['modoAquisicao'])?$item['modoAquisicao']:null,
                                    isset($item['dataAquisicao'])?$item['dataAquisicao']:null,
                                    isset($item['autor'])?$item['autor']:null,
                                    isset($item['observacoes'])?$item['observacoes']:null,
                                    isset($item['estadoConservacao'])?$item['estadoConservacao']:null);
            }    
        }
        
        return $obras;
    }

    /**
    * Busca uma ou várias obras que possuem as tags informadas
    * @param unknown $campos - um array contendo os campos desejados
    * @param unknown $tags - um array contendo as tags informadas
    * @return unknown $obras - um array contendo as obras retornados na busca
    */
    public function buscarPorTag($campos, $tags){
        $query = "SELECT obra.* ";

        if(count($campos) == 0){
            $campos = array("*");
        }

        $result = array();

        foreach($tags as $tag) {
            $query .= implode(',',$campos)." FROM obra INNER JOIN tagobra ON obra.numeroInventario = tagobra.idObra INNER JOIN tag ON tagobra.idTag = tag.idTag AND tag.descricao LIKE '%$tag$'";
            array_merge($result, $this->PDO->query($query));
        }

        $obras = array();
        if(!empty($result) && $result->rowCount() > 0){
            foreach($result->fetchAll() as $item){
               $obras[] = new Obra(isset($item['numeroInventario'])?$item['numeroInventario']:null,
                                    isset($item['nome'])?$item['nome']:null,
                                    isset($item['titulo'])?$item['titulo']:null,
                                    isset($item['funcao'])?$item['funcao']:null,
                                    isset($item['origem'])?$item['origem']:null,
                                    isset($item['procedencia'])?$item['procedencia']:null,
                                    isset($item['descricao'])?$item['descricao']:null,
                                    isset($item['idColecao'])?$item['idColecao']:null,
                                    isset($item['idClassificacao'])?$item['idClassificacao']:null,
                                    isset($item['altura'])?$item['altura']:null,
                                    isset($item['largura'])?$item['largura']:null,
                                    isset($item['diametro'])?$item['diametro']:null,
                                    isset($item['peso'])?$item['peso']:null,
                                    isset($item['comprimento'])?$item['comprimento']:null,
                                    isset($item['materiaisConstruidos '])?$item['materiaisConstruidos']:null,
                                    isset($item['tecnicaFabricacao'])?$item['tecnicaFabricacao']:null,
                                    isset($item['autoria'])?$item['autoria']:null,
                                    isset($item['marcasInscricoes'])?$item['marcasInscricoes']:null,
                                    isset($item['historicoObjeto'])?$item['historicoObjeto']:null,
                                    isset($item['modoAquisicao'])?$item['modoAquisicao']:null,
                                    isset($item['dataAquisicao'])?$item['dataAquisicao']:null,
                                    isset($item['autor'])?$item['autor']:null,
                                    isset($item['observacoes'])?$item['observacoes']:null,
                                    isset($item['estadoConservacao'])?$item['estadoConservacao']:null);
            }    
        }
        
        return $obras;
    }    

    
}


?>
