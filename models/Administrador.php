<?php
/**
* Classe responsável por modelar um administrador no contexto do sistema
* @author MItologhic Software
*
*/
class Administrador extends Funcionario {
    private $podeVisualizarRelatorios;
    private $podeGerenciarFuncionarios;

    //Gente, precisamos ver se vamos manter essa classe mesmo. Se só tiver esses atributos é muito desn.

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
    * @param unknown $podeRealizarBackup indica se pode visualizar relatórios
	* @param unknown $podeRealizarBackup indica se pode gerenciar funcionários
	* 
	*/
    public function __construct($id,$email, $nome, $sobrenome, $senha, $$cadastroConfirmado, $matricula, $funcao, $podeCadastrarObra,$podeGerenciarObra, $podeRemoverObra, $podeCadastrarNoticia, $podeGerenciarNoticia, $podeRemoverNoticia, $podeRealizarBackup, $podeVisualizarRelatorios, $podeGerenciarFuncionarios) {
        parent::__construct($id,$email, $nome, $sobrenome, $senha, $cadastroConfirmado, $matricula, $funcao, $podeCadastrarObra,$podeGerenciarObra, $podeRemoverObra, $podeCadastrarNoticia, $podeGerenciarNoticia, $podeRemoverNoticia, $podeRealizarBackup);
        $this->podeVisualizarRelatorios = $podeVisualizarRelatorios;
        $this->podeGerenciarFuncionarios = $podeGerenciarFuncionarios;
    }


    public function isPodeVisualizarRelatorios() {
        return $this->podeVisualizarRelatorios;
    }

    public function setPodeVisualizarRelatorios($podeVisualizarRelatorios) {
        $this->podeVisualizarRelatorios = $podeVisualizarRelatorios;
    }

    public function isPodeGerenciarFuncionarios() {
        return $this->podeGerenciarFuncionarios;
    }

    public function setPodeGerenciarFuncionarios($podeGerenciarFuncionarios) {
        $this->podeGerenciarFuncionarios = $podeGerenciarFuncionarios;
    }


}
