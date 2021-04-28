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
			if(empty($_POST['username']) && empty($_POST['e_mail']) && empty($_POST['password'])){
			$notification = "Veuillez entrer vos informations correctement.";
			}else if (empty($_POST['username'])){
				$notification = 'Veuillez entrer un pseudo correct';  # <-- Dans le cas où le champs "pseudo" est vide
			}else if (empty($_POST['password'])){
				$notification = 'Veuillez entrer un mot de passe'; # <-- Dans le cas où le champs "password" est vide
			}else if (empty($_POST['e_mail'])){
				$notification = 'Veuillez entrer un mail'; # <-- Dans le cas où le champs "e_mail" est vide
			}else{
				if ($this->_db->validePseudo($_POST['username'])==false){
				$notification = 'Le pseudo existe déjà, veuillez entrer un autre pseudo';
				}else{
				$password = $_POST['password'];
                $passwordHash = password_hash($_POST['password'], PASSWORD_BCRYPT); 
                $this->_db->insertMembers($_POST['username'],$_POST['e_mail'], $passwordHash);
				$notification='Le membre '. $_POST['username']. ' a bien été créé';
				}
			}
		}	
		require_once(VIEWS_PATH.'registration.php');
	}
	
}
?>