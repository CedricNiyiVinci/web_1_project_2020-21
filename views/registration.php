
<h2> Inscription </h2> <!-- Register form, data checking in RegistrationController.php-->
<form action="index.php?action=registration" method ="POST" >
    <table>
        <tr>
            <td>
                <label for="username"> Pseudo:</label>
            </td>
            <td>
                <input type="text"  placeholder="Votre pseudo" id="username" name="username" required>
            </td>
        </tr>
        <tr>
            <td>
                <label for="e_mail"> Email:</label>
            </td>
            <td>
                <input type="email"  placeholder="Votre email" id="e_mail" name="e_mail" required>
            </td>
        </tr>
        <tr>
            <td>
                <label for="e_mail">Confirmation Email:</label>
            </td>
            <td>
                <input type="email"  placeholder="Confirmez votre email" id="confirmation_email" name="confirmation_email" required>
            </td>
        </tr>
        <tr>
            <td>
                <label for="password">Mot de passe:</label>
            </td>
            <td>
                <input type="password"  placeholder="Votre mot de passe" id="password" name="password" required>
            </td>
        </tr>
        <tr>
            <td>
                <label for="password">Confirmation Mot de passe:</label>
            </td>
            <td>
                <input type="password"  placeholder="Confirmez votre mdp" id="confirmation_password" name="confirmation_password" required>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input type="submit" name="form_register" value="Je m'inscris"/>
            </td>
        </tr>
    </table>
</form >
<p style="color:green"><?php echo $notification ?></p>
<p>Si vous êtes déjà membre veuillez vous connectez.</p>
<a href="index.php?action=login">Connectez-vous</a> <!-- Hyperlink to the log in page-->

