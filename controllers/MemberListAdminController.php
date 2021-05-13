<?php 
class MemberListAdminController {

	private $_db;
		
	public function __construct($db){	
		$this->_db = $db;
	}
	
	public function run(){	

		# If a malicious person writes ?action=memberlistadmin while he isn't authenticated
		# he will be redirected to the login page
        if (empty($_SESSION['authenticated'])) {
			header("Location: index.php?action=login"); # HTTP redirection to action "login", the user his redirected to the login page
			die(); 
		}

        # If a normal member writes ?action=memberlistadmin while he is connected
		# he will be redirected to his profile page
        if($_SESSION['hierarchy_level'] == 'member') { 
            header("Location: index.php?action=profile");  # HTTP redirection to action "profile", the user his redirected to his profile page
            die();
        } 


		$notification = "Page référanciant toutes les membres inscrits sur le site. Page exclusive aux administrateurs !";
        $notificationAction = "";

        # -------------------------------------------------------------------------------------
        # Form that check if the admin want to see all the ideas of one specific member,
		# this form is originally empty but as soon as he clicks on "ideas of the member" 
        # $_POST['idea_member'], a table, is filled with the unique ID of that member.
        # And with that id_member he can show all the ideas of that member on another page
        # -------------------------------------------------------------------------------------
        if(!empty($_POST['idea_member'])){
            # With that foreach loop we want to catch that id_member that are in the table $_POST['idea_member']
            foreach ($_POST['idea_member'] as $id_member => $no_concern) { //$id_member is the primary key of the members table so we use it here
               $tabMemberIdeas = $this->_db->selectMemberIdea($id_member); // We select all the ideas of that specific $member
               $usernameOfTheMember = $this->_db->findUsernameWithIdMember($id_member); // I select the username of the member to display it on ideaofmember.php
               $notificationSpecificMember = "Toutes les idées postées par $usernameOfTheMember";
               require_once(VIEWS_PATH.'ideaofmember.php');  // Redirect the admin to another page where he can see all the ideas of that specific member selected
               die();
            }
        

        # -------------------------------------------------------------------------------------
        # Form that check if the admin want to disable a member,this form is originally empty 
		# but as soon as he want to disable one of the member $_POST['form_disable'] is filled 
		# with the unique ID of that member.
        # -------------------------------------------------------------------------------------
        }elseif (!empty($_POST['form_disable']) ) {
            # With that foreach loop we want to catch that id_member that are in the table $_POST['form_disable']
            $usernameOfTheMember="";
            foreach ($_POST['form_disable'] as $id_member => $no_concern) {
                $usernameOfTheMember = $this->_db->findUsernameWithIdMember($id_member); // I select the username of the member.
                $this->_db->setDisable($id_member); # In my datebase, I will mark that member as disabled but I will not erase or delete this member.
            }
            $notificationAction = "Vous venez de désactivé <strong>$usernameOfTheMember</strong> du site!";
        

        # -------------------------------------------------------------------------------------
        # Form that check if the admin want to upgrade a member to the admin grade,this form 
		# is originally empty but as soon as he want to updrade a member $_POST['hierarchy_admin'] is filled 
		# with the unique ID of that member.
        # -------------------------------------------------------------------------------------
        }elseif(!empty($_POST['hierarchy_admin'])){
                $usernameOfTheMember = "";
                foreach ($_POST['hierarchy_admin'] as $id_member => $no_concern) {
                    # $_hierarchy_level is the grade that a member can have (member or admin)
                    $usernameOfTheMember = $this->_db->findUsernameWithIdMember($id_member); // I select the username of the member to display it on ideaofmember.php
                    $this->_db->upgradeToAdminGrade($id_member); # In my datebase, I will change the grade of that member to admin!            
                }
                    $notificationAction = "Vous avez promu <strong>$usernameOfTheMember</strong>. Maintenant, ce membre fait partie des <strong>administrateurs</strong> de ce site."; 
        }
        $tabMembers = $this->_db->selectMembers(); // we select all the members from our database
		require_once(VIEWS_PATH.'memberlistadmin.php');
        
        
	}
	
}
?>