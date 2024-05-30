<?php
class Comment {

    private $conn;
    private $db_table = "commentaire";

    public $page;
    public $count;

    public $id;
    public $pseudo;
    public $commentaire;
    public $billet_id;
    public $date;

    public function __construct($db) {
        $this -> conn = $db;
    }
    // GET
    public function getComments() {
        $stmt = $this -> conn -> prepare('SELECT * FROM '. $this -> db_table .' WHERE billet_id = :billet_id ORDER BY date DESC LIMIT :page, :count');

        $stmt -> bindParam(":billet_id", $this -> billet_id, PDO::PARAM_INT);
        $stmt -> bindParam(":page", $this -> page, PDO::PARAM_INT);
        $stmt -> bindParam(":count", $this -> count, PDO::PARAM_INT);

        $stmt -> execute();

        return $stmt;
    }
    // CREATE
    public function createComment() {
        $stmt = $this -> conn -> prepare('INSERT INTO '. $this -> db_table .' (pseudo, commentaire, billet_id) VALUES (:pseudo, :commentaire, :billet_id)');

        $stmt -> bindParam(":pseudo", $this -> pseudo, PDO::PARAM_STR);
        $stmt -> bindParam(":commentaire", $this -> commentaire, PDO::PARAM_STR);
        $stmt -> bindParam(":billet_id", $this -> billet_id, PDO::PARAM_INT);

        $stmt -> execute();

        return $stmt;
    }
    // DELETE
    public function deleteComment() {
        $stmt = $this -> conn -> prepare('DELETE FROM '. $this -> db_table .' WHERE id = :id');

        $stmt -> bindParam(":id", $this -> id, PDO::PARAM_INT);

        $stmt -> execute();

        return $stmt;
    }
    // COUNT
    public function countComments() {
        $stmt = $this -> conn -> prepare('SELECT COUNT(*) FROM '. $this -> db_table .' WHERE billet_id = :billet_id');

        $stmt -> bindParam(":billet_id", $this -> billet_id, PDO::PARAM_INT);

        $stmt -> execute();

        return $stmt;
    }

}
