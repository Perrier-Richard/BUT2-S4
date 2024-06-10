<?php
class Ticket {

    private $conn;
    private $db_table = "billet";

    public $page;
    public $count;

    public $id;
    public $title;
    public $content;
    public $date;

    public function __construct($db) {
        $this -> conn = $db;
    }
    // GET ALL
    public function getTickets() {
        $stmt = $this -> conn -> prepare("SELECT * FROM ". $this -> db_table ." ORDER BY date DESC LIMIT :page, :count");

        $stmt -> bindParam(":page", $this -> page, PDO::PARAM_INT);
        $stmt -> bindParam(":count", $this -> count, PDO::PARAM_INT);

        $stmt -> execute();

        return $stmt;
    }
    // CREATE
    public function createTicket() {
        $stmt = $this -> conn -> prepare("INSERT INTO ". $this -> db_table ." (titre, content) VALUES (:title, :content)");

        $stmt -> bindParam(":title", $this -> title, PDO::PARAM_STR);
        $stmt -> bindParam(":content", $this -> content, PDO::PARAM_STR);

        $stmt -> execute();

        $stmt2 = $this -> conn -> prepare("SELECT id FROM ". $this -> db_table ." ORDER BY id DESC LIMIT 0,1");
        $stmt2 -> execute();
        $result = $stmt2 -> fetchColumn();

        $this -> id = $result;

        return $stmt;
    }
    // GET
    public function getTicket() {
        $stmt = $this -> conn -> prepare("SELECT * FROM ". $this -> db_table ." WHERE id = :id LIMIT 0,1");

        $stmt -> bindParam(":id", $this -> id, PDO::PARAM_INT);

        $stmt -> execute();

        return $stmt;
    }
    // UPDATE
    public function updateTicket() {
        $stmt = $this -> conn -> prepare("UPDATE ". $this -> db_table ." SET titre = :title, content = :content WHERE id = :id");

        $stmt -> bindParam(":title", $this -> title, PDO::PARAM_STR);
        $stmt -> bindParam(":content", $this -> content, PDO::PARAM_STR);
        $stmt -> bindParam(":id", $this -> id, PDO::PARAM_INT);

        $stmt -> execute();

        return $stmt;
    }
    //ADD IMAGE
    public function addImage() {
        $stmt = $this -> conn -> prepare("UPDATE ". $this -> db_table ." SET image = :image WHERE id = :id");

        $stmt -> bindParam(":image", $this -> image, PDO::PARAM_STR);
        $stmt -> bindParam(":id", $this -> id, PDO::PARAM_INT);

        $stmt -> execute();

        return $stmt;
    }
    // DELETE
    public function deleteTicket() {
        $stmt = $this -> conn -> prepare("DELETE FROM ". $this -> db_table ." WHERE id = :id");

        $stmt -> bindParam(":id", $this -> id, PDO::PARAM_INT);

        $stmt -> execute();

        return $stmt;
    }
    // COUNT
    public function countTickets() {
        $stmt = $this -> conn -> prepare("SELECT COUNT(*) FROM ". $this -> db_table);

        $stmt -> execute();

        return $stmt;
    }

}