<?php 
class Vote{

    private $_id_member;
    private $_id_idea;

    public function __construct($id_member, $id_idea){

        $this->_id_member = $id_member;
        $this->_id_idea = $id_idea;
       
    }

    
    public function getId_member(){
        return $this->_id_member;
    }

    public function getId_idea(){
        return $this->_id_idea;
    }

    public function html_Id_member(){
        return htmlspecialchars($this->_id_member);
    }

    public function html_Id_idea(){
        return htmlspecialchars($this->_id_idea);
    }

}
?>