<?php 
class LogoutController{

	public function __construct() {
	
	}
		
	public function run(){	
		# When an user want to disconnecte his account, we have to erase all the data we save into $_SESSION
		$_SESSION = array();

		# After we erased the data that was saved in $_SESSION, we redirect the user to the login page
		header("Location: index.php?action=login"); 
		die();
	}
	
} 
?>