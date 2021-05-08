<!DOCTYPE HTML>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>studentvote</title>
        <link rel="stylesheet" type="text/css" href="<?php echo VIEWS_PATH ?>css/Base.css" media="all">
		</head>
	<body>
	<header>
    <h1>
        StudentsVote
    </h1>
    <p class="sous-titre">
        <strong>HE Vinci Paul Lambin</strong> : bloc 1 en informatique
    </p>
    <nav>
        <ul>
            <?php if (!empty($_SESSION['authentifie'])) { ?>
                <?php if($_SESSION['hierarchy_level'] == 'member' ) { ?>
                    <li><a href="index.php?action=profile"> votre profil</a></li>    
                    <li><a href="index.php?action=timelineidea"> la timelineidea </a></li>
                <?php }elseif($_SESSION['hierarchy_level'] == 'admin' ) { ?>
                    <li><a href="index.php?action=profile"> votre profil</a></li>    
                    <li><a href="index.php?action=timelineidea"> la timelineidea </a></li>
                    <li><a href="index.php?action=idealistadmin"> la idealistadmin </a></li>
                    <li><a href="index.php?action=memberlistadmin"> votre liste de membre </a></li> 
                <?php } ?>    
            <?php } ?>
        </ul>
    </nav>
</header>