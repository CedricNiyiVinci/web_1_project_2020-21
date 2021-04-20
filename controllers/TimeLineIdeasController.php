<?php 
class TimeLineIdeasController {

	private $_db;
		
	public function __construct($db){	
		$this->_db = $db;
	}
	
	public function run(){	
		$notification = "Fil d'idées";

		require_once(VIEWS_PATH.'timelineideas.php');
	}
	
}
?>