<a href="index.php?action=timelineidea"> ← Revenir sur le fil des idées</a> <!--  Hyperlink wich allows the user to go back to the time line with all the ideas.-->
<h3><?php echo $ideaSelected->getTitle(). "     —    ". $ideaSelected->getAuthor() ?></h3> <!-- Print the title and the name of the idea displayed on the screen-->
    <p>
        <?php echo $ideaSelected->getText()?> <!-- Print the text of the idea-->
    </p>
<p style="color:red;">| nbr de votes : <strong><?php echo $ideaSelected->getNumber_of_votes()?></strong>| nbr de commentaire : <strong><?php echo $ideaSelected->getNumber_of_comments()?></strong></p>
<p style="color:violet">__________________________________________________________________________________________________________________________________</p>
<div id="addComment">
        <?php if(isset($notification)){ // $notification will apear on the page only if the variable is well created and well initialized. ?> 
            <strong style="color:greenyellow;"><?php echo $notification ?></strong> <!-- Notification that warns the user if the comment is well posted on the website.-->    
            </br> </br>
        <?php }?>
        <form action="index.php?action=postcomments" method ="POST"> <!-- Form that allows the user to publish a comment below the idea displayed-->
            <textarea id="idea"  placeholder="Voulez-vous commenter cette idée?" name="text_idea" rows="5" cols="125"></textarea></br>
            <input type="submit" name="form_publish_comment" value="Publier">
        </form>
</div>
<p style="color:violet">__________________________________________________________________________________________________________________________________</p>
<?php if(isset($commentNotification)){ // $commentNotification will apear on the page only if the variable is well created and well initialized.?> 
    <p style="color:goldenrod;"><?php echo $commentNotification?></p>  <!-- Notification that warns the user if the comment is well deleted after he clicked on the button "delete" of one of his comment.-->
<?php } ?>
<?php var_dump($ideaSelected->getClosed_date()) ?>
<form action="index.php?action=postcomments" method="POST"> <!-- Form that manage the delete button of each idea writed by the user currently connected -->
    <table>
        <?php foreach ($tabComments as $i => $comments) { // show the different comments releated to idea displayed above with information of each comments (author, the text, submitted date [time and day] or if the comment has been deleted) ?>
            <?php if(empty($ideaSelected->getClosed_date())){ // if the idea displayed above does not have a closing date, it means that its status is submitted, accepted or rejected. Comments should therefore be posted normally?>
                <thead>
                        <tr>
                            <th><?php echo $comments->html_Author() ?></th>
                            <th><?php echo $comments->getDate_day_com(). " à ". $comments->getCreated_date()?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <?php if($comments->isDeleted()){ // if the a comment is marked as deleted, we won't display it but instead we will display a message that says that the comment has been deleted?>
                            <td><i style="color:darkslategrey;"><?php echo "ce commentaire a été supprimé"?></i></td>
                            <?php }else{ // In the other case, if the comment isn't marked as deleted, we show it?>
                            <td><?php echo $comments->html_Text()?></td>
                            <?php }?>
                        </tr>
                        <tr>
                            <td></td>
                            <?php if($comments->getAuthor() == $_SESSION['login']){ // Here I verify if the author of the comment and the user currently connected are the same person. If this is the case I show a delete button for that comment.?>
                            <td><input type="submit" name="form_deleted_comment[<?php echo $tabComments[$i]->getId_Comment()?>]" value="supprimer"></td>	
                            <?php }?>		
                        </tr>
                    </tbody>
            <?php }else{ // if the idea displayed above has a closing date, we have to verify the submitted date of that comment because :?>
                <?php if($comments->getCreated_date () > $ideaSelected->getClosed_date()){ // if a comment is posted after the closed date of the idea showed above, it needs to be displayed differently than the other comments posted before this closed date?>
                <thead style="color:orange;">
                    <tr >
                        <th><?php echo $comments->html_Author() ?></th>
                        <th><?php echo $comments->getDate_day_com(). " à ". $comments->getCreated_date()?></th>
                    </tr>
                </thead>
                <tbody style="color:orange;">
                    <tr>
                    <?php if($comments->isDeleted()){ // if the a comment is marked as deleted, we won't display it but instead we will display a message that says that the comment has been deleted?>
                            <td><i style="color:orangered;"><?php echo "ce commentaire a été supprimé"?></i></td>
                            <?php }else{?>
                            <td><?php echo $comments->html_Text()?></td>
                            <?php }?>
                    </tr>
                    <tr>
                        <?php if($comments->getAuthor() == $_SESSION['login']){?>
                            <td><input type="submit" name="form_deleted_comment[<?php echo $tabComments[$i]->getId_Comment()?>]" value="supprimer"></td>	
                        <?php }?>		
                    </tr>
                </tbody>
                <?php }else{ // in the case where the comment was submitted before that the idea above was closed?>
                    <thead>
                        <tr>
                            <th><?php echo $comments->html_Author() ?></th>
                            <th><?php echo $comments->getDate_day_com(). " à ". $comments->getCreated_date()?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <?php if($comments->isDeleted()){ // if the a comment is marked as deleted, we won't display it but instead we will display a message that says that the comment has been deleted?>
                            <td><i style="color:darkslategrey;"><?php echo "ce commentaire a été supprimé"?></i></td>
                            <?php }else{?>
                            <td><?php echo $comments->html_Text()?></td>
                            <?php }?>
                        </tr>
                        <tr>
                            <?php if($comments->getAuthor() == $_SESSION['login']){ // Here I verify if the author of the comment and the user currently connected are the same person. If this is the case I show a delete button for that comment.?>
                            <td><input type="submit" name="form_deleted_comment[<?php echo $tabComments[$i]->getId_Comment()?>]" value="supprimer"></td>	
                            <?php }?>		
                        </tr>
                    </tbody>
                <?php }?>
            <?php }?>
        <?php } ?>
    </table>
</form>