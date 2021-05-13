<?php 
class PostCommentsController {

	private $_db;
		
	public function __construct($db){	
		$this->_db = $db;
	}
	
	public function run(){

		# If a malicious person writes ?action=postcomments while he isn't authenticated
		# he will be redirected to the login page
		if (empty($_SESSION['authenticated'])) {
			header("Location: index.php?action=login"); # HTTP redirection to action "login", the user his redirected to the login page
			die(); 
		}
		$commentNotification= "";

		# In the TimeLineController, I saved the idea that the user chose, which he wanted to see the comment page.
		$ideaSelected = unserialize($_SESSION['idea_comment_selected']); // now I unserialize it so I can use it here and show it on a comment page 
		
		# -------------------------------------------------------------------------
        # Form that check the data entered into form_publish_comment when the user want to post a new comment below the idea showed on that comment page
        # -------------------------------------------------------------------------
		if(!empty($_POST['form_publish_comment'])){#Firstly as always we check if the form isn't empty before to analyze the data entered by the user
			if(!empty($_POST['text_idea'])){ #if the user click on the submit button without filled the main input, we notify him to do it correctly (code line : 33)
				date_default_timezone_set('Europe/Brussels'); # Here I set the default time zone of Belgium, before I use the date function that PHP provides me  
				$date = date('Y-m-d H:i:s'); # Create a date variable to use it next when I want to add a new comment in my database
				$this->_db->addACommentToIdea($date, $_POST['text_idea'], $_SESSION['id_member_online'], $ideaSelected->getId_idea()); #add that new comment into my database
				$notification = "Votre commentaire a bien été publier!";
			}else{
					$notification = "Vous tentez de publier un commentaire vide"; 
				}
		}

		# -------------------------------------------------------------------------------------
        # Form that check if the user want to delete one of his comment if there's at least one for the idea displayed,
		# this form (form_deleted_comment) is originally empty but as soon as he want to delete one of his comment the form is filled 
		# with the unique ID of that comment
        # -------------------------------------------------------------------------------------
		if (!empty($_POST['form_deleted_comment'])) {
				# With that foreach loop we want to catch that id_comment that are in the table $_POST['form_deleted_comment']
                foreach ($_POST['form_deleted_comment'] as $id_comment => $action) {
                    # $id_comment is the primary key of the comments table so we use it here
					$this->_db->markCommentAsDeleted($id_comment); # In my datebase, I will mark that comment as deleted but I will not erase or delete the text comment.
					$commentNotification = "Votre commentaire à été supprimé!";
				}
        }
		$tabComments = $this->_db->selectCommentIdea($ideaSelected->getId_idea()); #Next, I select all the comments related to the idea displayed on the page
		require_once(VIEWS_PATH.'postcomments.php');
	}
	
}
?>