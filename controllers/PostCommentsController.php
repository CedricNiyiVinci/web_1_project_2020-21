<?php 
class PostCommentsController {

	private $_db;
		
	public function __construct($db){	
		$this->_db = $db;
	}
	
	public function run(){	
		$notification = "Page référanciant toutes les commentaitr d'un post selectionné. Permet à l'utilisateur connecté de commenter le post sélectionner!";

		require_once(VIEWS_PATH.'postcomments.php');
	}
	
}
?>