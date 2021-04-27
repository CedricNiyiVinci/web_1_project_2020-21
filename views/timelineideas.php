<h1>Les idées des étudiants</h1>
<form action='index.php?action=timelineidea' methode='POST'>
    <textarea placeholder="Entrez une nouvelle idée!"></textarea></br>
    <input type="submit" name="form_publish_idea" value="Publier">
</form>
<!-- <table >
        <thead>
        <tr>
            <th>Auteur</th>
            <th>Titre</th>
            <th>Texte</th>
            <th>Statue</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($tabIdeas as $i => $ideas) { ?>
			<tr>
			<td><span class="html"><?php echo $ideas->html_titre() ?></span></td>
			<td><?php echo $ideas->html_auteur() ?></td>		
			</tr>
		<?php } ?>
        </tbody>
    </table> -->
<p><?php echo $notification ?></p>