<p><?php echo $notification ?></p>


<form id="register" method="POST">
    Entrez un pseudo <br> <input type="texte"placeholder="Pseudo" required><br>
    Entrez un email valide <br> <input type="email"placeholder="email@adresse.com" required><br>
    Entrez un mot de passe <br> <input type="password" placeholder="Enter Password" required><br>
    </br>
    <button type="submit">Enregistrez-vous</button>
</form>


<p>Si vous êtes déjà membre veuillez vous connectez.</p>
<a href="index.php?action=login"><button>Connectez-vous</button></a>