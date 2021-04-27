<?php 
class RegistrationController {

	private $_db;
		
	public function __construct($db){	
		$this->_db = $db;
	}
	
	public function run(){	

		# Si un distrait écrit ?action=registration en étant déjà authentifié
		if (!empty($_SESSION['authentifie'])) {
			header("Location: index.php?action=profile"); # redirection HTTP vers l'action login
			die(); 
		}	

		$notification = "Page d'inscription";

		require_once(VIEWS_PATH.'registration.php');
	}
	
}
?>