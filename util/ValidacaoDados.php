<?php
namespace util;

/**
 * Classe responsável por disponibilizar métodos que permitem a validação de dados informados pelo usuário.
 * @author MItologhic Software
 *
 */
class ValidacaoDados {
	
	private function __construct() {} //construtor privado para evitar instanciamento desncessário

    /**
    *Verifica a integridade do array de informações recebidas
    *@return <code>true</code>, se o array estiver íntegro; <code>false</code>, caso contrário
    */
    public static function validarForm($array,$chaves){
        foreach($chaves as $chave){
            if(!array_key_exists($chave,$array) || empty($array[$chave])){
                return false;
            }
        }
        return true;
    }

    
    /**
    * Verifica se determinado campo tem informação.
    * @return <code>true</code>, se houver informação; <code>false</code>, caso contrário
    */
    public static function validarCampo($campo) {
        if ($campo != null && isset($campo) && !empty($campo)) {
            return true;
        }
        return false;
    }

    /**
    * Verifica se o nome informado é válido.
    * @return <code>true</code>, se o nome informado for válido; <code>false</code>, caso contrário
    */
    public static function validarNome($nome) {
        if (!ValidacaoDados::validarCampo($nome)) {
            return false;
        }

        $aux = $nome;
        $aux = str_replace(' ','',$aux); 
        if(strlen($aux)==0){
            return false;
        }

        if (preg_match("([^ A-Za-zà-ú'])", $nome) > 0) { //O nome só pode conter letras e caracteres acentuados,espaços e aspas simples
            return false;
        }
        return true;
    }


    /**
    * Verifica se o email informado é válido.
    * @return <code>true</code>, se o email informado for válido; <code>false</code>, caso contrário.
    */
    public static function validarEmail($email) {
        if (!ValidacaoDados::validarCampo($email)) {
            return false;
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return true;
    }

    /**
    * Verifica se a senha informada é válida, isto é, se possui ao menos 8 e no máximo 32 caracteres.
    * @return <code>true</code>, se a senha informada for válida; <code>false</code>, caso contrário.
    */
    public static function validarSenha($senha) {
        if (!ValidacaoDados::validarCampo($senha)) {
            return false;
        }

        $tamanho = strlen($senha); //obtém tamanho da senha
        if ($tamanho >= 8 && $tamanho <= 32) { //verifica se o tamanho da senha é adequado
            return true;
        }

        return false;
    }    

    /**
    * Verifica se a senha informada contém espaços.
    * @return <code>true</code>, se a senha informada for válida; <code>false</code>, caso contrário.
    */
    public static function contemEspacos($senha){
        return strpos($senha," ") > -1; // Retorna true se a senha contém espaços
    }
    /**
    *Verifica a integridade do array de informações para a redefinicão de senha
    *@return <code>true</code>, se o array estiver íntegro; <code>false</code>, caso contrário
    */
    public static function validarFormRedefinir($dados) {
        if(array_key_exists("senha", $dados) && array_key_exists("confirmarSenha", $dados)) {
            return true;
        }
        return false;
    }

    /**
    *Verifica a integridade do array do e-mail recebido
    *@return <code>true</code>, se o array estiver íntegro; <code>false</code>, caso contrário
    */
    public static function validarFormEmail($dados) {
        if(array_key_exists("email", $dados)) {
            return true;
        }
        return false;
    }

    /**
    * Verifica se a matricula informada é válida, isto é, se possui ao menos somente números.
    * @return <code>true</code>, se a matrícula informada for válida; <code>false</code>, caso contrário.
    */
    public static function validarMatricula($matricula) {
        if (!ValidacaoDados::validarCampo($matricula)) {
            return false;
        }

        if(!is_numeric($matricula)){
            return false;
        }
        else{
            return true;
        }
    }

    /**
    * Recebe uma data no formato SQL e transforma em um formato usual
    * @param $data - A data a ser formatada
    * @return $dataFormatada - A data formatada;
    */
    public static function formatarDataSQLparaPadrao($data){
        $dataFormatada = explode('-', $data);
        $dataFormatada = $dataFormatada[2].'/'.$dataFormatada[1].'/'.$dataFormatada[0];
        return $dataFormatada;
    }

    /**
    * Verifica se o texto é vazio
    * @param $campo - O texto para ser testado
    * @return Retorna true se o campo for vazio.
    * */
    public static function campoVazio($campo){
        $string = preg_replace('/\s+/', '', $campo);
        return strlen($string) == 0;
    }

    /**
    * Verifica se uma data informada é válida.
    * @param $data - A data que será testada
    * @return <code>true</code>, se a data informada for válida; <code>false</code>, caso contrário.
    */
    public static function validarData($data){
        $data = explode("/","$data"); // fatia a string $data em pedaços, usando / como referência

        if(isset($data[0]) && isset($data[1]) && $data[2]) {
            $d = $data[0];
            $m = $data[1];
            $y = $data[2];
        
            $res = checkdate($m,$d,$y);
            if ($res == 1){
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }

    /**
    * Verifica se uma hora informada é válida.
    * @param $hora - A hora que será testada
    * @return <code>true</code>, se a hora informada for válida; <code>false</code>, caso contrário.
    */
    public static function validarHora($hora){
        $hora = explode(":", $hora);

        if(count($hora) == 3) {
            return (isset($hora[0]) && is_numeric($hora[0]) && isset($hora[1]) && is_numeric($hora[1]) && isset($hora[2]) && is_numeric($hora[2]));
        } else {
            return false;
        }
    }        
}