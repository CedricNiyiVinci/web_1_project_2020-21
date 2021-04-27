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
		$notification = ", vous êtes actuellement sur votre page de profil.";

		require_once(VIEWS_PATH.'profile.php');
	}
	
}
?>