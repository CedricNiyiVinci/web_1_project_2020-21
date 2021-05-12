 <form action="index.php?action=login" method="post">  <!-- The login form, data checking in LoginController.php -->
    <img src="views/images/Default_Avatar.png" alt="Icone Avatar">
    <div id="form_login">
        <b>Email :</b><br>
        <input type="text" placeholder="Email" name="email" required><br>
        <b>Mot de passe :</b><br>
        <input type="password" placeholder="Entrez votre mot de passe" name="password" required><br>
        <br>
        <input type="submit" name="form_login" value="Se connecter">
    </div>
</form>
<p style="color:red"><?php echo $notification?></p>
<p>Si vous n'êtes pas membre veuillez vous enregistrez sur votre base de données.</p>
<a href="index.php?action=registration">Créer un compte</a> <!-- Hyperlink to the register page-->