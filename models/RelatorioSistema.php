<?php

namespace models;

class RelatorioSistema{

    private $autor;
    private $acao;
    private $idAlvo;
    private $tipoAlvo;
    private $horario;

    public function __construct($autor,$acao,$idAlvo,$tipoAlvo){
        $this->autor = $autor;
        $this->acao = $acao;
        $this->idAlvo = $idAlvo;
        $this->tipoAlvo = $tipoAlvo;
        date_default_timezone_set("America/Bahia");
        $this->horario = date('Y-m-d H:i:s');
    }

    /**
    * Obtém o autor da ação
    */
    public function getAutor(){
        return $this->autor;
    }

    /**
    * Define o autor da ação
    */
    public function setAutor($dado){
        $this->autor = $dado;
    }
    
    /**
    * Obtém a ação realizada
    */
    public function getAcao(){
        return $this->acao;
    }

    /**
    * Define a ação realizada
    */
    public function setAcao($dado){
        $this->acao = $dado;
    }
    
    /**
    * Obtém o id do objeto alvo da ação
    */
    public function getIdAlvo(){
        return $this->idAlvo;
    }

    /**
    * Define o id do alvo da ação
    */
    public function setIdAlvo($dado){
        $this->idAlvo = $dado;
    }
    

    /**
    * Obtém o tipo do objeto que sofreu a ação. Ex:Obra,Funcionário,etc..
    */
    public function getTipoAlvo(){
        return $this->tipoAlvo;
    }

    /**
    * Define o tipo do objeto alvo da ação
    */
    public function setTipoAlvo($dado){
        $this->tipoAlvo = $dado;
    }


    /**
    * Obtém o horário que a ação ocorreu
    */
    public function getHorario(){
        return $this->horario;
    }

    /**
    * Define o horário que a ação ocorreu
    */
    public function setHorario($dado){
        $this->horario = $dado;
    }
}
?>