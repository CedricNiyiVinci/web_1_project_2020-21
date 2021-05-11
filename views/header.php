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
    <?php if (!empty($_SESSION['authentifie'])) { ?>
        <nav>
            <ul>
                
                    <?php if($_SESSION['hierarchy_level'] == 'member' ) { ?>
                        <li><a href="index.php?action=profile"> Votre profil</a></li>    
                        <li><a href="index.php?action=timelineidea"> Fil des idées </a></li>
                    <?php }elseif($_SESSION['hierarchy_level'] == 'admin' ) { ?>
                        <li><a href="index.php?action=profile"> Votre profil</a></li>    
                        <li><a href="index.php?action=timelineidea"> Fil des idées </a></li>
                        <li><a href="index.php?action=idealistadmin"> La liste de toutes les idées </a></li>
                        <li><a href="index.php?action=memberlistadmin"> La liste de touts les membres </a></li> 
                    <?php } ?>    
            </ul>
        </nav>
    <?php } ?>
</header>