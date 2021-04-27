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
		if(!empty($_POST['form_register'])){
			if(!empty($_POST['pseudo']) && 
			!empty($_POST['email']) && 
			!empty($_POST['confirmation_email']) &&
			!empty($_POST['password']) && 
			!empty($_POST['confirmation_password'])){
				$this->_db->insertMembre($_POST['pseudo'],
				$_POST['email'],$_POST['confirmation_email'],
				$_POST['password'],$_POST['confirmation_password']);
                $notification='Ajout bien fait';
			}
			else{
				$notification ="tous les champs doivent etre complété";
			}
		}	

		$notification = "Page d'inscription";

		require_once(VIEWS_PATH.'registration.php');
	}
	
}
?>