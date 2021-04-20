<?php 
class HomeController {

	private $_db;
		
	public function __construct($db){	
		$this->_db = $db;
	}
	
	public function run(){	
		$notification = "Hello World !";

		require_once(VIEWS_PATH.'home.php');
	}
	
}
?>