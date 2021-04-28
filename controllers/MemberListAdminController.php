<?php 
class MemberListAdminController {

	private $_db;
		
	public function __construct($db){	
		$this->_db = $db;
	}
	
	public function run(){	
		$notification = "Page référanciant toutes les membres inscrit sur le site. Page exclusive aux administrateurs !";
		$tabMembers = $this->_db->selectMembers();

		if (!empty($_POST['form_delete'])) {
            # -------------------------------------------------------------------------
            # -------------------------------------------------------------------------
            if (!empty($_POST['member'])) {
                foreach ($_POST['member'] as $i => $id_member) {
                    # $no est bien la clé primaire d'un membre dans la table des membres
                    $this->_db->delete_member($id_member);
                }
                $notification = 'Le(s) membre(s) a(ont) bien été effacé(s)';
            } else {
                $notification = 'Aucun membre à effacer';
            }
        }

		require_once(VIEWS_PATH.'memberlistadmin.php');
	}
	
}
?>