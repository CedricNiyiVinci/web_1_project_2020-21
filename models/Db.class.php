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

    public function recupererIdNumber($email){
        $query = 'SELECT id_member FROM members WHERE e_mail = :email ';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':email',$email);
        $ps->execute();

        $row = $ps->fetch();
        $id_member = ($row->id_member);
        return $id_member; 
    }

    public function recupererHierarchy_level($email){
        $query = 'SELECT hierarchy_level FROM members WHERE e_mail = :email ';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':email',$email);
        $ps->execute();

        $row = $ps->fetch();
        $hierarchy_level = ($row->hierarchy_level);
        return $hierarchy_level; 
    }
    public function recupererDisabled_account($email){
        $query = 'SELECT disabled_account FROM members WHERE e_mail = :email ';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':email',$email);
        $ps->execute();

        $row = $ps->fetch();
        $disabled_account = ($row->disabled_account);
        return $disabled_account; 
    }
    

    public function addACommentToIdea($date, $text, $author, $id_dea){
        $query = 'INSERT INTO comments (date_com, text, author, idea) values (:date, :text, :author, :ididea)';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':date',$date);
        $ps->bindValue(':text',$text);
        $ps->bindValue(':author',$author);
        $ps->bindValue(':ididea',$id_dea);
        $ps->execute();
    }

    public function votePourIdee($id_member, $id_idea){
        $query = 'INSERT INTO votes (id_member, id_idea) values (:idmember, :ididea)';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':idmember',$id_member);
        $ps->bindValue(':ididea',$id_idea);
        $ps->execute();
    }

    public function selectIdAuthorFromAnIdea($id_idea){
        $query = 'SELECT author FROM ideas WHERE id_idea = :ididea';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':ididea',$id_idea);
        $ps->execute();

        $row = $ps->fetch();
        $id_author= ($row->author);
        return $id_author; 
    }
    public function alreadyVote($id_idea, $id_member){
        $query = 'SELECT count(id_member) AS "nbr" 
                    FROM votes WHERE id_member = :idmember AND id_idea = :ididea';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':idmember',$id_member);
        $ps->bindValue(':ididea',$id_idea);
        $ps->execute();
        $raw = $ps->fetch();
        if ($raw->nbr==1)
            return false;
        return true;
        }


    # Fonction qui exécute un SELECT dans la table des ideas
    # et qui renvoie un tableau d'objet(s) de la classe Ideas
    public function selectIdea() {
        $query = 'SELECT i.*, m.username, COUNT(v.id_idea) AS "nbr_votes", COUNT(c.id_comment) AS "nbr_comments"
                    FROM ideas i 
                    LEFT JOIN members m 
                    ON m.id_member = i.author
                    LEFT JOIN votes v
                    ON v.id_idea = i.id_idea 
                    LEFT JOIN comments c
                    ON c.idea = i.id_idea
                    GROUP BY i.id_idea';
        $ps = $this->_db->prepare($query);
        $ps->execute();

        $tableau = array();
        while ($row = $ps->fetch()) {
            //var_dump($row);
            $tableau[] = new Idea($row->id_idea,$row->username,$row->title,$row->text,$row->status,$row->submitted_date,$row->accepted_date,$row->refused_date,$row->closed_date,$row->nbr_votes,$row->nbr_comments);
        }
        # Pour debug : affichage du tableau à renvoyer
        
        return $tableau;
    }

    public function selectOneIdea($id_idea){
        $query = 'SELECT i.*, m.username, COUNT(v.id_idea) AS "nbr_votes", COUNT(c.id_comment) AS "nbr_comments"
                  FROM ideas i
                  LEFT JOIN members m
                  ON m.id_member = i.author 
                  LEFT JOIN votes v 
                  ON v.id_idea = i.id_idea 
                  LEFT JOIN comments c 
                  ON c.idea = i.id_idea 
                  WHERE i.id_idea = :idselected 
                  GROUP BY i.id_idea';
    $ps = $this->_db->prepare($query);
    $ps->bindValue(':idselected',$id_idea);
    $ps->execute();

    $row = $ps->fetch();
    $idSelected = new Idea($row->id_idea,$row->username,$row->title,$row->text,$row->status,$row->submitted_date,$row->accepted_date,$row->refused_date,$row->closed_date,$row->nbr_votes,$row->nbr_comments);
        return $idSelected;
    }

    //SELECT m.username, c.* FROM comments c, members m WHERE c.author = m.id_member AND c.idea = 3
    public function selectCommentIdea($id_idea){
        $query = 'SELECT m.username, c.*
                    FROM comments c, members m  
                    WHERE c.author = m.id_member AND c.idea = :idselected';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':idselected',$id_idea);
        $ps->execute();

        $tableau = array();
        while ($row = $ps->fetch()) {
            //var_dump($row);
            $date_com = $row->date_com;
            $date_comCorrect = date($date_com);
            $tableau[] = new Comment($row->id_comment, $date_comCorrect,$row->text,$row->username,$row->idea,$row->is_deleted);
        }
        # Pour debug : affichage du tableau à renvoyer
        
        return $tableau;
    }

    public function selectVotedIdea($memberConnected) {
        $query = 'SELECT i.*, m.username 
                    FROM ideas i, members m 
                    WHERE i.author=m.id_member
                        AND i.id_idea IN (SELECT v.id_idea
                                            FROM votes v
                                            WHERE v.id_member = :memberConnected)';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':memberConnected',$memberConnected);
        $ps->execute();

        $tableau = array();
        while ($row = $ps->fetch()) {
            //var_dump($row);
            $tableau[] = new Idea($row->id_idea,$row->username,$row->title,$row->text,$row->status,$row->submitted_date,$row->accepted_date,$row->refused_date,$row->closed_date,null,null);
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
            $tableau[] = new Idea($row->id_idea,$row->username,$row->title,$row->text,$row->status,$row->submitted_date,$row->accepted_date,$row->refused_date,$row->closed_date,null,null);
        }
        # Pour debug : affichage du tableau à renvoyer
        
        return $tableau;
    }

    public function selectIdeaInFucntionOfPopularity($numberToDisplay) {
        $query = 'SELECT i.*, m.username FROM ideas i, members m WHERE i.author=m.id_member LIMIT '. $numberToDisplay;
        $ps = $this->_db->prepare($query);
        $ps->execute();

        $tableau = array();
        while ($row = $ps->fetch()) {
            //var_dump($row);
            $tableau[] = new Idea($row->id_idea,$row->username,$row->title,$row->text,$row->status,$row->submitted_date,$row->accepted_date,$row->refused_date,$row->closed_date,null,null);
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
            $tableau[] = new Idea($row->id_idea,$row->author,$row->title,$row->text,$row->status,$row->submitted_date,$row->accepted_date,$row->refused_date,$row->closed_date,null,null);
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
            $tableau[] = new Idea($row->id_idea,$row->author,$row->title,$row->text,$row->status,$row->submitted_date,$row->accepted_date,$row->refused_date,$row->closed_date,null,null);
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

    public function setDisable($id_member) {
        $query ='UPDATE members SET disabled_account = 1 WHERE id_member = :id_member';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':id_member',$id_member);
        $ps->execute();
    }

    public function setStatusAccepted($id_idea,$accepted_date) {
        $query ='UPDATE ideas SET status = :accepted, accepted_date = :accepted_date WHERE id_idea = :id_idea';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':accepted', 'accepted');
        $ps->bindValue(':id_idea',$id_idea);
        $ps->bindValue(':accepted_date',$accepted_date);
        $ps->execute();
    }
    public function setStatusRefused($id_idea,$refused_date) {        
        $query ='UPDATE ideas SET status = :refused , refused_date = :refused_date WHERE id_idea = :id_idea';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':refused', 'refused');
        $ps->bindValue(':id_idea',$id_idea);
        $ps->bindValue(':refused_date',$refused_date);
        $ps->execute();
    }
    public function setStatusClosed($id_idea,$closed_date) {      
        $query ='UPDATE ideas SET status = :closed , closed_date = :closed_date WHERE id_idea = :id_idea';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':closed', 'closed');
        $ps->bindValue(':id_idea',$id_idea);
        $ps->bindValue(':closed_date',$closed_date);
        $ps->execute();
    }

    public function markCommentAsDeleted($id_comment) {
        $query ='UPDATE comments SET is_deleted = 1 WHERE id_comment = :idcomment';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':idcomment',$id_comment);
        $ps->execute();
    }
    


}