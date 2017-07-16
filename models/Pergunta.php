<?php
namespace models;
/**
 * Classe responsável por representar um formulario de pesquisa no contexto do sistema.
 * @author MItologhic Software
 *
 */
class Pergunta {
    
    private $idPergunta;
    private $titulo;
    private $tipo;
    private $opcional;

    /**
     * Construtor da classe
     * @param unknown $idPergunta - Id da pergunta   
     * @param unknow $titulo - Título da pergunta 
     * @param unknow $tipo - Tipo da pergunta
     * @param unknow $opcional - Mostra se a pergunta é opcional ou não
     */
    public function __construct($idPergunta, $titulo, $tipo, $opcional) {
        $this->idPergunta = $idPergunta;
        $this->titulo = $titulo;
        $this->tipo = $tipo;
        $this->opcional = $opcional;
    }

    /**
     * Obtém o id da pergunta.
     * @return idPergunta
     */
    public function getIdPergunta(){
        return $this->idPergunta;
    }

    /**
     * Obtém o titulo da pergunta.
     * @return titulo
     */
    public function getTitulo(){
        return $this->titulo;
    }

     /**
     * Obtém o tipo da pergunta.
     * @return tipo
     */
    public function getTipo(){
        return $this->tipo;
    }

     /**
     * Obtém se a pergunta é opcional ou nao.
     * @return titulo
     */
    public function getIsOpcional(){
        return $this->opcional;
    }
}

?>