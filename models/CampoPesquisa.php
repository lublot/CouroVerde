<?php
namespace models;

/**
 * Classe responsável por representar um campo do formulario de pesquisa no contexto do sistema.
 * @author MItologhic Software
 *
 */

class CampoPesquisa {
    private $idCampo;
    private $pergunta;
    private $tipoResposta;
    private $resposta[];

    /**
     * Construtor da classe
     * @param unknown $idCampo - Id do campo     
     * @param unknown $pergunta - Nome da pergunta
     * @param unknown $tipoResposta - Tipo de resposta da pergunta
     * @param unknown $resposta - Resposta(s) da pergunta
     */
    public function __construct($idCampo, $pergunta, $tipoResposta, $resposta) {
        $this->idCampo = $idCampo;
        $this->pergunta = $pergunta;
        $this->tipoResposta = $tipoResposta;
        if (sizeof($resposta)>1){
            $size = sizeof($resposta);
            for ($value = 0; $value < $size; $value++){
                $this->resposta[$value] = $resposta[$value];
            }
        }
    }

    /**
     * Obtém o id do campo.
     * @return idCampo
     */
    public function getIdCampo(){
        return $this->idCampo;
    }

    /**
     * Obtém a pergunta.
     * @return pergunta
     */
    public function getPergunta(){
        return $this->pergunta;
    }
    
    /**
     * Configura a pergunta.
     * @param unknown $pergunta - Pergunta
     */
    public function setPergunta($pergunta){
        $this->pergunta = $pergunta;
    }

    /**
     * Obtém o tipo da resposta.
     * @return tipoResposta
     */
    public function getTipoResposta(){
        return $this->tipoResposta;
    }

    /**
     * Configura o tipo da resposta.
     * @param unknown $tipoResposta - Tipo da resposta
     */
    public function setTipoResposta($tipoResposta){
        $this->tipoResposta = $tipoResposta;
    }

    /**
     * Obtém a resposta(s).
     * @return resposta
     */
    public function getResposta(){
        return $this->resposta;
    }

    /**
     * Configura a resposta.
     * @param unknown $resposta - Resposta
     */
    public function setResposta($resposta){
        $this->resposta = $resposta;
    }
}
?>