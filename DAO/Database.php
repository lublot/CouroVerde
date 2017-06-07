<?php

class Database{

    protected $PDO;
    public function __construct(){
        try{
            $this->PDO = new PDO("mysql:host=".HOST.";dbname=".NAMEDB.";charset=".CHARSETDB,USERDB,PASSDB);
        }catch(PDOException $e ){
           $e->getMessage();
        }
        
    }   
}


?>