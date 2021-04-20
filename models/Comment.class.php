<?php 
class Comment{
    private $_id_comment;
    private $_date_com;
    private $_text;
    private $_author;
    private $_idea;
    private $_is_deleted;


    public function __construct($id_comment, $date_com, $text, $author, $idea, $is_deleted){

        $this->_id_comment = $id_comment;
        $this->_date_com = $date_com;
        $this->_text = $text;
        $this->_author = $author;
        $this->_idea = $idea;
    }

        //A adapter
    public function getId_Comment(){
        return $this->_id_comment;
    }

    public function getDate_com(){
        return $this->_date_com;
    }

    public function getText(){
        return $this->_text;
    }
    public function getAuthor(){
        return $this->_author;
    }

    public function getIdea(){
        return $this->_idea;
    }

    public function isDeleted(){
        return $this->_is_deleted;
    }

    public function html_Id_Comment(){
        return htmlspecialchars($this->_id_comment);
    }
    
    public function html_Date_com(){
        return htmlspecialchars($this->_date_com);
    }

    public function html_Text(){
        return htmlspecialchars($this->_text);
    }

    public function html_Author(){
        return htmlspecialchars($this->_author);
    }

    public function html_Idea(){
        return htmlspecialchars($this->_idea);
    }

}
?>