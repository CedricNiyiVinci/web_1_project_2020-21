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

    #-----------------------------------------------------------------------------------------------------------------
    #-----------------------------------------------------------------------------------------------------------------
    #   Selection functions
    #-----------------------------------------------------------------------------------------------------------------
    #-----------------------------------------------------------------------------------------------------------------

    # Function that executes a SELECT in the table Ideas
    # and returns the ID of author of an idea 
    public function selectIdAuthorFromAnIdea($id_idea){
        $query = 'SELECT author FROM ideas WHERE id_idea = :ididea';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':ididea',$id_idea);
        $ps->execute();

        $row = $ps->fetch();
        $id_author= ($row->author);
        return $id_author; 
    }

    # Function that executes a SELECT in the table Ideas
    # and returns the TITLE of an idea 
    public function selectTitleFromAnIdea($id_idea){
        $query = 'SELECT title FROM ideas WHERE id_idea = '. $id_idea;
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':ididea',$id_idea);
        $ps->execute();
        $row = $ps->fetch();
        
        $title_idea = ($row->title);
        return $title_idea; 
    }

    # Function that executes a SELECT in the table Ideas and the table Members
    # and returns the username of the author of an idea.  
    public function selectUsernameAuthorFromAnIdea($id_idea){
        $query = 'SELECT m.username FROM ideas i, members m WHERE i.author = m.id_member AND id_idea = '. $id_idea;
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':ididea',$id_idea);
        $ps->execute();

        $row = $ps->fetch();
        $username_author = ($row->username);
        return $username_author; 
    }

    # Function that executes a SELECT in the table Ideas, Members, Votes and Comments
    # and returns an array of object(s) of the class Ideas
    public function selectIdea() {
        $query = 'SELECT i.*, m.username, COUNT(DISTINCT v.id_member) AS "nbr_votes", COUNT(DISTINCT c.id_comment) AS "nbr_comments"
                    FROM ideas i 
                    LEFT JOIN members m 
                    ON m.id_member = i.author
                    LEFT JOIN votes v
                    ON v.id_idea = i.id_idea 
                    LEFT JOIN comments c
                    ON c.idea = i.id_idea
                    GROUP BY i.id_idea
                    ORDER BY i.submitted_date DESC';
        $ps = $this->_db->prepare($query);
        $ps->execute();

        $tableau = array();
        while ($row = $ps->fetch()) {
            $tableau[] = new Idea($row->id_idea,$row->username,$row->title,$row->text,$row->status,$row->submitted_date,$row->accepted_date,$row->refused_date,$row->closed_date,$row->nbr_votes,$row->nbr_comments);
        }
        
        return $tableau;
    }
    
    # Function that executes a SELECT in the table Ideas, Members, Votes and Comments
    # and returns an object of the class Ideas
    public function selectOneIdea($id_idea){
        $query = 'SELECT i.*, m.username, COUNT(DISTINCT v.id_member) AS "nbr_votes", COUNT(DISTINCT c.id_comment) AS "nbr_comments"
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
        $ideaSelected = new Idea($row->id_idea,$row->username,$row->title,$row->text,$row->status,$row->submitted_date,$row->accepted_date,$row->refused_date,$row->closed_date,$row->nbr_votes,$row->nbr_comments);
            return $ideaSelected;
    }

    # Function that executes a SELECT in the table Comments and Members 
    # and returns an array of object(s) of the class Comments
    # Comment of a specific idea
    public function selectCommentIdea($id_idea){
        $query = 'SELECT m.username, c.*
                    FROM comments c, members m  
                    WHERE c.author = m.id_member AND c.idea = :idselected';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':idselected',$id_idea);
        $ps->execute();

        $table = array();
        while ($row = $ps->fetch()) {
            $created_date  = $row->created_date;
            $created_dateCorrect = date($created_date);
            $table[] = new Comment($row->id_comment, $created_dateCorrect,$row->text,$row->username,$row->idea,$row->is_deleted, null, null);
        }
        
        return $table;
    }

    # Function that executes a SELECT in the table Comments, Members and Ideas
    # and returns an array of object(s) of the class Comments
    # Comment of a specific member
    public function selectCommentUser($id_member){
        $query = 'SELECT c.*, i.author, i.title, m.username 
                    FROM comments c, ideas i, members m 
                    WHERE c.idea = i.id_idea 
                        AND i.author = m.id_member 
                        AND c.author = :id_member
                        ORDER BY c.created_date DESC';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':id_member',$id_member);
        $ps->execute();

        $tableau = array();
        while ($row = $ps->fetch()) {
            $created_date  = $row->created_date ;
            $created_dateCorrect = date($created_date);
            $tableau[] = new Comment($row->id_comment,$created_dateCorrect,$row->text,$row->username,$row->idea,$row->is_deleted, $row->title, $row->username);
        }
        
        return $tableau;
    }

    # Function that executes a SELECT in the table Ideas and Members
    # and returns an array of object(s) of the class Ideas
    # Ideas voted by a specific member
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
            $tableau[] = new Idea($row->id_idea,$row->username,$row->title,$row->text,$row->status,$row->submitted_date,$row->accepted_date,$row->refused_date,$row->closed_date,null,null);
        }
        
        return $tableau;
    }

    # Function that executes a SELECT in the table Ideas, Members, Votes ans Comments
    # and returns an array of object(s) of the class Ideas.
    # The array is sorted by popularity, most votes at the top and in filtred by a specific type of status
    public function selectIdeaInFucntionOfStatusPopularitySort($statuschosed) {
        $query = 'SELECT i.*, m.username, COUNT(DISTINCT v.id_member) AS "nbr_votes", COUNT(DISTINCT c.id_comment) AS "nbr_comments"
        FROM ideas i 
        LEFT JOIN members m 
        ON m.id_member = i.author
        LEFT JOIN votes v
        ON v.id_idea = i.id_idea 
        LEFT JOIN comments c
        ON c.idea = i.id_idea
        WHERE i.status=:statuschosed
        GROUP BY i.id_idea
        ORDER BY COUNT(DISTINCT v.id_member) DESC';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':statuschosed',$statuschosed);
        $ps->execute();

        $tableau = array();
        while ($row = $ps->fetch()) {
            $tableau[] = new Idea($row->id_idea,$row->username,$row->title,$row->text,$row->status,$row->submitted_date,$row->accepted_date,$row->refused_date,$row->closed_date,$row->nbr_votes,$row->nbr_comments);
        }
        
        return $tableau;
    }

    # Function that executes a SELECT in the table Ideas, Members, Votes ans Comments
    # and returns an array of object(s) of the class Ideas.
    # The array is sorted by chronological order, most recent at the top and in filtred by a specific type of status
    public function selectIdeaInFucntionOfStatusChronologicalSort($statuschosed) {
        $query = 'SELECT i.*, m.username, COUNT(DISTINCT v.id_member) AS "nbr_votes", COUNT(DISTINCT c.id_comment) AS "nbr_comments"
        FROM ideas i 
        LEFT JOIN members m 
        ON m.id_member = i.author
        LEFT JOIN votes v
        ON v.id_idea = i.id_idea 
        LEFT JOIN comments c
        ON c.idea = i.id_idea
        WHERE i.status=:statuschosed
        GROUP BY i.id_idea
        ORDER BY i.submitted_date DESC';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':statuschosed',$statuschosed);
        $ps->execute();
        var_dump($statuschosed);
        $tableau = array();
        while ($row = $ps->fetch()) {
            
            $tableau[] = new Idea($row->id_idea,$row->username,$row->title,$row->text,$row->status,$row->submitted_date,$row->accepted_date,$row->refused_date,$row->closed_date,$row->nbr_votes,$row->nbr_comments);
        }
        
        return $tableau;
    }

    # Function that executes a SELECT in the table Ideas, Members, Votes ans Comments
    # and returns an array of object(s) of the class Ideas.
    # The array is sorted by popularity, most votes at the top and in filtred by a specific number of ideas to select
    public function selectIdeaInFucntionOfPopularity($numberToDisplay) {
        $query = 'SELECT i.*, m.username, COUNT(DISTINCT v.id_member) AS "nbr_votes", COUNT(DISTINCT c.id_comment) AS "nbr_comments"
        FROM ideas i 
        LEFT JOIN members m 
        ON m.id_member = i.author
        LEFT JOIN votes v
        ON v.id_idea = i.id_idea 
        LEFT JOIN comments c
        ON c.idea = i.id_idea
        GROUP BY i.id_idea
        ORDER BY COUNT(DISTINCT v.id_member) DESC
        LIMIT '. $numberToDisplay;
        $ps = $this->_db->prepare($query);
        $ps->execute();

        $tableau = array();
        while ($row = $ps->fetch()) {
            $tableau[] = new Idea($row->id_idea,$row->username,$row->title,$row->text,$row->status,$row->submitted_date,$row->accepted_date,$row->refused_date,$row->closed_date,$row->nbr_votes,$row->nbr_comments);
        }
        return $tableau;
    }

    # Function that executes a SELECT in the table Ideas, Members, Votes ans Comments
    # and returns an array of object(s) of the class Ideas.
    # The array is sorted by popularity, most votes at the top. [ALL THE IDEAS]
    public function selectAllIdeaInFucntionOfPopularity() {
        $query = 'SELECT i.*, m.username, COUNT(DISTINCT v.id_member) AS "nbr_votes", COUNT(DISTINCT c.id_comment) AS "nbr_comments"
        FROM ideas i 
        LEFT JOIN members m 
        ON m.id_member = i.author
        LEFT JOIN votes v
        ON v.id_idea = i.id_idea 
        LEFT JOIN comments c
        ON c.idea = i.id_idea
        GROUP BY i.id_idea
        ORDER BY COUNT(DISTINCT v.id_member) DESC';
        $ps = $this->_db->prepare($query);
        $ps->execute();

        $tableau = array();
        while ($row = $ps->fetch()) {
            $tableau[] = new Idea($row->id_idea,$row->username,$row->title,$row->text,$row->status,$row->submitted_date,$row->accepted_date,$row->refused_date,$row->closed_date,$row->nbr_votes,$row->nbr_comments);
        }

        return $tableau;
    }

    # Function that executes a SELECT in the table Ideas, Members, Votes ans Comments
    # and returns an array of object(s) of the class Ideas.
    # The array is sorted by chronological order, most recent at the top. [ALL THE IDEAS]
    public function selectAllIdeaInFucntionOfDate() {
        $query = 'SELECT i.*, m.username, COUNT(DISTINCT v.id_member) AS "nbr_votes", COUNT(DISTINCT c.id_comment) AS "nbr_comments"
        FROM ideas i 
        LEFT JOIN members m 
        ON m.id_member = i.author
        LEFT JOIN votes v
        ON v.id_idea = i.id_idea 
        LEFT JOIN comments c
        ON c.idea = i.id_idea
        GROUP BY i.id_idea
        ORDER BY i.submitted_date DESC';
        $ps = $this->_db->prepare($query);
        $ps->execute();

        $tableau = array();
        while ($row = $ps->fetch()) {
            $tableau[] = new Idea($row->id_idea,$row->username,$row->title,$row->text,$row->status,$row->submitted_date,$row->accepted_date,$row->refused_date,$row->closed_date,$row->nbr_votes,$row->nbr_comments);
        }
        
        return $tableau;
    }

    # Function that executes a SELECT in the table Ideas, Members, Votes ans Comments
    # and returns an array of object(s) of the class Ideas.
    # The array is sorted by chronological order, most recent at the top and in filtred by a specific number of ideas to select
    public function selectIdeaInFucntionOfDate($numberToDisplay) {
        $query = 'SELECT i.*, m.username, COUNT(DISTINCT v.id_member) AS "nbr_votes", COUNT(DISTINCT c.id_comment) AS "nbr_comments"
        FROM ideas i 
        LEFT JOIN members m 
        ON m.id_member = i.author
        LEFT JOIN votes v
        ON v.id_idea = i.id_idea 
        LEFT JOIN comments c
        ON c.idea = i.id_idea
        GROUP BY i.id_idea
        ORDER BY i.submitted_date DESC
        LIMIT '. $numberToDisplay;
        $ps = $this->_db->prepare($query);
        $ps->execute();

        $tableau = array();
        while ($row = $ps->fetch()) {     
            $tableau[] = new Idea($row->id_idea,$row->username,$row->title,$row->text,$row->status,$row->submitted_date,$row->accepted_date,$row->refused_date,$row->closed_date,$row->nbr_votes,$row->nbr_comments);
        }
        
        return $tableau;
    }

    # Function that executes a SELECT in the table Ideas (and a subselect in the table Members)
    # and returns an array of object(s) of the class Ideas.
    # The array contains the ideas of a specific user. Ideas of the user currently connected with the email he used to log in.
    public function selectMyIdea($email) {
        $query = 'SELECT i.* FROM ideas i WHERE i.author = (SELECT m.id_member  FROM members m WHERE m.e_mail = :email)';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':email',$email);
        $ps->execute();

        $tableau = array();
        while ($row = $ps->fetch()) {
            $tableau[] = new Idea($row->id_idea,$row->author,$row->title,$row->text,$row->status,$row->submitted_date,$row->accepted_date,$row->refused_date,$row->closed_date,null,null);
        }
        
        return $tableau;
    }

    # Function that executes a SELECT in the table Ideas (and a subselect in the table Members)
    # and returns an array of object(s) of the class Ideas.
    # The array contains the ideas of a specific user. We use the id_member of a member to make that select research into our database.
    public function selectMemberIdea($id_member) {
        $query = 'SELECT i.* FROM ideas i WHERE i.author = (SELECT m.id_member FROM members m WHERE m.id_member = :id_member)';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':id_member',$id_member);
        $ps->execute();
        $tableau = array();
        while ($row = $ps->fetch()) {
            $tableau[] = new Idea($row->id_idea,$row->author,$row->title,$row->text,$row->status,$row->submitted_date,$row->accepted_date,$row->refused_date,$row->closed_date,null,null);
        }
        
        return $tableau;
    }

    # Function that executes a SELECT in the table Members
    # and returns an array of object(s) of the class Members. [ALL THE MEMBERS]
    public function selectMembers() {
        $query = 'SELECT m.* FROM members m';
        $ps = $this->_db->prepare($query);
        $ps->execute();

        $tableau = array();
        while ($row = $ps->fetch()) {
            $tableau[] = new Member($row->id_member,$row->username,$row->password,$row->hierarchy_level,$row->e_mail,$row->disabled_account);
        }
        
        return $tableau;
    }

    #-----------------------------------------------------------------------------------------------------------------
    #-----------------------------------------------------------------------------------------------------------------
    #   Insertion functions
    #-----------------------------------------------------------------------------------------------------------------
    #-----------------------------------------------------------------------------------------------------------------

    # Function that executes an INSERT in the ideas table
    # We add a new idea into our database
    public function insertIdea($author,$title_idea,$text_idea,$date) {
            $query = 'INSERT INTO ideas (author, title, text, submitted_date, status) values (:idmember, :title, :text, :date, "submitted")';
            $ps = $this->_db->prepare($query);
            $ps->bindValue(':idmember',$author);
            $ps->bindValue(':title',$title_idea);
            $ps->bindValue(':text',$text_idea);
            $ps->bindValue(':date',$date);
            $ps->execute();
    }

    # Function that executes an INSERT in the comments table
    # We add a new comment into our database
    public function addACommentToIdea($date, $text, $author, $id_dea){
        $query = 'INSERT INTO comments (created_date , text, author, idea) values (:date, :text, :author, :ididea)';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':date',$date);
        $ps->bindValue(':text',$text);
        $ps->bindValue(':author',$author);
        $ps->bindValue(':ididea',$id_dea);
        $ps->execute();
    }

    # Function that executes an INSERT in the votes table
    # We add a new vote into our database
    public function votePourIdee($id_member, $id_idea){
        $query = 'INSERT INTO votes (id_member, id_idea) values (:idmember, :ididea)';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':idmember',$id_member);
        $ps->bindValue(':ididea',$id_idea);
        $ps->execute();
    } 

    # Function that executes an INSERT in the members table
    # We add a new member into our database
    public function insertMember($username,$email,$password) {
        $query = 'INSERT INTO members (username, e_mail, password) values (:username, :email, :password)';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':username',$username);
        $ps->bindValue(':email',$email);
        $ps->bindValue(':password',$password);
        $ps->execute();
    }

    #-----------------------------------------------------------------------------------------------------------------
    #-----------------------------------------------------------------------------------------------------------------
    #   Update functions
    #-----------------------------------------------------------------------------------------------------------------
    #-----------------------------------------------------------------------------------------------------------------

    # Function that executes an UPDATE in the members table
    # We upgrade to admin grade a member.
    public function upgradeToAdminGrade($id_member) {
        $query = 'UPDATE members SET hierarchy_level = :admin WHERE id_member = :id_member';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':admin', 'admin');
        $ps->bindValue(':id_member',$id_member);
        $ps->execute();
    }

    # Function that executes an UPDATE in the members table
    # We disable a member.
    public function setDisable($id_member) {
        $query ='UPDATE members SET disabled_account = 1 WHERE id_member = :id_member';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':id_member',$id_member);
        $ps->execute();
    }

    # Function that executes an UPDATE in the ideas table
    # We change the status of an idea to "accepted"
    public function setStatusAccepted($id_idea,$accepted_date) {
        $query ='UPDATE ideas SET status = :accepted, accepted_date = :accepted_date WHERE id_idea = :id_idea';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':accepted', 'accepted');
        $ps->bindValue(':id_idea',$id_idea);
        $ps->bindValue(':accepted_date',$accepted_date);
        $ps->execute();
    }

    # Function that executes an UPDATE in the ideas table
    # We change the status of an idea to "refused"
    public function setStatusRefused($id_idea,$refused_date) {        
        $query ='UPDATE ideas SET status = :refused , refused_date = :refused_date WHERE id_idea = :id_idea';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':refused', 'refused');
        $ps->bindValue(':id_idea',$id_idea);
        $ps->bindValue(':refused_date',$refused_date);
        $ps->execute();
    }

    # Function that executes an UPDATE in the ideas table
    # We change the status of an idea to "closed"
    public function setStatusClosed($id_idea,$closed_date) {      
        $query ='UPDATE ideas SET status = :closed , closed_date = :closed_date WHERE id_idea = :id_idea';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':closed', 'closed');
        $ps->bindValue(':id_idea',$id_idea);
        $ps->bindValue(':closed_date',$closed_date);
        $ps->execute();
    }

    # Function that executes an UPDATE in the comments table
    # We mark a comment as deleted.
    public function markCommentAsDeleted($id_comment) {
        $query ='UPDATE comments SET is_deleted = 1 WHERE id_comment = :idcomment';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':idcomment',$id_comment);
        $ps->execute();
    }

    #-----------------------------------------------------------------------------------------------------------------
    #-----------------------------------------------------------------------------------------------------------------
    #   Other useful function
    #-----------------------------------------------------------------------------------------------------------------
    #-----------------------------------------------------------------------------------------------------------------

    #  Function that validate the connexion of a member
    public function validateUser($email, $motdepasse){
        $query = 'SELECT password FROM members WHERE e_mail = :email ';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':email',$email);
        $ps->execute();

        if($ps->rowCount() == 0)
            return false;
        $hash = $ps->fetch()->password;
            return password_verify($motdepasse, $hash); #We check with the password_verify function the password entered by the user
    }

    #  Function that finds the username of the user currently connected with the email he entered to log in.
    public function findPseudo($email){
        $query = 'SELECT username FROM members WHERE e_mail = :email ';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':email',$email);
        $ps->execute();

        $row = $ps->fetch();
        $username = ($row->username);
        return $username; 
    }

    #   Function that finds the username of a member with id_member of that user.
    public function findUsernameWithIdMember($id_member){
        $query = 'SELECT username FROM members WHERE id_member = :id_member ';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':id_member',$id_member);
        $ps->execute();

        $row = $ps->fetch();
        $username = ($row->username);
        return $username; 
    }
    
    #   Function that finds the id_member of the user currently connected.
    public function findIdNumber($email){
        $query = 'SELECT id_member FROM members WHERE e_mail = :email ';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':email',$email);
        $ps->execute();

        $row = $ps->fetch();
        $id_member = ($row->id_member);
        return $id_member; 
    }


    #  Function that returns the hierarchy level of a member.
    #  [member] OR [admin]
    public function hierarchyLevelOfTheUser($email){
        $query = 'SELECT hierarchy_level FROM members WHERE e_mail = :email ';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':email',$email);
        $ps->execute();

        $row = $ps->fetch();
        $hierarchy_level = ($row->hierarchy_level);
        return $hierarchy_level; 
    }

    #  Function that verifies if a member is is disabled.
    #  If an user is disabled he can't log in and connect his account on the website
    public function isDisabled($email){
        $query = 'SELECT disabled_account FROM members WHERE e_mail = :email ';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':email',$email);
        $ps->execute();

        $row = $ps->fetch();
        $disabled_account = ($row->disabled_account);
        return $disabled_account; 
    }
    
    #  Function that verifies if a member has already voted for a specific idea
    #  We can only vote one time for an idea.
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
    
    #  Function that validates the username of a possible new member who tries to register on the website.
    #  We can't have the same username more than once in our database.
    public function validateUsername($pseudo){
        $query = 'SELECT count(username) AS "nbr" FROM members WHERE username LIKE :pseudo';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':pseudo',"$pseudo");
        $ps->execute();
        $raw = $ps->fetch();
        if ($raw->nbr>0)
            return false;
        return true;
    }

    #  Function that validates the email of a possible new member who tries to register on the website.
    #  We can't have the same email more than once in our database.
    public function validateEmail($email){
        $query = 'SELECT count(e_mail) AS "nbr" FROM members WHERE e_mail LIKE :email';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':email',"$email");
        $ps->execute();
        $raw = $ps->fetch();
        if ($raw->nbr>0)
            return false;
        return true;
    }

    #   Function that finds the id_member of a member with his pseudo.
    public function getIdMember($pseudo){
        $query = 'SELECT id_member FROM members WHERE username LIKE :pseudo';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':pseudo',"$pseudo");
        $ps->execute();
        $row = $ps->fetch();
        $idMember = ($row->id_member);
        return $idMember;
        
    }
    

    


}