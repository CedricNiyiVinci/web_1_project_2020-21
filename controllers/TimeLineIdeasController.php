<?php 
class TimeLineIdeasController {

	private $_db;
		
	public function __construct($db){	
		$this->_db = $db;
	}
	
	public function run(){
		
		if(!empty($_POST['form_idea'])){
			if(empty($_POST['titel_idea'])){
				$notification="il faut un titre a votre idée";
			}else if(empty($_POST['idea'])){
				$notification="il vous faut une idée";
			}else {
				$this->_db->insertIdea($_POST['login'],$_POST['titel_idea'],$_POST['idea'],$time_start);
				$pseudo = $_POST['login'];
				$notification='votre idea a bien été uploder';
			}

		}
		$notification = "Fil d'idées";
		$tabIdeas = $this->_db->selectIdea();
		
		require_once(VIEWS_PATH.'timelineideas.php');
	}
	
}
?>