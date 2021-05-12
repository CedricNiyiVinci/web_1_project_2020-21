<a href="index.php?action=timelineidea"> &#8592 Revenir sur le fil des idées</a>
<h3><?php echo $ideaSelected->getTitle(). "     &#9473     ". $ideaSelected->getAuthor() ?></h3>
    <p>
        <?php echo $ideaSelected->getText()?>
    </p>
<p style="color:red;">| nbr de votes : <strong><?php echo $ideaSelected->getNumber_of_votes()?></strong>| nbr de commentaire : <strong><?php echo $ideaSelected->getNumber_of_comments()?></strong></p>
<p style="color:violet">__________________________________________________________________________________________________________________________________</p>
<div id="addComment">
        <?php if(isset($notification)){?>     
            <strong style="color:greenyellow;"><?php echo $notification ?></strong>
            </br> </br>
        <?php }?>
        <form action="index.php?action=postcomments" method ="POST">
            <textarea id="idea"  placeholder="Voulez-vous commenter cette idée?" name="text_idea" rows="5" cols="125"></textarea></br>
            <input type="submit" name="form_publish_comment" value="Publier">
        </form>
</div>
<p style="color:violet">__________________________________________________________________________________________________________________________________</p>
<?php if(isset($notificationCommentaire)){ ?>
    <p style="color:goldenrod;"><?php echo $notificationCommentaire?></p>
<?php } ?>
<?php var_dump($ideaSelected->getClosed_date()) ?>
<form action="index.php?action=postcomments" method="POST">
    <table>
        <?php foreach ($tabComments as $i => $comments) { ?>
            <?php if(empty($ideaSelected->getClosed_date())){?>
                <thead>
                        <tr>
                            <th><?php echo $comments->html_Author() ?></th>
                            <th><?php echo $comments->getDate_day_com(). " à ". $comments->getDate_time_com()?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <?php if($comments->isDeleted()){ ?>
                            <td><i style="color:darkslategrey;"><?php echo "ce commentaire a été supprimé"?></i></td>
                            <?php }else{?>
                            <td><?php echo $comments->html_Text()?></td>
                            <?php }?>
                        </tr>
                        <tr>
                            <td></td>
                            <?php if($comments->getAuthor() == $_SESSION['login']){?>
                            <td><input type="submit" name="form_deleted_comment[<?php echo $tabComments[$i]->getId_Comment()?>]" value="supprimer"></td>	
                            <?php }?>		
                        </tr>
                    </tbody>
            <?php }else{?>
                <?php if($comments->getDate_com() > $ideaSelected->getClosed_date()){?>
                <thead style="color:orange;">
                    <tr >
                        <th><?php echo $comments->html_Author() ?></th>
                        <th><?php echo $comments->getDate_day_com(). " à ". $comments->getDate_time_com()?></th>
                    </tr>
                </thead>
                <tbody style="color:orange;">
                    <tr>
                    <?php if($comments->isDeleted()){ ?>
                            <td><i style="color:orangered;"><?php echo "ce commentaire a été supprimé"?></i></td>
                            <?php }else{?>
                            <td><?php echo $comments->html_Text()?></td>
                            <?php }?>
                    </tr>
                    <tr>
                        <td></td>
                        <?php if($comments->getAuthor() == $_SESSION['login']){?>
                            <td><input type="submit" name="form_deleted_comment[<?php echo $tabComments[$i]->getId_Comment()?>]" value="supprimer"></td>	
                        <?php }?>		
                    </tr>
                </tbody>
                <?php }else{?>
                    <thead>
                        <tr>
                            <th><?php echo $comments->html_Author() ?></th>
                            <th><?php echo $comments->getDate_day_com(). " à ". $comments->getDate_time_com()?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <?php if($comments->isDeleted()){ ?>
                            <td><i style="color:darkslategrey;"><?php echo "ce commentaire a été supprimé"?></i></td>
                            <?php }else{?>
                            <td><?php echo $comments->html_Text()?></td>
                            <?php }?>
                        </tr>
                        <tr>
                            <td></td>
                            <?php if($comments->getAuthor() == $_SESSION['login']){?>
                            <td><input type="submit" name="form_deleted_comment[<?php echo $tabComments[$i]->getId_Comment()?>]" value="supprimer"></td>	
                            <?php }?>		
                        </tr>
                    </tbody>
                <?php }?>
            <?php }?>
        <?php } ?>
    </table>
</form>