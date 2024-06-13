<?php
class Database {
    private $host = "localhost";
    private $database_name = "projet_blog";
    private $username = "root";
    private $password = "";//"DjYp$2Hrv+";
    public $conn;
    public function getConnection(){
        $this -> conn = null;
        try {
            $this -> conn = new PDO(
                "mysql:host=".$this -> host.
                ";dbname=".$this -> database_name,
                $this -> username,
                $this -> password
            );
            $this -> conn -> exec("set names utf8");
        } catch ( PDOException $e ) {
            echo "Could not connect to database : ". $e -> getMessage();
        }
        return $this -> conn;
    }
}