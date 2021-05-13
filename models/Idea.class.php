<?php 
class Idea{

    // All the atttributes of the object --> Idea

    private $_id_idea;
    private $_author;
    private $_title;
    private $_text;
    private $_status;
    private $_submitted_date;
    private $_accepted_date;
    private $_refused_date;
    private $_closed_date;
    private $_number_of_votes;      // Bonus : number of votes for the current idea
    private $_number_of_comments;   // Bonus : number of comments for the current idea

    // constuctor : help me to initialize all the attributes of the object --> Idea 
    public function __construct($id_idea, $author, $title, $text, $status, $submitted_date, $accepted_date, $refused_date, $closed_date, $number_of_votes, $number_of_comments){

        $this->_id_idea = $id_idea;
        $this->_author = $author;
        $this->_title = $title;
        $this->_text = $text;
        $this->_status = $status;
        $this->_submitted_date = $submitted_date;
        $this->_accepted_date = $accepted_date;
        $this->_refused_date = $refused_date;
        $this->_closed_date = $closed_date;
        $this->_number_of_votes = $number_of_votes;
        $this->_number_of_comments = $number_of_comments;
    }

    #----------------------------------------------------------------------------
    #   Getters
    #---------------------------------------------------------------------------- 

    
    public function getId_idea(){
        return $this->_id_idea;
    }

    public function getAuthor(){
        return $this->_author;
    }

    public function getTitle(){
        return $this->_title;
    }

    public function getText(){
        return $this->_text;
    }

    public function getStatus(){
        return $this->_status;
    }

    public function getSubmitted_date(){
        return $this->_submitted_date;
    }

    public function getAccepted_date(){
        return $this->_accepted_date;
    }

    public function getRefused_date(){
        return $this->_refused_date;
    }

    public function getClosed_date(){
        return $this->_closed_date;
    }
    
    public function getNumber_of_votes(){
        return $this->_number_of_votes;
    }

    public function getNumber_of_comments(){
        return $this->_number_of_comments;
    }

    #----------------------------------------------------------------------------
    #   Special getters to avoid html problems
    #----------------------------------------------------------------------------

    public function html_Id_idea(){
        return htmlspecialchars($this->_id_idea);
    }

    public function html_Author(){
        return htmlspecialchars($this->_author);
    }

    public function html_Title(){
        return htmlspecialchars($this->_title);
    }

    public function html_Text(){
        return htmlspecialchars($this->_text);
    }

    public function html_Status(){
        return htmlspecialchars($this->_status);
    }

    public function html_Submitted_date(){
        return htmlspecialchars($this->_submitted_date);
    }

    public function html_Accepted_date(){
        return htmlspecialchars($this->_accepted_date);
    }

    public function html_Refused_date(){
        return htmlspecialchars($this->_refused_date);
    }

    public function html_Closed_date(){
        return htmlspecialchars($this->_closed_date);
    }

}
?>