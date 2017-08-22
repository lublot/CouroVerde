<?php
namespace util;

if(!isset($_SESSION)){session_start();}

/**
 * Classe responsável por disponibilizar métodos para verificar permissionamento.
 * @author MItologhic Software
 *
 */
class VerificarPermissao {
	private function __construct() {} //construtor privado para evitar instanciamento desncessário
	
	/**
	 * Verifica se um usuário é administrador.
	 * @return <code>true</code>, se o usuário atual for administrador; <code>false</code>, caso contrário.
	 */
	public static function isAdministrador() {
	    return isset($_SESSION['administrador']) && (strcmp($_SESSION['tipoUsuario'],"ADMINISTRADOR")==0);
	}

	/**
	 * Verifica se um usuário é funcionário.
	 * @return <code>true</code>, se o usuário atual for funcionario; <code>false</code>, caso contrário.
	 */
	public static function isFuncionario() {
	    return isset($_SESSION['administrador']) || ($_SESSION['tipoUsuario'] == "FUNCIONARIO");            
    }

	/**
	 * Verifica se um usuário pode cadastrar obra.
	 * @return <code>true</code>, se o usuário atual pode cadastrar obra; <code>false</code>, caso contrário.
	 */
	public static function podeCadastrarObra() {
	    return (self::isFuncionario() || self::isAdministrador()) && isset($_SESSION['podeCadastrarObra']) && $_SESSION['podeCadastrarObra'];
	}        

	/**
	 * Verifica se um usuário pode gerenciar obra.
	 * @return <code>true</code>, se o usuário atual pode gerenciar obra; <code>false</code>, caso contrário.
	 */
	public static function podeGerenciarObra() {
	    return isset($_SESSION['podeGerenciarObra']) && $_SESSION['podeGerenciarObra'];
	}     

	/**
	 * Verifica se um usuário pode remover obra.
	 * @return <code>true</code>, se o usuário atual pode remover obra; <code>false</code>, caso contrário.
	 */
	public static function podeRemoverObra() {
	    return isset($_SESSION['podeRemoverObra']) && $_SESSION['podeRemoverObra'];
	}    

	/**
	 * Verifica se um usuário pode cadastrar notícia.
	 * @return <code>true</code>, se o usuário atual pode cadastrar notícia; <code>false</code>, caso contrário.
	 */
	public static function podeCadastrarNoticia() {
	    return isset($_SESSION['podeCadastrarNoticia']) && $_SESSION['podeCadastrarNoticia'];
	}   

	/**
	 * Verifica se um usuário pode gerenciar notícia.
	 * @return <code>true</code>, se o usuário atual pode gerenciar notícia; <code>false</code>, caso contrário.
	 */
	public static function podeGerenciarNoticia() {
	    return isset($_SESSION['podeGerenciarNoticia']) && $_SESSION['podeGerenciarNoticia'];
	}     
    
	/**
	 * Verifica se um usuário pode remover notícia.
	 * @return <code>true</code>, se o usuário atual pode remover notícia; <code>false</code>, caso contrário.
	 */
	public static function podeRemoverNoticia() {
	    return isset($_SESSION['podeRemoverNoticia']) && $_SESSION['podeRemoverNoticia'];
	}       

	/**
	 * Verifica se um usuário pode realizar backup.
	 * @return <code>true</code>, se o usuário atual pode realizar backup; <code>false</code>, caso contrário.
	 */
	public static function podeRealizarBackup() {
	    return isset($_SESSION['podeRealizarBackup']) && $_SESSION['podeRealizarBackup'];
	}  

}


?>