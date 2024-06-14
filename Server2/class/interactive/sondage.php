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

        $stmt2 = $conn -> prepare("DELETE FROM ". Element::$user_table ." WHERE billet_content = :billet_content");

        $stmt2 -> bindParam(":billet_content", $id, PDO::PARAM_INT);

        $stmt2 -> execute();

        return $stmt;
	}

	public function convertToHtml() { return convertToHtmlAbstract(); }
	
	protected function convertToHtmlAbstract(){
		$conn = parent::getConn();
		$billet = parent::getBillet();

		$id = parent::getId();

		$html = '<form class="'.parent::getType().'">';

		if (isset($_SESSION['LOGGED_USER'])) {
			$userValueExit = Element::getUserInteraction($conn, $_SESSION['LOGGED_USER'], $billet, $id);
			if(count($userValueExit) > 0){
				$userValue = $userValueExit[0]['value'];

				$allUserValue = $this -> getStats($conn, $billet, $id);
				$totalUserValue = 0;

				for($i = 0; $i < count($allUserValue); $i++){
					$totalUserValue += $allUserValue[$i][1];
				}
			}
		}

		$value = explode(",", parent::getContent());

		for($i = 0; $i < count($value); $i++){
			if(empty($value)) continue;
			$html .= '<div class="sondage-choice">';

			if(isset($userValue)){
				$find = false;
				for($j = 0; $j < count($allUserValue); $j++){
					if($value[$i] == $allUserValue[$j][0]){
						$html .= '<p>'.round(($allUserValue[$j][1] / $totalUserValue) * 100).'%</p>';
						$find = true;
						break;
					}
				}
				if($find == false) $html .= '<p>0%</p>';
			}

			if(isset($userValue) && $value[$i] == $userValue){
				$html .= '<input type="radio" name="'.$id.'" checked disabled>';
			}
			else if(isset($userValue)){
				$html .= '<input type="radio" name="'.$id.'" disabled>';
			}	
			else{
				$html .= '<input type="radio" name="'.$id.'">';
			}
			$html .= '<label>'.$value[$i].'</label>';
			$html .= '</div>';
		}

		$html .= '</form>';

		return $html;
	}

	public function getStats($db, $billet, $billet_content){
		$stmt = $db -> prepare("SELECT value, COUNT(*) FROM ". Element::$user_table ." WHERE billet = :billet AND billet_content = :billet_content GROUP BY value");

		$stmt -> bindParam(":billet", $billet, PDO::PARAM_INT);
		$stmt -> bindParam(":billet_content", $billet_content, PDO::PARAM_INT);

		$stmt -> execute();

		return $stmt -> fetchAll();
	}

	public function getId() { return parent::getId(); }
	public function setId($id) { parent::setId($id); }

	public function setContent($content) { parent::setContent($content); }
}