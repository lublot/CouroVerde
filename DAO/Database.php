<?php
namespace DAO;

class Database{

    protected $PDO;
    private $host;
    private $user;
    private $password;
    private $name;
    private $charset;

    public function __construct() {
        $this->host = "localhost";
        $this->user = "root";
        $this->password = "";
        $this->name = "webMuseu";
        $this->chartset = "utf8";

        try {
            $this->PDO = new \PDO("mysql:host=".$this->host.";dbname=".$this->name.";chartset=".$this->charset, $this->user, $this->password);
            //$this->PDO = new \PDO("mysql:host=".HOST.";dbname=".NAMEDB.";charset=".CHARSETDB,USERDB,PASSDB);
        } catch(PDOException $e ){
           $e->getMessage();
        } 
    }
    
}


?>