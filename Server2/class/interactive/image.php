<?php

//include_once("element.php");

class Image extends Element{

	public static $type = "image-div";

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
		$content = parent::getContent();

        $stmt = $conn -> prepare("INSERT INTO ". $table ." (billet, type, content) VALUES (:billet, :type, :content)");

        $stmt -> bindParam(":billet", $billet, PDO::PARAM_INT);
        $stmt -> bindParam(":type", $type, PDO::PARAM_STR);
        $stmt -> bindParam(":content", $content[0], PDO::PARAM_STR);

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
		$content = parent::getContent();
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

		$content = parent::getContent();
		$id = parent::getId();

		if ($content != null) {
            unlink('../../../Images/ticket_image/' . $content);
        }

        $stmt = $conn -> prepare("DELETE FROM ". $table ." WHERE id = :id");

        $stmt -> bindParam(":id", $id, PDO::PARAM_INT);

        $stmt -> execute();

        return $stmt;
	}
 
	public function convertToHtml() { return convertToHtmlAbstract(); }

	protected function convertToHtmlAbstract(){
		$html = '<div class="'.parent::getType().'">';
		$html .= '<div class="image-preview">';
		$html .= '<img src="Images/ticket_image/'.parent::getContent().'" style="width: 100%">';
		$html .= '</div>';
		$html .= '</div>';

		return $html;
	}

	public function getId() { return parent::getId(); }
	public function setId($id) { parent::setId($id); }

	public function setContent($content) { parent::setContent($content); }

}