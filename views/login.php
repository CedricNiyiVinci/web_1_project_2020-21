<form action="index.php?action=login" method="post">    
    <img src="views/images/Default_Avatar.png" alt="Icone Avatar">
    <div id="form_login">
        <label for="pseudo"><b>Pseudo</b></label> </br>
        <input type="text" placeholder="pseudo" name="pseudo" required></br>

        <label for="password"><b>Mot de passe</b></label> </br>
        <input type="password" placeholder="Entrez votre mot de passe" name="password" required></br>
        </br>
        <input type="submit" name="form_login" value="Se connecter">
    </div>
</form>
<p style="color:red"><?php echo $notification?></p>
<p>Si vous n'êtes pas membre veuillez vous enregistrez sur votre base de données.</p>
<a href="index.php?action=registration"><button>Créer un compte</button></a>