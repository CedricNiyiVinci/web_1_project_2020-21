<?php 
class MemberListAdminController {

	private $_db;
		
	public function __construct($db){	
		$this->_db = $db;
	}
	
	public function run(){	
		$notification = "Page référanciant toutes les membres inscrit sur le site. Page exclusive aux administrateurs !";

		require_once(VIEWS_PATH.'idealistadmin.php');
	}
	
}
?>