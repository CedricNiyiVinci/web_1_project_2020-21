<?php 
class RegistrationController {

	private $_db;
		
	public function __construct($db){	
		$this->_db = $db;
	}
	
	public function run(){	
		$notification = "Page d'inscription";

		require_once(VIEWS_PATH.'registration.php');
	}
	
}
?>