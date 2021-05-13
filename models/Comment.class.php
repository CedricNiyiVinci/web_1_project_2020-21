<?php 
class Comment{
    private $_id_comment;
    private $_created_date ;
    private $_text;
    private $_author;
    private $_idea;
    private $_is_deleted;
    private $_title_of_idea_commented;
    private $_username_of_idea_commented;


    public function __construct($id_comment, $created_date , $text, $author, $idea, $is_deleted, $title_of_idea_commented, $username_of_idea_commented){

        $this->_id_comment = $id_comment;
        $this->_created_date  = $created_date ;
        $this->_text = $text;
        $this->_author = $author;
        $this->_idea = $idea;
        $this->_is_deleted = $is_deleted;
        $this->_title_of_idea_commented = $title_of_idea_commented;
        $this->_username_of_idea_commented = $username_of_idea_commented;
    }

        //A adapter
    public function getCreated_date (){
        return $this->_created_date ;
    }

    public function getId_Comment(){
        return $this->_id_comment;
    }

    public function getDate_day_com(){
        $_new_created_date  = substr($this->_created_date , 0, 10);   
        $date = str_replace('-"', '/',$_new_created_date );  
        $newDate = date("d/m/Y", strtotime($date));
        return $newDate;
    }

    public function getDate_time_com(){
        $_new_time_com = substr($this->_created_date , 10, -3);   
        return $_new_time_com;
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

    public function getTitle_of_idea_commented(){
        return $this->_title_of_idea_commented;
    }

    public function getUsername_of_idea_commented(){
        return $this->_username_of_idea_commented;
    }

    public function isDeleted(){
        return $this->_is_deleted;
    }

    public function html_Id_Comment(){
        return htmlspecialchars($this->_id_comment);
    }
    
    public function html_Created_Cate (){
        return htmlspecialchars($this->_created_date );
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
    public function html_Username_of_idea_commented(){
        return htmlspecialchars($this->_username_of_idea_commented);
    }
    public function html_Title_of_idea_commented(){
        return htmlspecialchars($this->_title_of_idea_commented);
    }

}
?>