<?php
namespace models;

/**
* Classe responsável por modelar um funcionário no contexto do sistema
* @author MItologhic Software
*
*/
class Funcionario extends Usuario {
	
	private $matricula;
	private $funcao;
	private $podeCadastrarObra;
	private $podeGerenciarObra;
	private $podeRemoverObra;
	private $podeCadastrarNoticia;
	private $podeGerenciarNoticia;
	private $podeRemoverNoticia;
	private $podeRealizarBackup;
	
	/**
	* Construtor da classe
	* @param unknown $email email do usuário
	* @param unknown $nome nome do usuário
	* @param unknown $sobrenome sobrenome do usuário
	* @param unknown $senha senha do usuário
	* @param unknown $matricula matrícula do funcionário
	* @param unknown $funcao função do funcionário no museu
	* @param unknown $podeCadastrarObra indica se pode cadastrar obra
	* @param unknown $podeGerenciarObra indica se pode gerenciar obra
	* @param unknown $podeRemoverObra indica se pode remover obra
	* @param unknown $podeCadastrarNoticia indica se pode cadastrar notícia
	* @param unknown $podeGerenciarNoticia indica se pode gerenciar notícia
	* @param unknown $podeRealizarBackup indica se pode realizar backup
	* 
	*/
	public function __construct($id,$email, $nome, $sobrenome, $senha, $cadastroConfirmado, $matricula, $funcao, $podeCadastrarObra,$podeGerenciarObra, $podeRemoverObra, $podeCadastrarNoticia, $podeGerenciarNoticia, $podeRemoverNoticia, $podeRealizarBackup) {
		parent::__construct($id, $email, $nome, $sobrenome, $senha, $cadastroConfirmado);
		$this->matricula = $matricula;
		$this->funcao = $funcao;
		$this->podeCadastrarObra = $podeCadastrarObra;
		$this->podeGerenciarObra = $podeGerenciarObra;
		$this->podeRemoverObra = $podeRemoverObra;
		$this->podeCadastrarNoticia = $podeCadastrarNoticia;
		$this->podeGerenciarNoticia = $podeGerenciarNoticia;
		$this->podeRealizarBackup = $podeRealizarBackup;

	}
	
	/**
	* Obtém matrícula do funcionário.
	* @return matricula
	*/
	public function getMatricula() {
		return $this->matricula;
	}
	
	/**
	* Configura a matrícula do funcionário.
	* @param unknown $matricula matrícula do funcionário
	*/
	public function setMatricula($matricula) {
		$this->matricula = matricula;
	}
	
	/**
	* Obtém a função do funcionário no museu.
	* @return funcao
	*/
	public function getFuncao() {
		return $this->funcao;
	}
	
	/**
	* Configura a função do funcionário.
	* @param unknown $funcao função do funcionário
	*/
	public function setFuncao($funcao) {
		$this->funcao = $funcao;
	}
	
	/**
	* Verifica se o funcionário pode cadastrar obras.
	* @return <code>true</code>, caso possa cadadastrar obras; <code>false</code>, caso contrário.
	*/
	public function isPodeCadastrarObra() {
		return $this->podeCadastrarObra;
	}
	
	/**
	* Configura se o funcionário pode cadastrar obras.
	* @param unknown $podeCadastrarObra indicação se o funcionário pode cadastrar obras
	*/
	public function setPodeCadastrarObra($podeCadastrarObra) {
		$this->podeCadastrarObra = $podeCadastrarObra;
	}

	/**
	* Verifica se o funcionário pode gerenciar obras.
	* @return <code>true</code>, caso possa gerenciar obras; <code>false</code>, caso contrário.
	*/
	public function isPodeGerenciarObra() {
		return $this->podeGerenciarObra;
	}
	
	/**
	* Configura se o funcionário pode gerenciar obras.
	* @param unknown $podeGerenciarObra indicação se o usuário pode gerenciar obras
	*/
	public function setPodeGerenciarObra($podeGerenciarObra) {
		$this->podeGerenciarObra = $podeGerenciarObra;
	}
	
	/**
	* Verifica se o funcionário pode remover obras.
	* @return <code>true</code>, caso possa remover obras; <code>false</code>, caso contrário.
	*/
	public function isPodeRemoverObra() {
		return $this->podeRemoverObra;
	}
	
	/**
	* Configura se o usuário pode remover obras.
	* @param unknown $podeRemoverObra indicação se o funcionário pode remover obras
	*/
	public function setPodeRemoverObra($podeRemoverObra) {
		$this->podeRemoverObra = $podeRemoverObra;
	}
	
	/**
	* Verifica se o funcionário pode cadastrar notícias.
	* @return <code>true</code>, caso possa cadastrar notícias; <code>false</code>, caso contrário.
	*/
	public function isPodeCadastrarNoticia() {
		return $this->podeCadastrarNoticia;
	}
	
	/**
	* Configura se o funcionário pode cadastrar notícias.
	* @param unknown $podeCadastrarNotícia indica se o funcionário pode cadastrar notícia.
	*/
	public function setPodeCadastrarNoticia($podeCadastrarNoticia) {
		$this->podeCadastrarNoticia = $podeCadastrarNoticia;
	}
	
	/**
	* Verifica se o funcionário pode gerenciar notícias.
	* @return <code>true</code>, caso possa gerenciar notícias; <code>false</code>, caso contrário.
	*/
	public function isPodeGerenciarNoticia() {
		return $this->podeGerenciarNoticia;
	}
	
	/**
	* Configura se o funcionário pode gerenciar notícias.
	* @param unknown $podeGerenciarNoticia indicação se o funcionário pode gerenciar notícias.
	*/
	public function setPodeGerenciarNoticia($podeGerenciarNoticia) {
		$this->podeGerenciarNoticia = $podeGerenciarNoticia;
	}
	
	/**
	* Verifica se o funcionário pode remover notícias.
	* @return <code>true</code>, caso possa remover notícias; <code>false</code>, caso contrário.
	*/
	public function isPodeRemoverNoticia() {
		return $this->podeRemoverNoticia;
	}
	
	/**
	* Configura se o funcionário pode remover notícias.
	* @param unknown $podeRemoverNoticia indicação se o funcionário pode remover notícias.
	*/
	public function setPodeRemoverNoticia($podeRemoverNoticia) {
		$this->podeRemoverNoticia = $podeRemoverNoticia;
	}
	
	/**
	* Verifica se o funcionário pode realizar backup.
	* @return <code>true</code>, caso possa realizar backups; <code>false</code>, caso contrário.
	*/
	public function isPodeRealizarBackup() {
		return $this->podeRealizarBackup;
	}
	
	/**
	* Configura se o funcionário pode  realizar backups.
	* @param unknown $podeRealizarBackup indicação se o funcionário pode realizar backup.
	*/
	public function setPodeRealizarBackup($podeRealizarBackup) {
		$this->podeRealizarBackup = $podeRealizarBackup;
	}
	
	
}
