<?php 
class Vote{

    // All the atttributes of the object --> Vote

    private $_id_member;
    private $_id_idea;

    // constuctor : help me to initialize all the attributes of the object --> Vote
    public function __construct($id_member, $id_idea){

        $this->_id_member = $id_member;
        $this->_id_idea = $id_idea;
       
    }

    #----------------------------------------------------------------------------
    #   Getters
    #---------------------------------------------------------------------------- 
    
    public function getId_member(){
        return $this->_id_member;
    }

    public function getId_idea(){
        return $this->_id_idea;
    }

    #----------------------------------------------------------------------------
    #   Special getters to avoid html problems
    #----------------------------------------------------------------------------

    public function html_Id_member(){
        return htmlspecialchars($this->_id_member);
    }

    public function html_Id_idea(){
        return htmlspecialchars($this->_id_idea);
    }

}
?>