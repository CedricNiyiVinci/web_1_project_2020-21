<?php 
class IdeaListAdminController {

	private $_db;
		
	public function __construct($db){	
		$this->_db = $db;
	}
	
	public function run(){
		if (empty($_SESSION['authentifie'])) { # if the session is hollow 
			header("Location: index.php?action=login"); # redirection to the login page 
			die(); 
		}	
		$notification = "Page référanciant toutes les idées du site web. Pagr exclusive aux administrateurs !";
		if(!empty($_POST['refused'])) { 
			foreach ($_POST['refused'] as $i => $id_idea ) {
				date_default_timezone_set('Europe/Brussels'); # we define the time zones of the variable date
                $date = date('m/d/Y h:i:s a', time()); # we define the variable date
                $date = date('Y-m-d H:i:s'); # we define the structur of the variable date
				$this->_db->setStatusRefused($i,$date);# we give the information for the metode 
				$notification = "l'idée est refuser"; # we change the value of the variable notification
			}
		}elseif(!empty($_POST['accepted'])) {
			foreach ($_POST['accepted'] as $i => $id_idea ) {
				date_default_timezone_set('Europe/Brussels');
                $date = date('m/d/Y h:i:s a', time());
                $date = date('Y-m-d H:i:s');
				$this->_db->setStatusAccepted($i,$date);
				$notification = "l'idée est accpeter";
			}		
		}elseif(!empty($_POST['closed'])) {
			foreach ($_POST['closed'] as $i => $id_idea ) {
				date_default_timezone_set('Europe/Brussels');
                $date = date('m/d/Y h:i:s a', time());
                $date = date('Y-m-d H:i:s');
				$this->_db->setStatusClosed($i,$date);
				$notification = "l'idée est close";
			}		
		}		
		$tabIdeas = $this->_db->selectIdea(); # we refresh the value of the tabIdeas
		require_once(VIEWS_PATH.'idealistadmin.php');
	}
	
}
?>