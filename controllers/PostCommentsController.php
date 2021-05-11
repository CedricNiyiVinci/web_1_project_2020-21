<?php 
class PostCommentsController {

	private $_db;
		
	public function __construct($db){	
		$this->_db = $db;
	}
	
	public function run(){
		$notificationCommentaire= "";
		$ideaSelected = unserialize($_SESSION['idea_comment_selected']);
		if(!empty($_POST['form_publish_comment'])){
			if(!empty($_POST['text_idea'])){
				date_default_timezone_set('Europe/Brussels');
				$date = date('Y-m-d h:i:s');
				$this->_db->addACommentToIdea($date, $_POST['text_idea'], $_SESSION['id_member_online'], $ideaSelected->getId_idea());
				$notification = "Votre commentaire a bien été publier!";
			}else{
					$notification = "Vous tentez de publier un commentaire vide";
				}
		}

		if (!empty($_POST['form_deleted_comment'])) {
            # -------------------------------------------------------------------------
            # Marqué un commentaire comme étant supprimé
            # -------------------------------------------------------------------------
                foreach ($_POST['form_deleted_comment'] as $id_comment => $action) {
                    # $id_idea est bien la clé primaire d'une idée dans la table des idées
					$this->_db->markCommentAsDeleted($id_comment);
					$notificationCommentaire = "Votre commentaire à été supprimé!";
				}
        }
		$tabComments = $this->_db->selectCommentIdea($ideaSelected->getId_idea());
		require_once(VIEWS_PATH.'postcomments.php');
	}
	
}
?>