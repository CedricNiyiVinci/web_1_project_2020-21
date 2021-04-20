<?php
	define('VIEWS_PATH','views/');
      define('CONTROLLERS_PATH','controllers/');

	function loadClass($className) {
		require_once('models/' . $className . '.class.php');
	}
	spl_autoload_register('loadClass');

	$db=Db::getInstance();

	require_once(VIEWS_PATH.'header.php'); 

	if (empty($_GET['action'])) {
        $_GET['action'] = 'home';
    }
	
	switch ($_GET['action']) {

	 case 'idealistadmin':  # action=idealistadmin
            require_once(CONTROLLERS_PATH.'IdeaListAdminController.php');
            $controller = new IdeaListAdminController($db);
            break;
	 case 'login':  # action=Login
            require_once(CONTROLLERS_PATH.'LoginController.php');
            $controller = new LoginController($db);
            break;
	 case 'memberlistadmin':  # action=idealistadmin
            require_once(CONTROLLERS_PATH.'MemberListAdminController.php');
            $controller = new MemberListAdminController($db);
            break;
	 case 'postcomments':  # action=idealistadmin
            require_once(CONTROLLERS_PATH.'PostCommentsController.php');
            $controller = new PostCommentsController($db);
            break;
       case 'profil':  # action=Profil
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
        default:        # dans tous les autres cas l'action=home
            require_once(CONTROLLERS_PATH.'HomeController.php');
            $controller = new HomeController($db);
            break;
    }
		$controller->run();

	require_once(VIEWS_PATH.'footer.php');
?>