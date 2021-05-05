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
            foreach ($_POST['idea_member'] as $i => $id_member) {
               $tabMemberIdeas = $this->_db->selectMemberIdea($i);
               require_once(VIEWS_PATH.'ideaofmember.php'); 
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

        }elseif(!empty($_POST['hierarchy'])){
            if(!empty($_POST['hierarchy_membre'])){
                foreach ($_POST['hierarchy_membre'] as $i => $id_member) {
                    # $_hierarchy_level est le niveau d'accreditation du membre 
                    $this->_db->hierarchy_member($id_member);                    
                }
                    $notification = 'le membre est devenue un admin';
            }elseif (!empty($_POST['hierarchy_admin'])){
                foreach ($_POST['hierarchy_admin'] as $i => $id_member) {
                    # $_hierarchy_level est le niveau d'accreditation du membre 
                    $this->_db->hierarchy_admin($id_member);
               }
                $notification = 'le membre est devenue un membre';
            }    
        }
		require_once(VIEWS_PATH.'memberlistadmin.php');
	}
	
}
?>