<?php
namespace DAO;

class Database{

    protected $PDO;
    public function __construct() {
        
        define("HOST","localhost");
		define("USERDB","root");
		define("PASSDB","");
		define("NAMEDB","webMuseu");
		define('CHARSETDB', 'utf8' );
        
        try {
            $this->PDO = new \PDO("mysql:host=".HOST.";dbname=".NAMEDB.";charset=".CHARSETDB,USERDB,PASSDB);
        } catch(PDOException $e ){
           $e->getMessage();
        } 
    }   
    
}


?>