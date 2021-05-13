
<h2>Zone d'Administration</h2>
<p>Bienvenue <strong><?php echo $_SESSION['login']?></strong><?php echo $notification; ?> </p>
<p><a href="index.php?action=logout">Se déconnecter</a></p> <!-- Hyperlink so the user can disconnect himself -->
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
    <?php } ?>
    </tbody>
</table>
<p>______________________________________________________________________________________________________________________________________________</p>
<h2>Mes Commentaires</h2>
<?php foreach ($tabCommentsUser as $i => $comments) { ?>
<?php if($comments->isDeleted()){ ?>
    <?php }else{ ?>
        <strong><?php echo $comments->html_Title_of_idea_commented(). " — "?></strong><?php echo $comments->html_Username_of_idea_commented()?>
        <p><?php echo $comments->html_Text()?></p>
        <i><?php echo "↑ ". $comments->getDate_day_com(). " à ". $comments->getCreated_date()?></i>
        <br><br>
    <?php }?>
<?php }?>
<p>______________________________________________________________________________________________________________________________________________</p>
<h2>Mes Votes</h2>
<table >
    <thead>
    <tr>
        <th>Titre</th>
        <th>Titre</th>
        <th>Texte</th>
        <th>Statue</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($tabVotedIdeas as $i => $ideas) { ?>
        <tr>
        <td><?php echo $ideas->html_Author() ?></td>
        <td><?php echo $ideas->html_Title() ?></td>
        <td><?php echo $ideas->html_Text() ?></td>
        <td><?php echo $ideas->html_Status() ?></td>		
        </tr>
    <?php } ?>
    </tbody>
</table>