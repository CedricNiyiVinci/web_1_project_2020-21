<p><?php echo $notification ?></p>
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
                <td><input type="submit" name="accepted" value="accepted"/></td>	
                <td><input type="submit" name="refused" value="refused"/></td>
                <td><input type="submit" name="colsed" value="colsed"/></td>		
			</tr>      
		<?php } ?>
        </tbody>
    </table>