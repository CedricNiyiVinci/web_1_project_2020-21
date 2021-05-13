<p><?php echo $notification ?></p> <!-- Notification that tells to the user the function of the current this page-->
<p style="color:chocolate;"><?php echo $notificationStatus ?></p> <!-- Notification that tells to the admin for which idea he changed the status (and in which status) -->
<form action="?action=idealistadmin" method="post"> <!-- Form that manage the different buttons that allows the admin to accept, refuse or close a specific idea-->
    <table >
            <thead>
            <tr>
                <th>Auteur</th>
                <th>Titre</th>
                <th>Texte</th>
                <th colspan = "3">Statut</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($tabIdeas as $i => $ideas) { // show the different ideas with information of each ideas (author, title, the text, status) ?>
                <tr>
                    <td><?php echo $ideas->html_Author() ?></td>
                    <td><?php echo $ideas->html_Title() ?></td>
                    <td><?php echo $ideas->html_Text() ?></td>
                    <td><?php echo $ideas->html_Status() ?></td>
                    <?php if($ideas->html_Status() == 'submitted' ) { // if the status of $ideas is in submitted we can change the status but we have only 2 options : accepted or refused?>
                        <td><input type="submit" name="accepted[<?php echo $ideas->getId_idea()?>]" value="accept"/></td>	
                        <td><input type="submit" name="refused[<?php echo $ideas->getId_idea()?>]" value="refused"/></td>
                    <?php }elseif($ideas->html_Status() == 'accepted') { //if the status of $ideas is in accepted we can change the status but we have only 2 options : refused or closed?>	
                        <td><input type="submit" name="refused[<?php echo $ideas->getId_idea()?>]" value="refused"/></td>
                        <td><input type="submit" name="closed[<?php echo $ideas->getId_idea()?>]" value="closed"/></td>
                    <?php }elseif($ideas->html_Status() == 'refused') { //if the status of $ideas is in refused we can change the status but we have only 2 options : accepted or closed?>
                        <td><input type="submit" name="accepted[<?php echo $ideas->getId_idea()?>]" value="accept"/></td>	
                        <td><input type="submit" name="closed[<?php echo $ideas->getId_idea()?>]" value="closed"/></td>
                    <?php }elseif($ideas->html_Status() == 'closed') { // Finally when an idea is closed we can't change the status anymore?>
                        <td></td>	
                        <td></td>
                    <?php } ?>
                </tr>      
            <?php } ?>
            </tbody>
    </table>
</form>