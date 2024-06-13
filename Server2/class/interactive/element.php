<?php

abstract class Element{
	
    private $conn;
    private $db_table;
    public static $table = "billet_content";

	private $id;
	private $billet;
	private $type;
	private $content;

	public function __construct($db){
		$this -> conn = $db;
		$this -> db_table = Element::$table;
	}

	abstract protected function createAbstract();
	abstract protected function updateAbstract();
	abstract protected function deleteAbstract();

	abstract protected function convertToHtmlAbstract();

	public static function getBilletContent($db, $billet, $html){
        $stmt = $db -> prepare("SELECT id, type, content FROM ". Element::$table ." WHERE billet = :billet");

        $stmt -> bindParam(":billet", $billet, PDO::PARAM_INT);

        $stmt -> execute();

        $elements = $stmt -> fetchAll();

        if(!$html) return $elements;

        $result = array();

        for($i = 0; $i < count($elements); $i++) {
        	$element = Element::buildContent($db, $billet, $elements[$i]['type'], $elements[$i]['content']);
        	if($element == null) continue;
        	$element -> setId($elements[$i]['type']);

        	array_push($result, $element -> convertToHtmlAbstract());
        }

        return $result;
	}

	public static function buildContent($db, $billet, $type, $content){
		$element = null;

		if($type == Text::$type) $element = new Text($db);
		if($type == Sondage::$type) $element = new Sondage($db);
		if($type == Image::$type) $element = new Image($db);

	    if ($element) {
            $element -> setBillet($billet);
            $element -> setType($type);
            $element -> setContent($content);
        }

		return $element;
	}

	protected function convertArrayToString($content){
		if($content == null or $content == "" or count($content) == 0) return "";

		$str = "";

		for($i = 0; $i < count($content) - 1; $i++){
			$str .= $content[$i].",";
		}
		$str .= $content[count($content) - 1];

		return $str;
	}

    protected function getElement() {
        $stmt = $this -> conn -> prepare("SELECT * FROM ". $this -> db_table ." WHERE id = :id LIMIT 0,1");

        $stmt -> bindParam(":id", $this -> id, PDO::PARAM_INT);

        $stmt -> execute();

        return $stmt;
    }

	protected function setId($id){
		$this -> id = $id;
	} 

	protected function getId(){
		return $this -> id;
	}

	protected function setBillet($billet){
		$this -> billet = $billet;
	} 

	protected function getBillet(){
		return $this -> billet;
	}

	protected function setType($type){
		$this -> type = $type;
	} 

	protected function getType(){
		return $this -> type;
	}

	protected function setContent($content){
		$this -> content = $content;
	} 

	protected function getContent(){
		return $this -> content;
	}

	protected function getConn(){
		return $this -> conn;
	}

	protected function getTable(){
		return $this -> db_table;
	}
}