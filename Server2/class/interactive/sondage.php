<?php

class Sondage extends Element{

	public static $type = "sondage-div";

	public function __construct($db){
		parent::__construct($db);
	}

	public function create() { $this -> createAbstract(); }
	public function update() { $this -> updateAbstract(); }
	public function delete() { $this -> deleteAbstract(); }

	protected function createAbstract(){
		$conn = parent::getConn();
		$table = parent::getTable();

		$billet = parent::getBillet();
		$type = parent::getType();
		$content = parent::convertArrayToString(parent::getContent());

        $stmt = $conn -> prepare("INSERT INTO ". $table ." (billet, type, content) VALUES (:billet, :type, :content)");

        $stmt -> bindParam(":billet", $billet, PDO::PARAM_INT);
        $stmt -> bindParam(":type", $type, PDO::PARAM_STR);
        $stmt -> bindParam(":content", $content, PDO::PARAM_STR);

        $stmt -> execute();

        $stmt2 = $conn -> prepare("SELECT id FROM ". $table ." ORDER BY id DESC LIMIT 0,1");
        $stmt2 -> execute();
        $result = $stmt2 -> fetchColumn();

        parent::setId($result);
	}

	protected function updateAbstract(){
        // $stmt = $this -> conn -> prepare("UPDATE ". $this -> db_table ." SET billet = :billet, type = :type, content = :content WHERE id = :id");

        // $stmt -> bindParam(":billet", $this -> title, PDO::PARAM_INT);
        // $stmt -> bindParam(":type", $this -> title, PDO::PARAM_STR);
        // $stmt -> bindParam(":content", $this -> content, PDO::PARAM_STR);
        // $stmt -> bindParam(":id", $this -> id, PDO::PARAM_INT);

        // $stmt -> execute();

        // return $stmt;
	}

	protected function deleteAbstract(){
        // $stmt = $this -> conn -> prepare("DELETE FROM ". $this -> db_table ." WHERE id = :id");

        // $stmt -> bindParam(":id", $this -> id, PDO::PARAM_INT);

        // $stmt -> execute();

        // return $stmt;
	}

	public function convertToHtml() { return convertToHtmlAbstract(); }
	
	protected function convertToHtmlAbstract(){
		$html = '<div class="'.parent::getType().'">';

		$value = explode(",", parent::getContent());
		for($i = 0; $i < count($value); $i++){
			if(empty($value)) continue;
			$html .= '<div class="sondage-choice">';
			$html .= '<input type="radio">';
			$html .= '<label>'.$value[$i].'</label>';
			$html .= '</div>';
		}

		$html .= '</div>';

		return $html;
	}

	public function getId(){ return parent::getId(); }

	public function setContent($content) { parent::setContent($content); }
}