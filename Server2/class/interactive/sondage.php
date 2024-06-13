<?php

class Sondage extends Element{

	public static $type = "sondage-div";

	public function __construct($db){
		parent::__construct($db);
	}

	public function create() { return $this -> createAbstract(); }
	public function update() { return $this -> updateAbstract(); }
	public function delete() { return $this -> deleteAbstract(); }

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
		$conn = parent::getConn();
		$table = parent::getTable();

		$billet = parent::getBillet();
		$type = parent::getType();
		$content = parent::convertArrayToString(parent::getContent());
		$id = parent::getId();

        $stmt = $conn -> prepare("UPDATE ". $table ." SET billet = :billet, type = :type, content = :content WHERE id = :id");

        $stmt -> bindParam(":billet", $billet, PDO::PARAM_INT);
        $stmt -> bindParam(":type", $type, PDO::PARAM_STR);
        $stmt -> bindParam(":content", $content, PDO::PARAM_STR);
        $stmt -> bindParam(":id", $id, PDO::PARAM_INT);

        $stmt -> execute();

        return $stmt;
	}

	protected function deleteAbstract(){
		$conn = parent::getConn();
		$table = parent::getTable();

		$id = parent::getId();

        $stmt = $conn -> prepare("DELETE FROM ". $table ." WHERE id = :id");

        $stmt -> bindParam(":id", $id, PDO::PARAM_INT);

        $stmt -> execute();

        return $stmt;
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

	public function getId() { return parent::getId(); }
	public function setId($id) { parent::setId($id); }

	public function setContent($content) { parent::setContent($content); }
}