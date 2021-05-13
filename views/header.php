<!DOCTYPE HTML>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>studentvote</title>
        <link rel="stylesheet" type="text/css" href="<?php echo VIEWS_PATH ?>css/Base.css" media="screen">
		</head>
	<body>
	<header>
    <h1>
        StudentsVote
    </h1>
    <p class="sous-titre">
        <strong>HE Vinci Paul Lambin</strong> : bloc 1 en informatique
    </p>
    <?php if (!empty($_SESSION['authenticated'])) { // if someone is on the login page for the first time (he's not authenticated) he won't see the navigation menu. So he has only access to the login page and the registation page?>
        <nav>
            <ul>
                <?php if($_SESSION['hierarchy_level'] == 'member' ) { // if an user is connected he will see the menu but if it's a simple user he has acces to two hyperlinks (his profil and the timeline with the ideas posted)?>
                    <li><a href="index.php?action=profile"> Votre profil</a></li>    
                    <li><a href="index.php?action=timelineidea"> Fil des idées </a></li>
                <?php }elseif($_SESSION['hierarchy_level'] == 'admin' ) { // and if it's an admin he has acces to four hyperlinks (his profil,the timeline with the ideas posted, the list of all the ideas and the list of all the members registred on the site)?>
                    <li><a href="index.php?action=profile"> Votre profil</a></li>    
                    <li><a href="index.php?action=timelineidea"> Fil des idées </a></li>
                    <li><a href="index.php?action=idealistadmin"> La liste de toutes les idées </a></li>
                    <li><a href="index.php?action=memberlistadmin"> La liste de touts les membres </a></li> 
                <?php } ?>    
            </ul>
        </nav>
    <?php } ?>
</header>