<?php

/**
 * Classe responsável por representar um usuário no contexto do sistema.
 * @author 
 *
 */
class Usuario {

    
    /* atributos do usuário */
    private $id;
    private $email;
    private $nome;
    private $sobrenome;
    private $senha;
    private $confirmouCadastro;

    /**
     * Construtor da classe
     * @param unknown $email email do usuário
     * @param unknown $nome nome do usuário
     * @param unknown $sobrenome sobrenome do usuário
     * @param unknown $senha senha do usuário
     * @param unknown $confirmouCadastro indica se confirmou o cadastro
     */
    public function __construct($id,$email, $nome, $sobrenome, $senha, $confirmouCadastro) {
        $this->$id;
        $this->email = $email;
        $this->nome = $nome;
        $this->sobrenome = $sobrenome;
        $this->senha = $senha;
        $this->estaAtivo = $confirmouCadastro;
    }

    /**
     * Obtém o id do usuário.
     * @return id
     */
    public function getId() {
        return $id;
    }

    /**
     * Obtém o email do usuário.
     * @return email
     */
    public function getEmail() {
        return $email;
    }

    /**
     * Configura o email do usuário.
     * @param unknown $email email do usuário
     */
    public function setEmail($email) {
        $this->email = $email;
    }

    /**
     * Obtém o nome do usuário.
     * @return nome
     */
    public function getNome() {
        return $nome;
    }

    /**
     * Configura o nome do usuário.
     * @param unknown $nome nome do usuário
     */
    public function setNome($nome) {
        $this->nome = $nome;
    }

    /**
     * Obtém o sobrenome do usuário.
     * @return sobrenome
     */
    public function getSobrenome() {
        return $sobrenome;
    }

    /**
     * Configura o sobrenome do usuário.
     * @param unknown $sobrenome sobrenome do usuário
     */
    public function setSobrenome($sobrenome) {
        $this->sobrenome = $sobrenome;
    }

    /**
     * Obtém a senha do usuário.
     * @return senha
     */
    public function getSenha() {
        return $senha;
    }

    /**
     * Configura a senha do usuário.
     * @param unknown $senha senha do usuário
     */
    public function setSenha($senha) {
        $this->senha = $senha;
    }

    /**
     * Verifica se o usuário confirmou o cadastro.
     * @return <code>true</code>, se ele confirmou o cadastro; <code>false</code>, caso contrário
     */
    public function isAtivo() {
        return $confirmouCadastro;
    }

    /**
     * Configura se o usuário confirmou o cadastro.
     * @param unknown $confirmouCadastro indicação se o usuário confirmou o cadastro
     */
    public function setEstaAtivo($confirmouCadastro) {
        $this->estaAtivo = $confirmouCadastro;
    }

}

?>