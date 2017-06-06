<?php

class Usuario {

    //Adicionei um método
    
    /* atributos do usuário */
    private $id;
    private $email;
    private $nome;
    private $sobrenome;
    private $senha;
    private $estaAtivo;
    private static $contId = 0;

    //construtor da classe
    public function __construct($email, $nome, $sobrenome, $senha, $estaAtivo) {
        $this->geraId();
        $this->email = $email;
        $this->nome = $nome;
        $this->sobrenome = $sobrenome;
        $this->senha = $senha;
        $this->estaAtivo = $estaAtivo;
    }

    private function gerarId() { //gera o id do usuário
        $this->id = $contId;
        Usuario::$contId++;
    }

    /*Getters e setters necessários*/
    public function getId() {
        return $id;
    }

    public function getEmail() {
        return $email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getNome() {
        return $nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getSobrenome() {
        return $sobrenome;
    }

    public function setSobrenome($sobrenome) {
        $this->sobrenome = $sobrenome;
    }

    public function getSenha() {
        return $senha;
    }

    public function setSenha($senha) {
        $this->senha = $senha;
    }

    public function isAtivo() {
        return $estaAtivo;
    }

    public function setEstaAtivo($estaAtivo) {
        $this->estaAtivo = $estaAtivo;
    }

}

?>