<?php

class User {

    private $conn;
    private $db_table = "user";

    public $id;
    public $username;
    public $password;

    public function __construct($db) {
        $this -> conn = $db;
    }

    public function getUser() {
        $stmt = $this -> conn -> prepare('SELECT * FROM '. $this -> db_table .' WHERE username = :username AND password = :password');

        $stmt -> bindParam(":username", $this -> username, PDO::PARAM_STR);
        $stmt -> bindParam(":password", $this -> password, PDO::PARAM_STR);

        $stmt -> execute();

        return $stmt;
    }

    public function getUserFromId() {
        $stmt = $this -> conn -> prepare('SELECT * FROM '. $this -> db_table .' WHERE id = :id');

        $stmt -> bindParam(":id", $this -> id, PDO::PARAM_INT);

        $stmt -> execute();

        return $stmt;
    }

    public function updateUser() {
        $stmt = $this -> conn -> prepare('UPDATE '.$this -> db_table.' SET username = :username, password = :password WHERE id = :id');

        $stmt -> bindParam(":username", $this -> username, PDO::PARAM_STR);
        $stmt -> bindParam(":password", $this -> password, PDO::PARAM_STR);
        $stmt -> bindParam(":id", $this -> id, PDO::PARAM_INT);

        $stmt -> execute();
    }

}