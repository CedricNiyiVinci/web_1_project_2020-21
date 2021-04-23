<p><?php echo $notification ?></p>
<form action="action_page.php" method="post">    
    <img src="views/images/Default_Avatar.png" alt="Avatar">
    <div id="form_log_in">
        <label for="pseudo"><b>Pseudo</b></label> </br>
        <input type="text" placeholder="Pseudo" name="pseudo" required></br>

        <label for="password"><b>Mot de passe</b></label> </br>
        <input type="password" placeholder="Entrez votre mot de passe" name="password" required></br>

        <button type="submit">Login</button>
    </div>
</form>
<p>Si vous n'êtes pas membre veuillez vous enregistrez sur votre base de données.</p>
<a href="index.php?action=registration"><button>Créer un compte</button></a>