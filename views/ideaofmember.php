<a href="index.php?action=memberlistadmin"> ← Revenir a la liste</a> <!--  Hyperlink wich allows the admin to go back to the page with the list of all the members of the site.-->
<h2><?php echo $notificationSpecificMember ?></h2> <!-- Notification that says to the admin who wrote the ideas below-->
<form action ="index.php?action=ideaofmember" methode = "post">
    <table>
            <thead>
            <tr>
                <th>Titre</th>
                <th>Texte</th>
                <th>Statut</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($tabMemberIdeas as $i => $ideas) { // show the different ideas with information of each ideas (itle, the text, status) [of a specific member]?>
                <tr>
                    <td><?php echo $ideas->html_Title() ?></td>
                    <td><?php echo $ideas->html_Text() ?></td>
                    <td><?php echo $ideas->html_Status() ?></td>		
                </tr>  
            <?php } ?>
            </tbody>
    </table>
</from>