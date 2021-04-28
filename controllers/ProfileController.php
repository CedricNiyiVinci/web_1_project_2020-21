<?php 
class ProfileController {

	private $_db;
		
	public function __construct($db){	
		$this->_db = $db;
	}
	
	public function run(){	

		if (empty($_SESSION['authentifie'])) {
			header("Location: index.php?action=login"); # redirection HTTP vers l'action login
			die(); 
		}
		
		$tabMyIdeas = $this->_db->selectMyIdea($_SESSION['login']);
		$notification=' sur votre profile';
		
		
		require_once(VIEWS_PATH.'profile.php');
	}
	
}
?>