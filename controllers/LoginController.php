<?php 
class LoginController { // OK je vois que vous avez développé d'abord l'architecture avant d'entrer dans les fonctionnalités

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
