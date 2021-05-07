<p><?php echo $notification ?></p>
<form action="?action=idealistadmin" method="post">
    <table >
            <thead>
            <tr>
                <th>Auteur</th>
                <th>Titre</th>
                <th>Texte</th>
                <th>Statut</th>
                
            </tr>
            </thead>
            <tbody>
            <?php foreach ($tabIdeas as $i => $ideas) { ?>
                <tr>
                    <td><?php echo $ideas->html_Author() ?></td>
                    <td><?php echo $ideas->html_Title() ?></td>
                    <td><?php echo $ideas->html_Text() ?></td>
                    <td><?php echo $ideas->html_Status() ?></td>
                    <?php if($ideas->html_Status() == 'submitted' ) { ?>
                        <td><input type="submit" name="accepted[<?php echo $ideas->getId_idea()?>]" value="accept"/></td>	
                        <td><input type="submit" name="refused[<?php echo $ideas->getId_idea()?>]" value="refused"/></td>
                    <?php }elseif($ideas->html_Status() == 'accepted') { ?>	
                        <td><input type="submit" name="refused[<?php echo $ideas->getId_idea()?>]" value="refused"/></td>
                        <td><input type="submit" name="closed[<?php echo $ideas->getId_idea()?>]" value="closed"/></td>
                    <?php }elseif($ideas->html_Status() == 'refused') {?>
                        <td><input type="submit" name="accepted[<?php echo $ideas->getId_idea()?>]" value="accept"/></td>	
                        <td><input type="submit" name="closed[<?php echo $ideas->getId_idea()?>]" value="closed"/></td>
                    <?php }elseif($ideas->html_Status() == 'closed') {?>
                        <td></td>
                    <?php } ?>
                </tr>      
            <?php } ?>
            </tbody>
    </table>
</form>