<?php 
class IdeaListAdminController {

	private $_db;
		
	public function __construct($db){	
		$this->_db = $db;
	}
	
	public function run(){
		if (empty($_SESSION['authentifie'])) {
			header("Location: index.php?action=login"); # redirection HTTP vers l'action login
			die(); 
		}	
		$notification = "Page référanciant toutes les idées du site web. Pagr exclusive aux administrateurs !";
		if(!empty($_POST['refused'])) {
			foreach ($_POST['refused'] as $i => $id_idea ) {
				#$id_idea est bien le id_idea d'une idee dans la table des idees
				date_default_timezone_set('Europe/Brussels');
                $date = date('m/d/Y h:i:s a', time());
                $date = date('Y-m-d H:i:s');
				$this->_db->setStatusRefused($i,$date);
				$notification = "l'idée est refuser";
			}
		}elseif(!empty($_POST['accepted'])) {
			foreach ($_POST['accepted'] as $i => $id_idea ) {
				#$id_idea est bien le id_idea d'une idee dans la table des idees
				date_default_timezone_set('Europe/Brussels');
                $date = date('m/d/Y h:i:s a', time());
                $date = date('Y-m-d H:i:s');
				$this->_db->setStatusAccepted($i,$date);
				$notification = "l'idée est accpeter";
			}		
		}elseif(!empty($_POST['closed'])) {
			foreach ($_POST['closed'] as $i => $id_idea ) {
				#$id_idea est bien le id_idea d'une idee dans la table des idees
				date_default_timezone_set('Europe/Brussels');
                $date = date('m/d/Y h:i:s a', time());
                $date = date('Y-m-d H:i:s');
				$this->_db->setStatusClosed($i,$date);
				$notification = "l'idée est close";
			}		
		}		
		$tabIdeas = $this->_db->selectIdea();
		require_once(VIEWS_PATH.'idealistadmin.php');
	}
	
}
?>