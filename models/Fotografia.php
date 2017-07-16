<?php
namespace models;

/**
* Classe responsável por representar uma obra fotográfica no contexto do sistema
* @author MItologhic Software
*
*/
class Fotografia extends Obra {
    private $fotografo;
    private $dataFotografia;
    private $autorFotografia;

    /**
	* Construtor da classe
	* @param unknown $fotografia - Fotógrafo da obra
	* @param unknown $dataFotografia - Data em que a fotografia foi tirada
	* @param unknown $autorFotografia - Autor da fotografia
	* 
	*/
    public function __construct($numInventario, $nome, $titulo, $funcao, $origem, $procedencia, $descricao, $idColecao, $idClassificacao,
                                $altura, $largura, $diametro, $peso, $comprimento, $materiais, $tecnicas, $autoria, $marcas, $historico, 
                                $modoAquisicao, $dataAquisicao, $autor, $observacoes, $estado, $fotografo, $dataFotografia, $autorFotografia) {
                                    
        parent::__construct($numInventario, $nome, $titulo, $funcao, $origem, $procedencia, $descricao, $idColecao, $idClassificacao,
                                $altura, $largura, $diametro, $peso, $comprimento, $materiais, $tecnicas, $autoria, $marcas, $historico, 
                                $modoAquisicao, $dataAquisicao, $autor, $observacoes, $estado);

        $this->fotografo = $fotografo;
        $this->dataFotografia = $dataFotografia;
        $this->autorFotografia = $autorFotografia;
    }

    /**
     * Obtém o fotógrafo da obra.
     * @return fotografo
     */
    public function getFotografo() {
        return $this->fotografo;
    }

    /**
     * Define o fotógrafo da obra.
     * @param unknown $fotografo - Fotógrafo da obra
     */
    public function setFotografo($fotografo) {
        $this->fotografo = $fotografo;
    }

    /**
     * Obtém o data da fotografia.
     * @return dataFotografia
     */
    public function getDataFotografia() {
        return $this->dataFotografia;
    }

    /**
     * Define a data da fotografia.
     * @param unknown $dataFotografia - Data da fotografia
     */
    public function setDataFotografia($dataFotografia) {
        $this->dataFotografia = $dataFotografia;
    }

    /**
     * Obtém o autor da fotografia.
     * @return autorFotografia
     */
    public function getAutorFotografia() {
        return $this->autorFotografia;
    }

    /**
     * Define o autor da fotografia.
     * @param unknown $autorFotografia - Autor da fotografia
     */
    public function setAutorFotografia($autorFotografia) {
        $this->autorFotografia = $autorFotografia;
    }
}

?>