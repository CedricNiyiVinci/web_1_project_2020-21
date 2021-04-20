<?php 
class LoginController {

	private $_db;
		
	public function __construct($db){	
		$this->_db = $db;
	}
	
	public function run(){	
		$notification = "Page de Login!";

		require_once(VIEWS_PATH.'login.php');
	}
	
}
?>