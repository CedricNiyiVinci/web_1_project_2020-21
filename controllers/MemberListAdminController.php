<?php 
class MemberListAdminController {

	private $_db;
		
	public function __construct($db){	
		$this->_db = $db;
	}
	
	public function run(){	
		$notification = "Page référanciant toutes les membres inscrit sur le site. Page exclusive aux administrateurs !";
		$tabMembers = $this->_db->selectMembers();
        if(!empty($_POST['idea_member'])){
            foreach ($_POST['Members'] as $i => $username) {
                # $username est bien le nom d'un membre dans la table des membres
               $this->_db->selectMyIdea($username);
               $tabMyIdeas = $this->_db->selectMyIdea($username);
            } 

        }   elseif (!empty($_POST['form_delete'])) {
            foreach ($_POST['Members'] as $i => $id_member) {
                 # $id_membre est bien la clé primaire d'un membre dans la table des membres
                $this->_db->delete_member($id_member);
             }
            $notification = 'Le(s) membre(s) a(ont) bien été effacé(s)';
        }

		require_once(VIEWS_PATH.'memberlistadmin.php');
	}
	
}
?>