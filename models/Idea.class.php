<?php 
class Idea{
    private $_id_idea;
    private $_author;
    private $_title;
    private $_text;
    private $_status;
    private $_submitted_date;
    private $_accepted_date;
    private $_refused_date;
    private $_closed_date;


    public function __construct($id_idea, $author, $title, $text, $status, $submitted_date, $accepted_date, $refused_date, $closed_date){

        $this->_id_idea = $id_idea;
        $this->_author = $author;
        $this->_title = $title;
        $this->_text = $text;
        $this->_status = $status;
        $this->_submitted_date = $submitted_date;
        $this->_accepted_date = $accepted_date;
        $this->_refused_date = $refused_date;
        $this->_closed_date = $closed_date;
    }

        //A adapter
    /*public function getId_idea(){
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

    public function getSubmitter(){
        return $this->_id_comment;
    }

    public function getId_Comment(){
        return $this->_id_comment;
    }

    public function getId_Comment(){
        return $this->_id_comment;
    }

    public function getId_Comment(){
        return $this->_id_comment;
    }


    public function html_Id_Comment(){
        return htmlspecialchars($this->_id_comment);
    }*/
}
?>