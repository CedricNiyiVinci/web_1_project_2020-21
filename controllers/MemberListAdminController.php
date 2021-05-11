<?php 
class MemberListAdminController {

	private $_db;
		
	public function __construct($db){	
		$this->_db = $db;
	}
	
	public function run(){	
        if (empty($_SESSION['authentifie'])) {
			header("Location: index.php?action=login"); # redirection HTTP vers l'action login
			die(); 
		}
		$notification = "Page référanciant toutes les membres inscrit sur le site. Page exclusive aux administrateurs !";
        if(!empty($_POST['idea_member'])){
            foreach ($_POST['idea_member'] as $id_member => $no_concern) {
               $tabMemberIdeas = $this->_db->selectMemberIdea($id_member);
               require_once(VIEWS_PATH.'ideaofmember.php'); 
               die();
            }

        }elseif (!empty($_POST['form_delete']) ) {
            foreach ($_POST['form_delete'] as $id_member => $no_concern) {
                $this->_db->setDisable($id_member);
             }
            $notification = 'Le(s) membre(s) a(ont) bien été desactivé(s))';

        }elseif(!empty($_POST['hierarchy_admin'])){
                foreach ($_POST['hierarchy_admin'] as $id_member => $no_concern) {
                    # $_hierarchy_level est le niveau d'accreditation du membre 
                    $this->_db->hierarchy_admin($id_member);                   
                }
                    $notification = 'le membre est devenue un admin'; 
        }
        $tabMembers = $this->_db->selectMembers();
		require_once(VIEWS_PATH.'memberlistadmin.php');
        
	}
	
}
?>