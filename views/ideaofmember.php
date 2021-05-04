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
        <?php foreach ($tabMemberIdeas as $i => $ideas) { ?>
			<tr>
                <td><?php echo $ideas->html_Author() ?></td>
                <td><?php echo $ideas->html_Title() ?></td>
                <td><?php echo $ideas->html_Text() ?></td>
                <td><?php echo $ideas->html_Status() ?></td>		
			</tr>
            <tr>
                <td><input type="submit" name="vote" value="voter"></td>
                <td><input type="submit" name="comment" value="commenter"></td>
            </tr>
            <tr>
            </tr>
            <tr>
            </tr>  
		<?php } ?>
        </tbody>
    </table>