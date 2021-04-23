
<h2> Inscription </h2>
<br/>
<form id="register" method ="POST" action="">
    <table>
        <tr>
            <td>
                <label for="pseudo">Entrez un pseudo :</label>
            </td>
            <td>
                <input type="texte"  placeholder="Pseudo" name="pseudo">
            </td>
        </tr>
        <tr>
            <td>
                <label for="email">Entrez un email valide :</label>
            </td>
            <td>
                <input type="texte"  placeholder="email@adresse.com" name="email">
            </td>
        </tr>
        <tr>
            <td>
                <label for="password">Entrez un mot de passe :</label>
            </td>
            <td>
                <input type="password"  placeholder="Entrez un mot de passe" name="password">
            </td>
        </tr>
        <tr>
            <td>
                <input type="submit"  value="Je m'inscrit" />
            </td>
        </tr>
    </table>

        <a type="submit" ><a href="index.php?action=registration">Register</a></a>
        <a type="submit" ><a href="index.php?action=login">login</a></a>
</form>

<p>Si vous êtes déjà membre veuillez vous connectez.</p>
<a href="index.php?action=login"><button>Connectez-vous</button></a>

