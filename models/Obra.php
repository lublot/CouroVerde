<?php
namespace models;

/**
 * Classe responsável por representar uma obra no contexto do sistema.
 * @author MItologhic Software
 *
 */
class Obra {

    
    /* Atributos da obra */
    /* Identificação da obra */
    private $id;
    private $nome;
    private $titulo;
    private $numInventario;
    private $colecao;
    private $origem;
    private $procedencia;
    private $classificacao;
    private $funcao;
    private $palavrasChave;
    private $descricao;

    /* Dimensões */
    private $altura;
    private $largura;
    private $diametro;
    private $peso;
    private $comprimento;

    /* Características estilísticas*/
    private $materiais;
    private $tecnicas;
    private $autoria;

    /* Marcas e Inscrições */
    private $marcas;

    /* Histórico */
    private $historico;

    /* Aquisição */
    private $modoAquisicao;
    private $dataAquisicao;
    private $autor;
    private $observacoes;

    /* Estado de conservação */
    private $estado;

    /* Fotografias */
    private $caminhoImagem1;
    private $caminhoImagem2;
    private $caminhoImagem3;
    private $caminhoImagem4;
    private $caminhoImagem5;

    /* Modelo 3D */
    private $caminhoModelo3D;

    /**
     * Construtor da classe
     * @param unknown $nome - Nome da obra
     * @param unknown $titulo - Titulo da obra
     * @param unknown $numInventario - Número de Inventário da obra
     * @param unknown $colecao - Coleção da obra
     * @param unknown $origem - Origem da obra
     * @param unknown $procedencia - Procedência da obra
     * @param unknown $classificacao - Classificação da obra
     * @param unknown $funcao - Função da obra
     */
    public function __construct($id, $nome, $titulo, $numInventario, $colecao, $origem, $procedencia, $classificacao, $funcao, 
                                $palavrasChave, $descricao, $altura, $largura, $diametro, $peso, $comprimento, $materiais, 
                                $tecnicas, $autoria, $marcas, $historico, $modoAquisicao, $dataAquisicao, $autor, $observacoes,
                                $estado, $caminhoImagem1, $caminhoImagem2, $caminhoImagem3, $caminhoImagem4, $caminhoImagem5, $caminhoModelo3D) {
        $this->id = $id;
        $this->nome = $nome;
        $this->titulo = $titulo;
        $this->numInventario = $numInventario;
        $this->colecao = $colecao;
        $this->origem = $origem;
        $this->procedencia = $procedencia;
        $this->classificacao = $classificacao;
        $this->funcao = $funcao;
        $this->palavrasChave = $palavrasChave;
        $this->descricao = $descricao;
        $this->altura = $altura;
        $this->largura = $largura;
        $this->diametro = $diametro;
        $this->peso = $peso;
        $this->comprimento = $comprimento;
        $this->materiais = $materiais;
        $this->tecnicas = $tecnicas;
        $this->autoria = $autoria;
        $this->marcas = $marcas;
        $this->historico = $historico;
        $this->modoAquisicao = $modoAquisicao;
        $this->dataAquisicao = $dataAquisicao;
        $this->autor = $autor;
        $this->observacoes = $observacoes;
        $this->estado = $estado;
        $this->caminhoImagem1 = $caminhoImagem1;
        $this->caminhoImagem2 = $caminhoImagem2;
        $this->caminhoImagem3 = $caminhoImagem3;
        $this->caminhoImagem4 = $caminhoImagem4;
        $this->caminhoImagem5 = $caminhoImagem5;
        $this->caminhoModelo3D = $caminhoModelo3D;
    }
    

    /**
     * Obtém o id da obra.
     * @return id
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Obtém o nome da obra.
     * @return nome
     */
    public function getNome() {
        return $this->nome;
    }

    /**
     * Define o nome da obra.
     * @param unknown $nome - Nome da obra
     */
    public function setNome($nome) {
        $this->nome = $nome;
    }

    /**
     * Obtém o título da obra.
     * @return titulo
     */
    public function getTitulo() {
        return $this->titulo;
    }

    /**
     * Define o título da obra.
     * @param unknown $titulo - Título da obra
     */
    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    /**
     * Obtém o número de inventário da obra.
     * @return numInventario
     */
    public function getNumInventario() {
        return $this->numInventario;
    }

    /**
     * Define o número de inventário da obra.
     * @param unknown $numInventario - Número de Inventário da obra
     */
    public function setNumInventario($n) {
        $this->numInventario = $n;
    }




}

?>