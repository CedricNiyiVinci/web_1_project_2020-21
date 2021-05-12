<?php 
class TimeLineIdeasController {

	private $_db;
		
	public function __construct($db){	
		$this->_db = $db;
	}
	
	public function run(){
		# If a malicious person writes ?action=timelineidea while already he isn't authenticated
		# he will be redirected to the login page
		if (empty($_SESSION['authenticated'])) {
			header("Location: index.php?action=login"); # HTTP redirection to action "login", the user his redirected to the login page
			die(); 
		}

		# -------------------------------------------------------------------------
        # Form that check the data to post a new idea on the time line
        # -------------------------------------------------------------------------
		$notification = '';
		$notificationIdea = '';
		if (!empty($_POST['form_publish_idea'])){ #Firstly as always we check if the form isn't empty before to analyze the data entered by the user
			if(empty($_POST['title_idea']) && empty($_POST['text_idea'])){ #if the user click on the submit button without filled the two main inputs, we notify him to do it correctly
				$notificationIdea = 'Veuillez entrer un titre et un texte pour votre nouvelle idée';
			}else if (empty($_POST['title_idea'])){ # between the two inputs, if the title isn't filled, we notify him to do it correctly
				$notificationIdea = 'Veuillez entrer un titre!'; 
			}else if (empty($_POST['text_idea'])){ # between the two inputs, if the idea text isn't filled, we notify him to do it correctly
				$notificationIdea = 'Veuillez entrer du texte, les idées vides n\'ont pas leur place ici.';
			}else{
			date_default_timezone_set('Europe/Brussels'); # Here I set the default time zone of Belgium, before I use the date function that PHP provides me  
			$date = date('Y-m-d H:i:s'); # Create a date variable to use it next when I want to add a new idea in my database
				$this->_db->insertIdea($_SESSION['id_member_online'],$_POST['title_idea'],$_POST['text_idea'],$date); #add that new idea into my database
				$notificationIdea='Votre idée a bien été publiée';
			}
		}


		# -------------------------------------------------------------------------------------
        # Form that check if the user voted for an idea,
		# this form (form_vote) is originally empty but as soon as he votes for an idea the form is filled 
		# with the unique ID of that idea
        # -------------------------------------------------------------------------------------
		if (!empty($_POST['form_vote'])) {
            $id_idea='';
				# With that foreach loop we want to catch that id_idea that are in the tab $_POST['form_vote']
                foreach ($_POST['form_vote'] as $id_idea => $action) { # $id_idea is the primary key of the ideas table so we use it here
					$id_author = $this->_db->selectIdAuthorFromAnIdea($id_idea); #	Here I saved the id_member of the idea that the user want to vote for to know if 
																				 #  it's his idea or not'
					$title_idea = $this->_db->selectTitleFromAnIdea($id_idea);
					$username_author = 	$this->_db->selectUsernameAuthorFromAnIdea($id_idea);																	
					if($id_author == $_SESSION['id_member_online']){ # In the case where he wanted to vote for an idea he writed, we notify him that he can't do that
						$alerteVote = "Vous ne pouvez pas voter pour votre propre idée!";
					}else if(!($this->_db->alreadyVote($id_idea, $_SESSION['id_member_online']))){ # Here I verify if the user connected didn't already vote for that idea
						$alerteVote = "Vous avez déja voté pour cette idée.";	#In the case, he already voted for that idea, we notify him that he already did that
					}else{ # If this idea is not one he has written or one he has already voted for --> I add this vote to my database.
						$this->_db->votePourIdee($_SESSION['id_member_online'], $id_idea);
                    	$id_idea = $id_idea;
						$alerte = "Vous avez voté pour l'idée de $username_author (Titre : $title_idea)"; # Here I notify the user for wich idea he voted and who wrote that idea
					}
				}
        }


		# -------------------------------------------------------------------------------------
        # Form that check if the user want to see the comment page of a particular idea,
		# this form (form_comment) is originally empty but as soon as he clicks on a comment of 
		# an idea the form is filled with the unique ID of that idea. And with that id_idea, I
		# can save (serialize) the object idea in my $_SESSION tab and print it on anothor page.
        # -------------------------------------------------------------------------------------
		$ideaSelected = "";
		if(!empty($_POST['form_comment'])){
            foreach ($_POST['form_comment'] as $id_idea => $no_concern) {
               $ideaSelected = $this->_db->selectOneIdea($id_idea); // Here I save an idea (object) to firstly save it
			   $_SESSION['idea_comment_selected'] = serialize($ideaSelected); // And here I save it in my $_SESSION tab, so it won't disappear nowhere
			   $tabComments = $this->_db->selectCommentIdea($id_idea); // Here we select all the comments releated to the idea selected by the user
			   $_SESSION['comments_selected'] = serialize($tabComments); // I also save that table into my $_SESSION tab, so I can use it in another Controller page
               require_once(VIEWS_PATH.'postcomments.php');  // and after all these steps we redirect the user to the comment page 
               die();
            }
		}

		# -------------------------------------------------------------------------------------
		# -------------------------------------------------------------------------------------
		
		# FILTER AND SORTING SECTION

		# -------------------------------------------------------------------------------------
		# -------------------------------------------------------------------------------------


		
		$titleToDisplay = "";
		$sortType = "popularity";	#	!!!!Default sortype : By Popularity (most votes at the top)
		if(!empty($_POST['choice'])){ # If the user want another type of sorting we save his choice into the variable $sortType
			$sortType = $_POST['choice'];
		}

		# -------------------------------------------------------------------------------------
		# In the case where the user chosed (or default choice) as sorted type : By POPULARITY (ideas with the most votes at the top)
		# -------------------------------------------------------------------------------------
		
		if ($sortType == "popularity"){	
			$tabIdeas = $this->_db->selectAllIdeaInFucntionOfPopularity(); // we select all the ideas from our database, they will be sorted by popularity
			$titleToDisplay = "Toutes les idées de la plus populaire à la moins populaire:";
			if(!empty($_POST['form_popularity'])){ // Filter By 3 / 10 / ALL (form), the user can chose between all these possibilities [sorted by popularity]
				if(!empty($_POST['popularity'])){
					$selectionPopularity = $_POST['popularity'];
					if($_POST['popularity']=="ALL"){
						$tabIdeas = $this->_db->selectAllIdeaInFucntionOfPopularity();
						$titleToDisplay = "Toutes les idées de la plus populaire à la moins populaire:";
					}else{
						if($selectionPopularity>=3){
							$titleToDisplay = "Les ". $selectionPopularity. " idées les plus populaires.";
						}
						$tabIdeas = $this->_db->selectIdeaInFucntionOfPopularity($_POST['popularity']);
					}
				}
			}else if(!empty($_POST['form_status'])) {	// Filter By status of the ideas (submitted / accepted / refused / closed) , the user can chose between all these possibilities [sorted by popularity]
				if(!empty($_POST['status'])){
					if(!empty($_POST['status'])){
						$selectionStatus = $_POST['status'];
						$tabIdeas = $this->_db->selectIdeaInFucntionOfStatusPopularitySort($_POST['status']);
						$titleToDisplay = "Liste des idées en \" ". $selectionStatus. "\" (tri par popularité) :";
					}else{
						$tabIdeas = $this->_db->selectAllIdeaInFucntionOfPopularity();
						$titleToDisplay = "Toutes les idées (tri par popularité):";
					}
				}
			}
		}else{

			# -------------------------------------------------------------------------------------
			# In the case where the user chosed as sorted type : In CHRONOLOGICAL ORDER (most recent ideas at the top)
			# -------------------------------------------------------------------------------------

			$tabIdeas = $this->_db->selectAllIdeaInFucntionOfDate(); // we select all the ideas from our database, they will be sorted by date (most recent at the top)
			$titleToDisplay = "Toutes les idées de la plus récente à la plus ancienne:";
			$sortType = "chronological";
			if(!empty($_POST['form_chronological'])){		// Filter By 3 / 10 / ALL (form), the user can chose between all these possibilities [sorted by date]
				if(!empty($_POST['chronological'])){
					$selectionNumberToDisplay = $_POST['chronological'];
					if($_POST['chronological']=="ALL"){
						$tabIdeas = $this->_db->selectAllIdeaInFucntionOfDate();
						$titleToDisplay = "Toutes les idées de la plus récente à la plus ancienne:";
					}else{
						if($selectionNumberToDisplay>=3){
							$titleToDisplay = "Les ". $selectionNumberToDisplay. " idées les plus récentes.";
						}
						$tabIdeas = $this->_db->selectIdeaInFucntionOfDate($_POST['chronological']);
					}
				}
			}else if(!empty($_POST['form_status'])) {	// Filter By status of the ideas (submitted / accepted / refused / closed) , the user can chose between all these possibilities [sorted by date]
				if(!empty($_POST['status'])){
					if(!empty($_POST['status'])){
						$selectionStatus = $_POST['status'];
						$tabIdeas = $this->_db->selectIdeaInFucntionOfStatusChronologicalSort($_POST['status']);
						$titleToDisplay = "Liste des idées en \" ". $selectionStatus. "\" (tri par ordre chronologique) :";
					}else{
						$tabIdeas = $this->_db->selectAllIdeaInFucntionOfDate();
						$titleToDisplay = "Toutes les idées (tri par ordre chronologique):";
					}
				}
			}
		}
		
		require_once(VIEWS_PATH.'timelineideas.php');
	}
	
}
?>