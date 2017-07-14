<?php
namespace DAO;

require_once dirname(__DIR__).'/vendor/autoload.php';
use \models\Noticia as Noticia;
use \DAO\Database as Database;

class noticiaDAO extends Database {
    /**
    * Insere uma notícia no banco de dados;
    * @param Noticia $noticia - a noticia a ser inserida no banco;
    * */
    public function inserir($noticia){
        $titulo = $noticia->getTitulo();
        $subtitulo = $noticia->getSubtitulo();
        $descricao = $noticia->getDescricao();
        $caminhoImagem = $noticia->getCaminhoImagem();
        $data = $noticia->getData();

        $query = "INSERT INTO noticia(idNoticia, titulo, subtitulo, descricao, caminhoImagem, data) VALUES (null, '$titulo', '$subtitulo', '$descricao', '$caminhoImagem', '$data')";

        try{
            $this->PDO->query($query);
        }catch(PDOException $e){

        }
    }

    /**
    * Altera informações de uma notícia no banco de dados;
    * @param unknown $dados - um array contendo as colunas e valores para a alteração. Ex: array("titulo"=>"Título");
    * @param unknown $filtros - um array contendo os filtros usados na busca. Ex: array("idNoticia"=>5);
    * */
    public function alterar($dados,$filtros){
        $query = "UPDATE noticia SET ";

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
    * Remove uma notícia do banco de dados;
    * @param unknown $filtros - um array contendo os filtros usados na identificação da notícia. Ex: array("idNoticia"=>5);
    * */
    public function remover($filtros){
        $query = "DELETE FROM noticia ";

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
    * Busca uma ou várias notícias no banco de dados;
    * @param unknown $campos - um array contendo os campos desejados
    * @param unknown $filtros - um array contendo os filtros usados na busca. Ex: array("idNoticia"=>5);
    * @return unknown $noticias - um array contendo os notícias retornados na busca
    */
    public function buscar($campos,$filtros){
        $query = "SELECT ";

        if(count($campos) == 0){
            $campos = array("*");
        }

        $query .= implode(',',$campos)."FROM noticia";

        if(count($filtros) > 0){
            $query .= " WHERE ";
            $aux = array();

            foreach($filtros as $chave=>$valor){
                $aux[] = $chave."="."'$valor'";
            }
            
            $query .= implode(" AND ",$aux);
        }

        $result = $this->PDO->query($query);

        $noticias = array();
        if(!empty($result) && $result->rowCount() > 0){
            foreach($result->fetchAll() as $item){
                $noticias[] = new Noticia(isset($item['idNoticia']) ? $item['idNoticia']:null,
                                          isset($item['titulo']) ? $item['titulo']:null,
                                          isset($item['subtitulo']) ? $item['subtitulo']:null,
                                          isset($item['descricao']) ? $item['descricao']:null,
                                          isset($item['caminhoImagem']) ? $item['caminhoImagem']:null,
                                          isset($item['data']) ? ValidacaoDados::formatarDataSQLparaPadrao($item['data']):null);
            }    
        }
        
        return $noticias;
    }


     /**
    * Busca um ou várias notícias mais recentes no banco de dados;
    * @param unknown $campos - um array contendo os campos desejados, caso receba um valor vazio ou null considera que esteja solicitando todos os campos
    * @param unknown $filtros - um array contendo os filtros usados na busca. Ex: array("idNoticia"=>5);
    * @return unknown $noticias - um array contendo as notícias retornados na busca
    */
    public function buscarMaisRecente($campos,$filtros,$limite=0){


        $query = "SELECT ";

        if(count($campos) == 0){
            $campos = array("*");
        }

        $query .= implode(',',$campos)."FROM noticia";

        if(count($filtros) > 0){
            $query .= " WHERE ";
            $aux = array();

            foreach($filtros as $chave=>$valor){
                $aux[] = $chave."="."'$valor'";
            }
            
            $query .= implode(" AND ",$aux);
        }

        $query .= "ORDER BY data DESC";

        if($limite > 0 ){
            $query .= "LIMIT ".$limite;
        }

        $result = $this->PDO->query($query);

        $noticias = array();
        if(!empty($result) && $result->rowCount() > 0){
            foreach($result->fetchAll() as $item){
                $noticias[] = new Noticia(isset($item['idNoticia']) ? $item['idNoticia']:null,
                                          isset($item['titulo']) ? $item['titulo']:null,
                                          isset($item['subtitulo']) ? $item['subtitulo']:null,
                                          isset($item['descricao']) ? $item['descricao']:null,
                                          isset($item['caminhoImagem']) ? $item['caminhoImagem']:null,
                                          isset($item['data']) ? ValidacaoDados::formatarDataSQLparaPadrao($item['data']):null);
            }    
        }
        
        return $noticias;
    }
}


?>
