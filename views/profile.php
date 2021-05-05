<section id="contenu">
	<h1>Zone d'Administration</h1>
	<p>Bienvenue <strong><?php echo $_SESSION['login']?></strong><?php echo $notification; ?> </p>
	<p><a href="index.php?action=logout">Se déconnecter</a></p>


	<h2>Mes idées</h2>
    <table >
        <thead>
        <tr>
            <th>Titre</th>
            <th>Texte</th>
            <th>Statue</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($tabMyIdeas as $i => $ideas) { ?>
			<tr>
			<td><?php echo $ideas->html_Title() ?></td>
            <td><?php echo $ideas->html_Text() ?></td>
            <td><?php echo $ideas->html_Status() ?></td>		
			</tr>
            <tr></tr>
            <tr></tr>
            <tr></tr>
            <tr></tr>
		<?php } ?>
        </tbody>
    </table>
	<h2>Mes Commentaires</h2>
    <h2>Mes Votes</h2>
	
</section>