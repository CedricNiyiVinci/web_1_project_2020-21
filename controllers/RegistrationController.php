<?php 
class RegistrationController {

	private $_db;
		
	public function __construct($db){	
		$this->_db = $db;
	}
	
	public function run(){	

		$notification="";

		# If a distracted person writes ?action=registration while already authenticated
		# he will be redirected to his profile page
		if (!empty($_SESSION['authenticated'])) {
			header("Location: index.php?action=profile"); # HTTP redirection to action "profile", the user his redirected to his profil page
			die(); 
		}
		if(!empty($_POST['form_register'])){ // If the form isn't empty, we will check the data entered by the user
			if(empty($_POST['username']) && empty($_POST['e_mail']) && empty($_POST['password'])){ // If one of the three main input is empty, we notify the user to enter his data correctly
			$notification = "Veuillez entrer vos informations correctement.";
			}else if (empty($_POST['username'])){
				$notification = 'Veuillez entrer un pseudo correct';  # <-- In case the input "pseudo" is empty 
			}else if (empty($_POST['password'])){
				$notification = 'Veuillez entrer un mot de passe'; # <-- In case the input "password" is empty
			}else if (empty($_POST['e_mail'])){
				$notification = 'Veuillez entrer un mail'; # <-- In case the input "email" is empty
			}else{
				if($_POST['confirmation_email'] != $_POST['e_mail']){ # If all the input are not empty, We verify if the user entered the same email in the input "email" and "confirmation_email"
					$notification = "Veuillez entrer vos informations correctement. Corrigez votre email"; 
				}else if ($_POST['confirmation_password'] != $_POST['password']){ # Next the email, We verify if the user the same password in the input "password" and "confirmation_password"
					$notification = "Veuillez entrer vos informations correctement. Corrigez votre mot de passe";
				}else{ // After that we will check if the user didn't enter an email or an username that already exists in ur database
					if ($this->_db->validateUsername($_POST['username'])==false){
					$notification = 'Le pseudo existe déjà, veuillez entrer un autre pseudo'; # <-- Notification if he did so
					}else if ($this->_db->validateEmail($_POST['e_mail'])==false){
					$notification = 'Le mail existe déjà, veuillez entrer un autre email'; # <-- Notification if he did so
						}else{ # If we are that will say that all the input are correctly entered, 
					$password = $_POST['password'];
					$passwordHash = password_hash($_POST['password'], PASSWORD_BCRYPT); #we can now hash the password of the new user 
					$this->_db->insertMember($_POST['username'],$_POST['e_mail'], $passwordHash); # and add this new member in our database
					$notification='Le membre '. '<strong>'. $_POST['username']. '</strong>'. ' a bien été créé';
					}
				}			
			}
		}	

		require_once(VIEWS_PATH.'registration.php');
	}
	
}
?>