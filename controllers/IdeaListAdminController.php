<?php 
class IdeaListAdminController {

	private $_db;
		
	public function __construct($db){	
		$this->_db = $db;
	}
	
	public function run(){

		# If a malicious person writes ?action=idealistadmin while he isn't authenticated
		# he will be redirected to the login page
		if (empty($_SESSION['authenticated'])) { 
			header("Location: index.php?action=login");  # HTTP redirection to action "login", the user his redirected to the login page 
			die(); 
		}

		# If a normal member writes ?action=idealistadmin while he is connected
		# he will be redirected to his profile page
		if($_SESSION['hierarchy_level'] == 'member') { 
            header("Location: index.php?action=profile"); # HTTP redirection to action "profile", the user his redirected to his profile page
            die();
        }


		$notification = "Page référanciant toutes les idées du site web. Page exclusive aux administrateurs !";
		$notificationStatus = "";
		
		# -------------------------------------------------------------------------------------
		# -------------------------------------------------------------------------------------
		
		# Change the status of an idea

		# -------------------------------------------------------------------------------------
		# -------------------------------------------------------------------------------------


		# -------------------------------------------------------------------------------------
        # Form that check if the admin want to change the status of an idea to "REFUSED"/ "ACCEPTED" or "CLOSED".
		# This form is originally empty but as soon as he clicks on "REFUSED" / "ACCEPTED" or "CLOSED".
		# $_POST['refused'] / $_POST['accepted'] or $_POST['closed'] will be filled with id_idea of the idea the admin wanted to change the status.
        # -------------------------------------------------------------------------------------
		if(!empty($_POST['refused'])) { 
			# With that foreach loop we want to catch that id_idea that are in the table $_POST['refused']
			foreach ($_POST['refused'] as $id_idea => $action ) { #$id_idea is the primary key of the ideas table so we use it here
				$title_idea = $this->_db->selectTitleFromAnIdea($id_idea);
				$username_author = 	$this->_db->selectUsernameAuthorFromAnIdea($id_idea);
				date_default_timezone_set('Europe/Brussels'); # we define the time zones of the variable date
                $date = date('m/d/Y h:i:s a', time()); # we define the variable date
                $date = date('Y-m-d H:i:s'); # we define the structur of the variable date
				$this->_db->setStatusRefused($id_idea,$date); # we change the status of the idea in our database and we intialise the refused_date 
				$notificationStatus = "Le statut de l'idée de $username_author (titre: $title_idea) à été changé en \"refusée\"."; # we change the value of the variable notification
			}
		}else if(!empty($_POST['accepted'])) {
			# With that foreach loop we want to catch that id_idea that are in the table $_POST['accepted']
			foreach ($_POST['accepted'] as $id_idea => $action ) { #$id_idea is the primary key of the ideas table so we use it here
				$title_idea = $this->_db->selectTitleFromAnIdea($id_idea);
				$username_author = 	$this->_db->selectUsernameAuthorFromAnIdea($id_idea);
				date_default_timezone_set('Europe/Brussels'); # we define the time zones of the variable date
                $date = date('m/d/Y h:i:s a', time());# we define the variable date
                $date = date('Y-m-d H:i:s'); #we define the structur of the variable date
				$this->_db->setStatusAccepted($id_idea,$date); # we change the status of the idea in our database and we intialise the accepted_date 
				$notificationStatus = "Le statut de l'idée de $username_author (titre: $title_idea) à été changé en \"acceptée\".";
			}		
		}else if(!empty($_POST['closed'])) {
			# With that foreach loop we want to catch that id_idea that are in the table $_POST['closed']
			foreach ($_POST['closed'] as $id_idea => $action ) { #$id_idea is the primary key of the ideas table so we use it here
				$title_idea = $this->_db->selectTitleFromAnIdea($id_idea);
				$username_author = 	$this->_db->selectUsernameAuthorFromAnIdea($id_idea);
				date_default_timezone_set('Europe/Brussels');# we define the time zones of the variable date
                $date = date('m/d/Y h:i:s a', time()); # we define the variable date
                $date = date('Y-m-d H:i:s'); # we define the structur of the variable date
				$this->_db->setStatusClosed($id_idea,$date); # we change the status of the idea in our database and we intialise the closed_date 
				$notificationStatus = "L'idée de $username_author (titre: $title_idea) à été clôturée.";
			}		
		}		
		$tabIdeas = $this->_db->selectIdea(); # we refresh the values of the tabIdeas
		require_once(VIEWS_PATH.'idealistadmin.php');
	}
	
}
?>