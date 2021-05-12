<?php 
class ProfileController {

	private $_db;
		
	public function __construct($db){	
		$this->_db = $db;
	}
	public function run(){	
		# If a malicious person writes ?action=profile while already he isn't authenticated
		# he will be redirected to the login page
		if (empty($_SESSION['authenticated'])) {
			header("Location: index.php?action=login"); # HTTP redirection to action "login", the user his redirected to the login page
			die(); 
		}
		$notification=", vous êtes actuellement sur la page de votre profil. \n 
							Cette page répertorie toutes vos idées postées sur le site, ainsi que tout vos commentaires publiés sous différentes idées et les idées pour lesquelles vous avez votées.";
		$tabMyIdeas = $this->_db->selectMyIdea($_SESSION['email']); // Here we select all the ideas posted by the user currently online, to show it next
		$tabVotedIdeas = $this->_db->selectVotedIdea($_SESSION['id_member_online']); // Here we select all the ideas voted by the user currently online, to show it next
		$tabCommentsUser = $this->_db->selectCommentUser($_SESSION['id_member_online']); // Here we select all the comments writed by the user currently online, to show it next
		
		require_once(VIEWS_PATH.'profile.php');
	}
	
}
?>