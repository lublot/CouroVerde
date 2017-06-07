<?php
/**
 * Classe responsável por disponibilizar métodos para gerenciamento de senha.
 * @author MItologhic Software
 *
 */
class GerenciarSenha {
	
	private function __construct() {} //construtor privado para evitar instanciamento desncessário
	
	/**
	 * Criptografa uma senha com base no método MD5.
	 * @param unknown $senha senha original
	 * @return senha criptografada em md5
	 */
	public static function criptografarSenha($senha) {
		return md5($senha);
	}
	
	/**
	 * Compara se uma senha fornecida corresponde à senha armazenada no sistema.
	 * @param unknown $senha senha fornecida
	 * @param unknown $senhaArmazenada senha armazenada no sistema e já criptografada
	 * @return <code>true</code>, se as senhas forem iguais; <code>false</code>, caso contrário.
	 */
	public static function checarSenha($senha, $senhaArmazenada) {
		return strcmp(criptografarSenha($senha), $senhaArmazenada) == 0;
	}
	
	
	
}