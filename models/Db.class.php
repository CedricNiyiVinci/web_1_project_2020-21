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

    public function validerUtilisateur($email, $motdepasse){
        $query = 'SELECT password FROM members WHERE e_mail = :email ';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':email',$email);
        $ps->execute();

        if($ps->rowCount() == 0)
            return false;
        $hash = $ps->fetch()->password;
            return password_verify($motdepasse, $hash); #On verifie à l'aide de la fonction 
                                                        #password_verify le mot de passe entrer pas l'utilisateur
                                                        #hash-Bowlfish
    }

    public function recupererPseudo($email){
        $query = 'SELECT username FROM members WHERE e_mail = :email ';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':email',$email);
        $ps->execute();

        $row = $ps->fetch();
        $username = ($row->username);
        return $username; 
    }
    # Fonction qui exécute un SELECT dans la table des ideas
    # et qui renvoie un tableau d'objet(s) de la classe Ideas
    public function selectIdea() {
        $query = 'SELECT i.*, m.username FROM ideas i, members m WHERE i.author=m.id_member';
        $ps = $this->_db->prepare($query);
        $ps->execute();

        $tableau = array();
        while ($row = $ps->fetch()) {
            //var_dump($row);
            $tableau[] = new Idea($row->id_idea,$row->username,$row->title,$row->text,$row->status,$row->submitted_date,$row->accepted_date,$row->refused_date,$row->closed_date);
        }
        # Pour debug : affichage du tableau à renvoyer
        
        return $tableau;
    }

    public function selectIdeaInFucntionOfStatus($statuschosed) {
        $query = 'SELECT i.*, m.username FROM ideas i, members m WHERE i.author=m.id_member AND i.status = :statuschosed';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':statuschosed',$statuschosed);
        $ps->execute();
        var_dump($statuschosed);
        $tableau = array();
        while ($row = $ps->fetch()) {
            //var_dump($row);
            $tableau[] = new Idea($row->id_idea,$row->username,$row->title,$row->text,$row->status,$row->submitted_date,$row->accepted_date,$row->refused_date,$row->closed_date);
        }
        # Pour debug : affichage du tableau à renvoyer
        
        return $tableau;
    }

    public function selectIdeaInFucntionOfPopularity($numberToDisplay) {
        $query = 'SELECT i.*, m.username FROM ideas i, members m WHERE i.author=m.id_member LIMIT 3';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':numbertodisplay',$numberToDisplay);
        $ps->execute();

        $tableau = array();
        while ($row = $ps->fetch()) {
            //var_dump($row);
            $tableau[] = new Idea($row->id_idea,$row->username,$row->title,$row->text,$row->status,$row->submitted_date,$row->accepted_date,$row->refused_date,$row->closed_date);
        }
        # Pour debug : affichage du tableau à renvoyer
        
        return $tableau;
    }

    public function selectMyIdea($email) {
        $query = 'SELECT i.* FROM ideas i WHERE i.author = (SELECT m.id_member  FROM members m WHERE m.e_mail = :email)';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':email',$email);
        $ps->execute();

        $tableau = array();
        while ($row = $ps->fetch()) {
            //var_dump($row);
            $tableau[] = new Idea($row->id_idea,$row->author,$row->title,$row->text,$row->status,$row->submitted_date,$row->accepted_date,$row->refused_date,$row->closed_date);
        }
        # Pour debug : affichage du tableau à renvoyer
        
        return $tableau;
    }
    public function selectMemberIdea($id_member) {
        $query = 'SELECT i.* FROM ideas i WHERE i.author = (SELECT m.id_member   FROM members m WHERE m.id_member = :id_member)';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':id_member',$id_member);
        $ps->execute();
        $tableau = array();
        while ($row = $ps->fetch()) {
            $tableau[] = new Idea($row->id_idea,$row->author,$row->title,$row->text,$row->status,$row->submitted_date,$row->accepted_date,$row->refused_date,$row->closed_date);
        }
        # Pour debug : affichage du tableau à renvoyer
        return $tableau;
    }
    
    public function selectMembers() {
        $query = 'SELECT m.* FROM members m';
        $ps = $this->_db->prepare($query);
        $ps->execute();

        $tableau = array();
        while ($row = $ps->fetch()) {
            //var_dump($row);
            $tableau[] = new Member($row->id_member,$row->username,$row->password,$row->hierarchy_level,$row->e_mail,$row->disabled_account);
        }
        # Pour debug : affichage du tableau à renvoyer
        
        return $tableau;
    }

    public function insertMembers($username,$email,$password) {
        $query = 'INSERT INTO members (username, e_mail, password) values (:username, :email, :password)';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':username',$username);
        $ps->bindValue(':email',$email);
        $ps->bindValue(':password',$password);
        $ps->execute();
    }

    public function validePseudo($pseudo){
        $query = 'SELECT count(username) AS "nbr" FROM members WHERE username LIKE :pseudo';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':pseudo',"$pseudo");
        $ps->execute();
        $raw = $ps->fetch();
        if ($raw->nbr>0)
            return false;
        return true;
    }

    public function valideEmail($email){
        $query = 'SELECT count(e_mail) AS "nbr" FROM members WHERE e_mail LIKE :email';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':email',"$email");
        $ps->execute();
        $raw = $ps->fetch();
        if ($raw->nbr>0)
            return false;
        return true;
    }

    public function getIdMember($pseudo){
        $query = 'SELECT id_member FROM members WHERE username LIKE :pseudo';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':pseudo',"$pseudo");
        $ps->execute();
        $row = $ps->fetch();
        $idMember = ($row->id_member);
        return $idMember;
        
    }
    public function insertIdea($author,$title_idea,$text_idea,$date) {
        $query = 'INSERT INTO ideas (author, title, text, submitted_date, status) values (:idmember, :title, :text, :date, "submitted")';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':idmember',$author);
        $ps->bindValue(':title',$title_idea);
        $ps->bindValue(':text',$text_idea);
        $ps->bindValue(':date',$date);
        $ps->execute();
    }
    public function hierarchy_admin($id_member) {
        $query = 'UPDATE members SET hierarchy_level = :admin WHERE id_member = :id_member';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':admin', 'admin');
        $ps->bindValue(':id_member',$id_member);
        $ps->execute();
    }

    public function setDisabel($id_member) {
        $query ='UPDATE members SET disabled_account = 1 WHERE id_member = :id_member';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':id_member',$id_member);
        $ps->execute();
    }

    public function setStatusAccepted($id_idea) {
        $query ='UPDATE ideas SET status = :accepted WHERE id_idea = :id_idea';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':accepted', 'accepted');
        $ps->bindValue(':id_idea',$id_idea);
        $ps->execute();
    }
    public function setStatusRefused($id_idea) {        
        $query ='UPDATE ideas SET status = :refused WHERE id_idea = :id_idea';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':refused', 'refused');
        $ps->bindValue(':id_idea',$id_idea);
        $ps->execute();
    }
    public function setStatusClosed($id_idea) {      
        $query ='UPDATE ideas SET status = :closed WHERE id_idea = :id_idea';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':closed', 'closed');
        $ps->bindValue(':id_idea',$id_idea);
        $ps->execute();
    }
    


}