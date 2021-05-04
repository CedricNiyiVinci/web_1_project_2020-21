<?php 
class IdeaListAdminController {

	private $_db;
		
	public function __construct($db){	
		$this->_db = $db;
	}
	
	public function run(){	
		$notification = "Page référanciant toutes les idées du site web. Pagr exclusive aux administrateurs !";
		if(!empty($_POST['accepted'])) {
			
			foreach ($_POST['accepted'] as $i => $id_idea ) {
				
				#$id_idea est bien le id_idea d'une idee dans la table des idees
				$this->_db->setStatusAccepted($i);
				$notification = "l'idée est accpeter";
				//header("Location: index.php?action=idealisteadmin");  
				//die();
			}		
		}
		$tabIdeas = $this->_db->selectIdea();
		require_once(VIEWS_PATH.'idealistadmin.php');
	}
	
}
?>