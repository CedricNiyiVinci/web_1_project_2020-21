<?php 
class ProfileController {

	private $_db;
		
	public function __construct($db){	
		$this->_db = $db;
	}
	
	public function run(){	
		$notification = "Page de profil";

		require_once(VIEWS_PATH.'profile.php');
	}
	
}
?>