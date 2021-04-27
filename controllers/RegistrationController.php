<?php 
class RegistrationController {

	private $_db;
		
	public function __construct($db){	
		$this->_db = $db;
	}
	
	public function run(){	

		$notification="";

		# Si un distrait écrit ?action=registration en étant déjà authentifié
		if (!empty($_SESSION['authentifie'])) {
			header("Location: index.php?action=profile"); # redirection HTTP vers l'action login
			die(); 
		}
		if(!empty($_POST['form_register'])){
			if(!empty($_POST['username']) && !empty($_POST['e_mail']) && !empty($_POST['password'])){
				if($_POST['e_mail'] != $_POST['confirmation_email']){
					$notification = "l'email est mal  ecrit";
				}
				if($_POST['password'] != $_POST['confirmation_password']){
					$notification = "le password est mal  ecrit";
				}
				else{
					$this->_db->insertMembers($_POST['username'],$_POST['e_mail'],$_POST['password']);
					$_SESSION['authentifie'] = 'ok'; 
					$_SESSION['login'] = $_POST['username'];
					# Redirection HTTP pour demander la page profile
					header("Location: index.php?action=profile"); 
					die();
				}
			}
			else{
				$notification ="tous les champs doivent etre complété";
			}
		}	
		require_once(VIEWS_PATH.'registration.php');
	}
	
}
?>