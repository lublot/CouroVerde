<?php
namespace models;

/**
 * Classe responsável por representar uma obra no contexto do sistema.
 * @author MItologhic Software
 *
 */
class Obra implements \JsonSerializable {

    /* Atributos da obra */
    /* Identificação da obra */
    private $nome;
    private $titulo;
    private $numInventario;
    private $idColecao;
    private $origem;
    private $procedencia;
    private $idClassificacao;
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
     * @param unknown $idColecao - Coleção da obra
     * @param unknown $origem - Origem da obra
     * @param unknown $procedencia - Procedência da obra
     * @param unknown $idClassificacao - Classificação da obra
     * @param unknown $funcao - Função da obra
     * @param unknown $palavrasChave - Palavras-chave da obra
     * @param unknown $descricao - Descrição da obra
     * @param unknown $altura - Altura da obra
     * @param unknown $largura - Largura da obra
     * @param unknown $diametro - Diâmetro da obra
     * @param unknown $peso - Peso da obra
     * @param unknown $comprimento - Comprimento da obra
     * @param unknown $materiais - Materiais da obra
     * @param unknown $tecnicas - Técnicas da obra
     * @param unknown $autoria - Autoria da obra
     * @param unknown $marcas - Marcas da obra
     * @param unknown $historico - Histórico da obra
     * @param unknown $modoAquisicao - Modo de aquisição da obra
     * @param unknown $dataAquisicao - Data de aquisição da obra
     * @param unknown $autor - Autor da obra
     * @param unknown $observacoes - Observações da obra
     * @param unknown $estado - Estado da obra
     * @param unknown $caminhoImagem1 - Caminho da primeira imagem
     * @param unknown $caminhoImagem2 - Caminho da segunda imagem
     * @param unknown $caminhoImagem3 - Caminho da terceira imagem
     * @param unknown $caminhoImagem4 - Caminho da quarta imagem
     * @param unknown $caminhoImagem5 - Caminho da quinta imagem
     * @param unknown $caminhoModelo3D - Caminho do modelo 3D
     */
    public function __construct($numInventario, $nome, $titulo, $funcao = null, $origem = null, $procedencia = null, $descricao = null, $idColecao, $idClassificacao,
                                $altura = null, $largura = null, $diametro = null, $peso = null, $comprimento = null, $materiais = null, $tecnicas = null, $autoria = null, $marcas = null, $historico = null, 
                                $modoAquisicao = null, $dataAquisicao = null, $autor = null, $observacoes = null, $estado = null, $caminhoImagem1 = null, $caminhoImagem2 = null, $caminhoImagem3 = null, $caminhoImagem4 = null, $caminhoImagem5 = null, $caminhoModelo3D = null) {
        
        $this->numInventario = $numInventario;
        $this->nome = $nome;
        $this->titulo = $titulo;
        $this->funcao = $funcao;
        $this->origem = $origem;
        $this->procedencia = $procedencia;
        $this->descricao = $descricao;
        $this->idColecao = $idColecao;
        $this->idClassificacao = $idClassificacao;
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

    /**
     * Obtém o id da coleção da obra.
     * @return idColecao
     */
    public function getIdColecao() {
        return $this->idColecao;
    }

    /**
     * Define o id da coleção da obra.
     * @param unknown $idColecao - Id da coleção da obra
     */
    public function setIdColecao($idColecao) {
        $this->idColecao = $idColecao;
    }

    /**
     * Obtém a origem da obra.
     * @return origem
     */
    public function getOrigem() {
        return $this->origem;
    }

    /**
     * Define a origem da coleção da obra.
     * @param unknown $origem - Origem da obra
     */
    public function setOrigem($origem) {
        $this->origem = $origem;
    }

    /**
     * Obtém a procedência da obra.
     * @return procedencia
     */
    public function getProcedencia() {
        return $this->procedencia;
    }

    /**
     * Define a procedência da obra.
     * @param unknown $procedencia - Procedência da obra
     */
    public function setProcedencia($procedencia) {
        $this->procedencia = $procedencia;
    }

    /**
     * Obtém o id da classificação da obra.
     * @return idClassificacao
     */
    public function getIdClassificacao() {
        return $this->idClassificacao;
    }

    /**
     * Define o id da classificação da obra.
     * @param unknown $idClassificacao - Id da classificação da obra
     */
    public function setIdClassificacao($idClassificacao) {
        $this->idClassificacao = $idClassificacao;
    }

    /**
     * Obtém a função da obra.
     * @return funcao
     */
    public function getFuncao() {
        return $this->funcao;
    }

    /**
     * Define a função da obra.
     * @param unknown $funcao - Função da obra
     */
    public function setFuncao($funcao) {
        $this->funcao = $funcao;
    }

    /**
     * Obtém a palavra-chave da obra.
     * @return palavrasChave
     */
    public function getPalavrasChave() {
        return $this->palavrasChave;
    }

    /*
     * Define as palavras-chave da obra.
     * @param unknown $palavrasChave - Palavras-chave da obra
     
    public function setPalavrasChave($palavrasChave) {
        $this->palavrasChave = $palavrasChave;
    }
    */

    /**
     * Obtém a descrição da obra.
     * @return descricao
     */
    public function getDescricao() {
        return $this->descricao;
    }

    /**
     * Define a descrição da obra.
     * @param unknown $descricao - Descrição da obra
     */
    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    /**
     * Obtém a altura da obra.
     * @return altura
     */
    public function getAltura() {
        return $this->altura;
    }

    /**
     * Define a altura da obra.
     * @param unknown $altura - Altura da obra
     */
    public function setAltura($altura) {
        $this->altura = $altura;
    }

    /**
     * Obtém a largura da obra.
     * @return largura
     */
    public function getLargura() {
        return $this->largura;
    }

    /**
     * Define a largura da obra.
     * @param unknown $largura - Largura da obra
     */
    public function setLargura($largura) {
        $this->largura = $largura;
    }

    /**
     * Obtém o diâmetro da obra.
     * @return diametro
     */
    public function getDiametro() {
        return $this->diametro;
    }

    /**
     * Define o diâmetro da obra.
     * @param unknown $diametro - Diâmetro da obra
     */
    public function setDiametro($diametro) {
        $this->diametro = $diametro;
    }

    /**
     * Obtém o peso da obra.
     * @return peso
     */
    public function getPeso() {
        return $this->peso;
    }

    /**
     * Define o peso da obra.
     * @param unknown $peso - Peso da obra
     */
    public function setPeso($peso) {
        $this->peso = $peso;
    }

    /**
     * Obtém o comprimento da obra.
     * @return comprimento
     */
    public function getComprimento() {
        return $this->comprimento;
    }

    /**
     * Define o comprimento da obra.
     * @param unknown $comprimento - Comprimento da obra
     */
    public function setComprimento($comprimento) {
        $this->comprimento = $comprimento;
    }

    /**
     * Obtém os materiais da obra.
     * @return materiais
     */
    public function getMateriais() {
        return $this->materiais;
    }

    /**
     * Define os materiais da obra.
     * @param unknown $materiais - Materiais da obra
     */
    public function setMateriais($materiais) {
        $this->materiais = $materiais;
    }

    /**
     * Obtém as técnicas da obra.
     * @return tecnicas
     */
    public function getTecnicas() {
        return $this->tecnicas;
    }

    /**
     * Define as técnicas da obra.
     * @param unknown $tecnicas - Técnicas da obra
     */
    public function setTecnicas($tecnicas) {
        $this->tecnicas = $tecnicas;
    }

    /**
     * Obtém a autoria da obra.
     * @return autoria
     */
    public function getAutoria() {
        return $this->autoria;
    }

    /**
     * Define a autoria da obra.
     * @param unknown $autoria - Autoria da obra
     */
    public function setAutoria($autoria) {
        $this->autoria = $autoria;
    }

    /**
     * Obtém as marcas da obra.
     * @return marcas
     */
    public function getMarcas() {
        return $this->marcas;
    }

    /**
     * Define as marcas da obra.
     * @param unknown $marcas - Marcas da obra
     */
    public function setMarcas($marcas) {
        $this->marcas = $marcas;
    }

    /**
     * Obtém o histórico da obra.
     * @return historico
     */
    public function getHistorico() {
        return $this->historico;
    }

    /**
     * Define o histórico da obra.
     * @param unknown $historico - Histórico da obra
     */
    public function setHistorico($historico) {
        $this->historico = $historico;
    }

    /**
     * Obtém o modo de aquisição da obra.
     * @return modoAquisicao
     */
    public function getModoAquisicao() {
        return $this->modoAquisicao;
    }

    /**
     * Define o modo de aquisição da obra.
     * @param unknown $modoAquisicao - Modo de aquisição da obra
     */
    public function setModoAquisicao($modoAquisicao) {
        $this->modoAquisicao = $modoAquisicao;
    }

    /**
     * Obtém a data de aquisição da obra.
     * @return dataAquisicao
     */
    public function getDataAquisicao() {
        return $this->dataAquisicao;
    }

    /**
     * Define a data de aquisição da obra.
     * @param unknown $dataAquisicao - Data de aquisição da obra
     */
    public function setDataAquisicao($dataAquisicao) {
        $this->dataAquisicao = $dataAquisicao;
    }

    /**
     * Obtém o autor da obra.
     * @return autor
     */
    public function getAutor() {
        return $this->autor;
    }

    /**
     * Define o autor da obra.
     * @param unknown $autor - Autor da obra
     */
    public function setAutor($autor) {
        $this->autor = $autor;
    }

    /**
     * Obtém as observações da obra.
     * @return observacoes
     */
    public function getObservacoes() {
        return $this->observacoes;
    }

    /**
     * Define as observações da obra.
     * @param unknown $observacoes - Observações da obra
     */
    public function setObservacoes($observacoes) {
        $this->observacoes = $observacoes;
    }

    /**
     * Obtém o estado da obra.
     * @return estado
     */
    public function getEstado() {
        return $this->estado;
    }

    /**
     * Define o estado da obra.
     * @param unknown $estado - Estado da obra
     */
    public function setEstado($estado) {
        $this->estado = $estado;
    }

    /**
     * Define como os dados da classe serão utilizados na conversão para um json.
     * @return dados da classe em formato .json
     */
    public function jsonSerialize() {
        return [
            'idObra' => $this->id,
            'nome' => $this->nome,
            'titulo' => $this->titulo,
            'numInventario' => $this->numInventario,      
            'idColecao' => $this->idColecao,
            'origem' => $this->origem,
            'procedencia' => $this->procedencia,
            'idClassificacao' => $this->idClassificacao,      
            'palavrasChave' => $this->palavrasChave,
            'descricao' => $this->descricao,
            'altura' => $this->altura,
            'largura' => $this->largura,      
            'diametro' => $this->diametro,
            'peso' => $this->peso,
            'comprimento' => $this->comprimento,
            'materiais' => $this->materiais,      
            'tecnicas' => $this->tecnicas,
            'autoria' => $this->autoria,
            'marcas' => $this->marcas,
            'historico' => $this->historico,    
            'modoAquisicao' => $this->modoAquisicao,      
            'dataAquisicao' => $this->dataAquisicao,
            'autor' => $this->autor,
            'observacoes' => $this->observacoes,
            'caminhoImagem1' => $this->caminhoImagem1,      
            'caminhoImagem2' => $this->caminhoImagem2,
            'caminhoImagem3' => $this->caminhoImagem3,
            'caminhoImagem4' => $this->caminhoImagem4,
            'caminhoImagem5' => $this->caminhoImagem5,
            'caminhoModelo3D' => $this->caminhoModelo3D,                                                                                               
        ];
    }     


    /*
     * Obtém o caminho da primeira imagem da obra.
     * @return caminhoImagem1
     */
    public function getCaminhoImagem1() {
        return $this->caminhoImagem1;
    }

    /**
     * Configura o caminho da primeira imagem da obra.
     * @param unknown $caminhoImagem - Caminho da imagem
     */
    public function setCaminhoImagem1($caminhoImagem) {
        $this->caminhoImagem1 = $caminhoImagem;
    }

    /*
     * Obtém o caminho da segunda imagem da obra.
     * @return caminhoImagem2
     */
    public function getCaminhoImagem2() {
        return $this->caminhoImagem2;
    }

    /*
     * Configura o caminho da segunda imagem da obra.
     * @param unknown $caminhoImagem - Caminho da imagem
     */
    public function setCaminhoImagem2($caminhoImagem) {
        $this->caminhoImagem2 = $caminhoImagem;
    }

    /**
     * Obtém o caminho da terceira imagem da obra.
     * @return caminhoImagem3
     */
     
    public function getCaminhoImagem3() {
        return $this->caminhoImagem3;
    }

    /*
     * Configura o caminho da terceira imagem da obra.
     * @param unknown $caminhoImagem - Caminho da imagem
     */
    public function setCaminhoImagem3($caminhoImagem) {
        $this->caminhoImagem3 = $caminhoImagem;
    }

    /**
     * Obtém o caminho da quarta imagem da obra.
     * @return caminhoImagem4
     */
    public function getCaminhoImagem4() {
        return $this->caminhoImagem4;
    }

    /**
     * Configura o caminho da quarta imagem da obra.
     * @param unknown $caminhoImagem - Caminho da imagem
     */
    public function setCaminhoImagem4($caminhoImagem) {
        $this->caminhoImagem4 = $caminhoImagem;
    }

    /**
     * Obtém o caminho da quinta imagem da obra.
     * @return caminhoImagem5
     */
    public function getCaminhoImagem5() {
        return $this->caminhoImagem5;
    }

    /**
     * Configura o caminho da quinta imagem da obra.
     * @param unknown $caminhoImagem - Caminho da imagem
     */
    public function setCaminhoImagem5($caminhoImagem) {
        $this->caminhoImagem5 = $caminhoImagem;
    }

    /**
     * Obtém o caminho do modelo 3D da obra.
     * @return caminhoModelo3D
     */
    public function getCaminhoModelo3D() {
        return $this->caminhoModelo3D;
    }

    /**
     * Configura o caminho do modelo 3D da obra.
     * @param unknown $caminhoModelo - Caminho do modelo 3D
     */
    public function setCaminhoModelo3D($caminhoModelo) {
        $this->caminhoModelo3D = $caminhoModelo;
    }
}

?>