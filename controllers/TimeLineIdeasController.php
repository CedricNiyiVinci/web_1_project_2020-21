<?php 
class TimeLineIdeasController {

	private $_db;
		
	public function __construct($db){	
		$this->_db = $db;
	}
	
	public function run(){
		if (empty($_SESSION['authentifie'])) {
			header("Location: index.php?action=login"); # redirection HTTP vers l'action login
			die(); 
		}


		$notification = '';
		$notificationIdea = '';
		if (!empty($_POST['form_publish_idea'])){ #il faut verifier si le formulaire n'est pas vifr
			if(empty($_POST['title_idea']) && empty($_POST['text_idea'])){
				$notificationIdea = 'Veuillez entrer un titre et un texte pour votre nouvelle idée';
			}else if (empty($_POST['title_idea'])){
				$notificationIdea = 'Veuillez entrer un titre!';
			}else if (empty($_POST['text_idea'])){
				$notificationIdea = 'Veuillez entrer du texte, les idées vides n\'ont pas leur place ici.';
			}else{
			date_default_timezone_set('Australia/Melbourne');
			$date = date('m/d/Y h:i:s a', time());

			$date = date('Y-m-d h:i:s');
			$id_member = $this->_db->getIdMember($_SESSION['login']);
				$this->_db->insertIdea($id_member,$_POST['title_idea'],$_POST['text_idea'],$date);
				$notificationIdea='Ajout bien fait';
			}
		}

        
		
		/*if(!empty($_POST['form_idea'])){
			if(empty($_POST['titel_idea'])){
				$notification="il faut un titre a votre idée";
			}else if(empty($_POST['idea'])){
				$notification="il vous faut une idée";
			}else {
				$this->_db->insertIdea($_POST['login'],$_POST['titel_idea'],$_POST['idea'],$time_start);
				$pseudo = $_POST['login'];
				$notification='votre idea a bien été uploder';
			}

		}*/
		$selectionPopularity = "--Choisisez une option s.v.p.--";
		$selectionStatus = "--Choisisez une option s.v.p.--";
		$notification = "Fil d'idées";
		//$testDebug = "ATTENTION-ATTENTION-ATTENTION-ATTENTION-ATTENTION-ATTENTION-ATTENTION-ATTENTION-";
		if(empty($_POST['form_popularity']) && empty($_POST['form_status'])){
			// $selectionPopularity = "--Choisisez une option s.v.p.--";
			// $selectionStatus = "--Choisisez une option s.v.p.--";
			$tabIdeas = $this->_db->selectIdea();
		}else if (!empty($_POST['form_popularity'])){
			$selectionPopularity = $_POST['popularity'];
			if($_POST['popularity']=="ALL"){
				$tabIdeas = $this->_db->selectIdea();
				$selectionPopularity = "Toutes les idées de la plus populaire à la moins populaire:";
			}else{
				if($selectionPopularity>=3){
					$selectionPopularity = "Les ". $selectionPopularity. " idées les plus populaires.";
				}
				$tabIdeas = $this->_db->selectIdeaInFucntionOfPopularity($_POST['popularity']);
			}
		}else if (!empty($_POST['form_status'])){ #Selection Ideas in function of status that the user has chosen
			//var_dump($testDebug);
			$selectionStatus = $_POST['status'];
			$tabIdeas = $this->_db->selectIdeaInFucntionOfStatus($_POST['status']);
			$selectionStatus = "Liste des idées en \" ". $selectionStatus. "\"";
		}
		
		
		require_once(VIEWS_PATH.'timelineideas.php');
	}
	
}
?>