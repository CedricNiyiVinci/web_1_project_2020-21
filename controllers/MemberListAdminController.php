<?php 
class MemberListAdminController {

	private $_db;
		
	public function __construct($db){	
		$this->_db = $db;
	}
	
	public function run(){	
		$notification = "Page référanciant toutes les membres inscrit sur le site. Page exclusive aux administrateurs !";
		$tabMembers = $this->_db->selectMembers();

        if(!empty($_POST['idea_member']) && !empty($_POST['Members'])){
            foreach ($_POST['Members'] as $i => $username) {
                # $username est bien le nom d'un membre dans la table des membres
               $this->_db->selectMemberIdea($username);
               $tabMemberIdeas = $this->_db->selectMemberIdea($username);
               header("Location: index.php?action=ideaofmember"); 
               die();
            }

        }elseif (!empty($_POST['form_delete']) && !empty($_POST['Members'])) {
            foreach ($_POST['Members'] as $i => $id_member) {
                $this->_db->delete_comment($id_member);
                $this->_db->delete_vote($id_member);
                $this->_db->delete_idea($id_member);
                $this->_db->delete_member($id_member);
                header("Location: index.php?action=memberlistadmin"); 
                die();
             }
            $notification = 'Le(s) membre(s) a(ont) bien été effacé(s)';

        }elseif(!empty($_POST['hierarchy-selection']) && !empty($_POST['Members'])){
            foreach ($_POST['Members'] as $i => $_hierarchy_level) {
                # $_hierarchy_level est le niveau d'accreditation du membre 
               $this->_db->hierarchy_member($_hierarchy_level);
            }
           $notification = 'le membre est devenue un admin';
        }

		require_once(VIEWS_PATH.'memberlistadmin.php');
	}
	
}
?>