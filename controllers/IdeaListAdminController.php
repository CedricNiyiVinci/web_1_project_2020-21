<?php 
class IdeaListAdminController {

	private $_db;
		
	public function __construct($db){	
		$this->_db = $db;
	}
	
	public function run(){	
		$notification = "Page référanciant toutes les idées du site web. Pagr exclusive aux administrateurs !";

		require_once(VIEWS_PATH.'idealistadmin.php');
	}
	
}
?>