<?php
namespace models;

/**
 * Classe responsável por representar uma notícia no contexto do sistema.
 * @author MItologhic Software
 *
 */
class Noticia {
    /* atributos do usuário */
    private $idNoticia;
    private $titulo;
    private $subtitulo;
    private $caminhoImagem;
    private $data;

    /**
     * Construtor da classe
     * @param unknown $idNoticia id da notícia     
     * @param unknown $titulo titulo da notícia
     * @param unknown $subtitulo subtitulo da notícia
     * @param unknown $caminhoImagem caminho da imagem da notícia
     * @param unknown $data data da notícia  
     */
    public function __construct($idNoticia,$titulo, $subtitulo, $caminhoImagem, $data) {
        $this->idNoticia = $idNoticia;
        $this->titulo = $titulo;
        $this->subtitulo = $subtitulo;
        $this->caminhoImagem = $caminhoImagem;
        $this->data = $data;
    }
    

    /**
     * Obtém o idNoticia.
     * @return idNoticia
     */
    public function getidNoticia() {
        return $this->idNoticia;
    }

    /**
     * Obtém o titulo da notícia.
     * @return titulo
     */
    public function getTitulo() {
        return $this->titulo;
    }

    /**
     * Configura o titulo da notícia.
     * @param unknown $titulo titulo da notícia
     */
    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    /**
     * Obtém o subtitulo da notícia.
     * @param unknown $subtitulo subtitulo da notícia
     */
    public function getSubtitulo() {
        return $this->subtitulo;
    }

    /**
     * Configura o subtitulo da notícia.
     * @param unknown $subtitulo subtitulo da notícia
     */
    public function setSubtitulo($subtitulo) {
        $this->subtitulo = $subtitulo;
    }

    /**
     * Obtém o caminho da imagem da notícia.
     * @return caminhoImagem
     */
    public function getCaminhoImagem() {
        return $this->caminhoImagem;
    }

    /**
     * Configura o caminho da imagem.
     * @param unknown $caminhoImagem caminho da imagem
     */
    public function setCaminhoImagem($caminhoImagem) {
        $this->caminhoImagem = $caminhoImagem;
    }

    /**
     * Obtém a data da notícia.
     * @return data
     */
    public function getData() {
        return $this->data;
    }

    /**
     * Configura a data da notícia.
     * @param unknown $subtitulo data da notícia
     */
    public function setData($data) {
        $this->data = $data;
    }  

}

?>
