    <form action ="index.php?action=ideaofmember" methode = "post">
        <table>
                <thead>
                <tr>
                    <th>Titre</th>
                    <th>Texte</th>
                    <th>Statue</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($tabMemberIdeas as $i => $ideas) { ?>
                    <tr>
                        <td><?php echo $ideas->html_Title() ?></td>
                        <td><?php echo $ideas->html_Text() ?></td>
                        <td><?php echo $ideas->html_Status() ?></td>		
                    </tr>
                    <tr>
                        <td><input type="submit" name="vote" value="voter"></td>
                        <td><input type="submit" name="comment" value="commenter"></td>
                    </tr>  
                <?php } ?>
                </tbody>
        </table>
        <a href="index.php?action=memberlistadmin">revenir a la liste</a>
    </from>