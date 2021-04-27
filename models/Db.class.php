<?php
class Db
{
    private static $instance = null;
    private $_db;

    private function __construct()
    {
        try {
            $this->_db = new PDO('mysql:host=localhost;port=3306;dbname=studentvote;charset=utf8','root','');
            $this->_db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			$this->_db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
        } 
		catch (PDOException $e) {
		    die('Erreur de connexion à la base de données : '.$e->getMessage());
        }
    }

	# Singleton Pattern
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new Db();
        }
        return self::$instance;
    }

    public function validerUtilisateur($pseudo, $motdepasse){
        $query = 'SELECT password FROM members WHERE username = :pseudo ';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':pseudo',$pseudo);
        $ps->execute();
        
        if($ps->rowCount() == 0)
            return false;
        $hash = $ps->fetch()->password;
            return password_verify($motdepasse, $hash); #On verifie à l'aide de la fonction 
                                                        #password_verify le mot de passe entrer pas l'utilisateur
                                                        #hash-Bowlfish
    }

    # Fonction qui exécute un SELECT dans la table des ideas
    # et qui renvoie un tableau d'objet(s) de la classe Ideas
    public function selectIdea() {
        $query = 'SELECT * FROM ideas  ORDER BY id_idea DESC';
        $ps = $this->_db->prepare($query);
        $ps->execute();

        $tableau = array();
        while ($row = $ps->fetch()) {
            $tableau[] = new Idea($row->id_idea,$row->author,$row->title,$row->text,$row->status,$row->submitted_date,$row->accepted_date,$row->refused_date,$row->closed_date);
        }
        # Pour debug : affichage du tableau à renvoyer
        // var_dump($tableau);
        return $tableau;
    }

}