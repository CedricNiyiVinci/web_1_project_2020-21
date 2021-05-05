<?php 
class Member{
    private $_id_member;
    private $_username;
    private $_password;
    private $_hierarchy_level;
    private $_email;
    private $_disabled_account;


    public function __construct($id_member, $username, $password, $hierarchy_level, $email,$disabled_account){

        $this->_id_member = $id_member;
        $this->_username = $username;
        $this->_password = $password;
        $this->_hierarchy_level = $hierarchy_level;
        $this->_email = $email;
        $this->_disabled_account = $disabled_account;

    }

        //A adapter
    public function getId_member(){
        return $this->_id_member;
    }

    public function getUsername(){
        return $this->_username;
    }

    public function getPassword(){
        return $this->_password;
    }

    public function getHierarchy_level(){
        return $this->_hierarchy_level;
    }

    public function getEmail(){
        return $this->_email;
    }
    
    public function getDisabled_account(){
        return $this->_disabled_account;
    }

    public function html_Id_member(){
        return htmlspecialchars($this->_id_member);
    }

    public function html_Username(){
        return htmlspecialchars($this->_username);
    }

    public function html_Password(){
        return htmlspecialchars($this->_password);
    }

    public function html_Hierarchy_level(){
        return htmlspecialchars($this->_hierarchy_level);
    }

    public function html_Email(){
        return htmlspecialchars($this->_email);
    }

    public function html_Disabled_account(){
        return htmlspecialchars($this->_disabled_account);
    }
}
?>