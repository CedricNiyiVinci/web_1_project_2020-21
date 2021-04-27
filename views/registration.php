
<h2> Inscription </h2>
<br /><br />
<form action="index.php?action=register" method ="POST" >
    <table>
        <tr>
            <td>
                <label for="pseudo"> votre pseudo :</label>
            </td>
            <td>
                <input type="texte"  placeholder=" your pseudo " id="pseudo" name="pseudo" required>
            </td>
        </tr>
        <tr>
            <td>
                <label for="email"> votre Email :</label>
            </td>
            <td>
                <input type="email"  placeholder=" your email " id="email" name="email" required>
            </td>
        </tr>
        <tr>
            <td>
                <label for="email"> confirmation Email :</label>
            </td>
            <td>
                <input type="texte"  placeholder="confirmation Email" id="confirmation_email" name="confirmation_email" required>
            </td>
        </tr>
        <tr>
            <td>
                <label for="password"> ton Mots De Passe :</label>
            </td>
            <td>
                <input type="texte"  placeholder=" your password " id="password" name="password" required>
            </td>
        </tr>
        <tr>
            <td>
                <label for="password"> confirmation du mots de passe :</label>
            </td>
            <td>
                <input type="texte"  placeholder="confirmation_password" id="confirmation_password" name="confirmation_password" required>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input type="submit" name="form_registration" value="Je m'inscris" />
            </td>
        </tr>
    </table>
</form >
<p>Si vous êtes déjà membre veuillez vous connectez.</p>
<span class="MyButton"><a href="index.php?action=login">Connectez-vous</a>

