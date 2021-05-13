<?php 
class LoginController {

	private $_db;
		
	public function __construct($db){	
		$this->_db = $db;
	}
	
	public function run(){	
		# If a distracted person writes ?action=login while already authenticated
		# he will be redirected to his profile page
		if (!empty($_SESSION['authenticated'])) {
		 	header("Location: index.php?action=profile");  # HTTP redirection to action "profile", the user his redirected to his profile page
		}
	
		# notification variable that will apear in the view
		$notification='';

		# Here we try to know if the user has successfully authenticated

		if(empty($_POST)){ // if the form is empty we notify the user to identify themself correctly.
			$notification='Authentifiez-vous';
		} else if (!$this->_db->validateUser($_POST['email'],$_POST['password'])){ // in case the user connects incorrectly we notify him
			$notification='L\'un des champs entrés est incorrecte. Veuillez réessayer ';
		}else { 
		if($this->_db->isDisabled($_POST['email']) == 1)	 { // If a user account is disabled, he can't log in to enter in the site
			$notification='Votre compte est désactivé!';
			require_once(VIEWS_PATH.'login.php'); # HTTP redirection to action "login"
			die();
		}
		# If we are here it will say that the user is well authenticated
		# Une variable de session $_SESSION['authenticated'] est créée 
		# A variable session $_SESSION['authenticated'] is created
		$_SESSION['authenticated'] = 'ok'; 
		$_SESSION['email'] = $_POST['email']; //Here I savethe email of the user connected in a session variable, so I can use it again.
		$_SESSION['login'] = $this->_db->findPseudo($_POST['email']); //Here I savethe username of the user connected in a session variable, so I can use it again. 
		$_SESSION['id_member_online'] = $this->_db->findIdNumber($_POST['email']); //Here I save the ID member of the user connected in a session variable, so I can use it again.
		$_SESSION['hierarchy_level'] = $this->_db->hierarchyLevelOfTheUser($_POST['email']); //Here I save the hierarchy level of the user connected in a session variable, so I can use it again.
		# HTTP redirection to action "profile", the user his redirected to his profile page
		header("Location: index.php?action=profile"); 
		die();
		}
		require_once(VIEWS_PATH.'login.php');
	}
	
}
?>