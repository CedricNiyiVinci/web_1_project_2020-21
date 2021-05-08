<?php 
class LoginController {

	private $_db;
		
	public function __construct($db){	
		$this->_db = $db;
	}
	
	public function run(){	
		# Si un distrait écrit ?action=login en étant déjà authentifié
		if (!empty($_SESSION['authentifie'])) {
		 	header("Location: index.php?action=profile"); # redirection HTTP vers l'action profile
		 	die(); 
		}
		/*if($this->_db->$disabled_account == 1)	 {
			header("Location: index.php?action=login"); # redirection HTTP vers l'action login
			$notification='ton compte est desactiver';
		 	die();
		}*/
	
		# Variables HTML dans la vue
		$notification='';

		# L'utilisateur s'est-il bien authentifié ?

		if(empty($_POST)){
			$notification='Authentifiez-vous';
		} else if (!$this->_db->validerUtilisateur($_POST['email'],$_POST['password'])){
			$notification='L\'un des champs entrés est incorrecte. Veuillez réessayer ';
		} else {
		# L'utilisateur est bien authentifié
		# Une variable de session $_SESSION['authenticated'] est créée
		$_SESSION['authentifie'] = 'ok'; 
		$_SESSION['email'] = $_POST['email'];
		$_SESSION['login'] = $this->_db->recupererPseudo($_POST['email']);
		$_SESSION['id_member_online'] = $this->_db->recupererIdNumber($_POST['email']);
		# Redirection HTTP pour demander la page profile
		header("Location: index.php?action=profile"); 
		die();
		// var_dump($_SESSION['id_member_online'] );
		// var_dump($_SESSION['login']);
		// var_dump($_SESSION['email']);
		}
		require_once(VIEWS_PATH.'login.php');
	}
	
}
?>