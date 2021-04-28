<h1>Les idées des étudiants</h1>
<h2>nouvelle idée</h2>
	<form action="index.php?action=timelineidea" method ="POST">
	<table>
		<tr>
            <td>
                <label for="title_idea"> titre :</label>
            </td>
            <td>
                <input type="texte"  placeholder=" your title" id="title_idea" name="title_idea" required>
            </td>
        </tr>
        <tr>
            <td>
                <label for="idea"> ton idée:</label>
            </td>
            <td>
			    <textarea id="idea" name="idea" rows="5" cols="33"></textarea>
            </td>
        </tr>
		<tr>
            <td></td>
            <td>
                <input type="submit" name="form_publish_idea" value="Publier">
            </td>
        </tr>
	</table>
	</form>
    <table >
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
			<td><?php echo $ideas->html_Author() ?></td>
			<td><?php echo $ideas->html_Title() ?></td>
            <td><?php echo $ideas->html_Text() ?></td>
            <td><?php echo $ideas->html_Status() ?></td>		
			</tr>
            <tr>
            </tr>
            <tr>
            </tr>
            <tr>
            </tr>  
		<?php } ?>
        </tbody>
    </table>
<p><?php echo $notification ?></p>