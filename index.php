<?php
	define('VIEWS_PATH','views/');

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
        case 'profil':  # action=Profil
            require_once(CONTROLLERS_PATH.'ProfilController.php');
            $controller = new ProfilController($db);
            break;
		case 'login':  # action=Login
            require_once(CONTROLLERS_PATH.'LoginController.php');
            $controller = new LoginController($db);
            break;
		case 'registration':  # action=registration
            require_once(CONTROLLERS_PATH.'RegistrationController.php');
            $controller = new RegistrationController($db);
            break;
		case 'timelineidea':  # action=timelineidea
            require_once(CONTROLLERS_PATH.'TimeLineIdeaController.php');
            $controller = new TimeLineIdeaController($db);
            break;

        default:        # dans tous les autres cas l'action=home
            require_once(CONTROLLERS_PATH.'HomeController.php');
            $controller = new HomeController($db);
            break;
    }
		$controller->run();

	require_once(VIEWS_PATH.'footer.php');
?>