<?php
namespace models;
/**
 * Classe responsável por representar um formulario de pesquisa no contexto do sistema.
 * @author MItologhic Software
 *
 */
class Opcao implements \JsonSerializable{
    
    private $idOpcao;
    private $descricao;

    /**
     * Construtor da classe
     * @param unknown $idOpcao - Id da opção da pergunta  
     * @param unknow $descricao - Descrição da opção 
     */
    public function __construct($idOpcao, $descricao) {
        $this->idOpcao = $idOpcao;
        $this->descricao = $descricao;
    }

     /**
     * Obtém o id da opção.
     * @return idOpcao
     */
    public function getIdOpcao(){
        return $this->idOpcao;
    }

    /**
     * Obtém a descrição da opção.
     * @return descrição
     */
    public function getDescricao(){
        return $this->descricao;
    }

    public function jsonSerialize(){
        return [
            "idOpcao"=> $this->getIdOpcao(),
            "descricao"=>$this->getDescricao()
        ];
    }
}

?>