<?php 
class LoginController {

	private $_db;
		
	public function __construct($db){	
		$this->_db = $db;
	}
	
	public function run(){	
		# Si un distrait écrit ?action=login en étant déjà authentifié
		if (!empty($_SESSION['authentifie'])) {
			header("Location: index.php?action=profile"); # redirection HTTP vers l'action login
			die(); 
		}	
	
		# Variables HTML dans la vue
		$notification='';

		# L'utilisateur s'est-il bien authentifié ?

		if(empty($_POST)){
			$notification='Authentifiez-vous';
		} else if (!$this->_db->validerUtilisateur($_POST['pseudo'],$_POST['password'])){
			$notification='L\'un des champs entrés est incorrecte. Veuillez réessayer ';
		} else {
		# L'utilisateur est bien authentifié
		# Une variable de session $_SESSION['authenticated'] est créée
		$_SESSION['authentifie'] = 'ok'; 
		$_SESSION['login'] = $_POST['pseudo'];
		# Redirection HTTP pour demander la page admin
		header("Location: index.php?action=profile"); 
		die();
		}

		/*elseif (($_POST['pseudo']!='C' || $_POST['password']!='3PO')) {
			# L'authentification n'est pas correcte
			$notification='Vos données d\'authentification ne sont pas correctes.';	
		}else {
			# L'utilisateur est bien authentifié
			# Une variable de session $_SESSION['authenticated'] est créée
			$_SESSION['authentifie'] = 'ok'; 
			$_SESSION['login'] = $_POST['Pseudo'];
			# Redirection HTTP pour demander la page admin
			header("Location: index.php?action=profile"); 
			die();	
		}*/
		

		require_once(VIEWS_PATH.'login.php');
	}
	
}
?>