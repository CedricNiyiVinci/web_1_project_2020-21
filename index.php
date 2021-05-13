<?php
    
    # Global site variables
	define('VIEWS_PATH','views/');
    define('CONTROLLERS_PATH','controllers/');

    #session mechanism activate
    session_start();

    #Automated for require classes
	function loadClass($className) {
		require_once('models/' . $className . '.class.php');
	}
	spl_autoload_register('loadClass');

    # Connexion to the database
	$db=Db::getInstance();

    # Write here the header common to all views
	require_once(VIEWS_PATH.'header.php'); 

    # If there's no GET variable 'action' in the URL, it is created here with the value 'login'
	if (empty($_GET['action'])) {
        $_GET['action'] = 'login';
    }
	
    # Switch case on the action requested by the GET variable 'action' specified in the URL
    # index.php?action=...
	switch ($_GET['action']) {

	case 'idealistadmin':  # action=idealistadmin
            require_once(CONTROLLERS_PATH.'IdeaListAdminController.php');
            $controller = new IdeaListAdminController($db);
            break;
	case 'login':  # action=login
            require_once(CONTROLLERS_PATH.'LoginController.php');
            $controller = new LoginController($db);
            break;
    case 'logout':  # action=logout
            require_once(CONTROLLERS_PATH.'LogoutController.php');
            $controller = new LogoutController();
            break;
	case 'memberlistadmin':  # action=memberlistadmin
            require_once(CONTROLLERS_PATH.'MemberListAdminController.php');
            $controller = new MemberListAdminController($db);
            break;
	case 'postcomments':  # action=postcomments
            require_once(CONTROLLERS_PATH.'PostCommentsController.php');
            $controller = new PostCommentsController($db);
            break;
    case 'profile':  # action=profile
            require_once(CONTROLLERS_PATH.'ProfileController.php');
            $controller = new ProfileController($db);
            break;
	case 'registration':  # action=registration
            require_once(CONTROLLERS_PATH.'RegistrationController.php');
            $controller = new RegistrationController($db);
            break;
	case 'timelineidea':  # action=timelineidea
            require_once(CONTROLLERS_PATH.'TimeLineIdeasController.php');
            $controller = new TimeLineIdeasController($db);
            break;
            
        default:        # dans tous les autres cas l'action=home In all other case action=timelineidea
            require_once(CONTROLLERS_PATH.'TimeLineIdeasController.php');
            $controller = new TimeLineIdeasController($db);
            break;
    }
        #   Execution of the controller defined in the previous switch
		$controller->run();

    # Write here the common footer for all views
	require_once(VIEWS_PATH.'footer.php');
?>