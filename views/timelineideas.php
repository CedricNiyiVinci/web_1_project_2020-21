<h1>Les idées des étudiants</h1>
    <div id="addIdea">  <!-- Form that allows the user to publish an idea-->
        <h2 style="color:orange">Nouvelle idée</h2>
        <form action="index.php?action=timelineidea" method ="POST">
        <table>
            <tr>
                <td>
                    <label for="title_idea"> titre :</label>
                </td>
                <td>
                    <input type="text"  placeholder="Titre de votre idée" id="title_idea" name="title_idea" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="idea"> ton idée:</label>
                </td>
                <td>
                    <textarea id="idea"  placeholder="Une nouvelle idée à partager?" name="text_idea" rows="5" cols="33"></textarea>
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
    </div>
    <p>__________________________</p>
    <p style="color:lightcoral"><?php echo $notificationIdea ?></p> <!-- Notification that warns the user if the idea is well posted on the website-->
    <div>
        <form action="index.php?action=timelineidea" method="POST"> <!-- Form that allows the user to choose a sorting type to show him the different ideas of the website according to this type of sorting-->
            <h5>Choisir un type de tri (par défaut: <i>par popularité</i>):</h5>
            <p>Choisissez parmi les propositions suivantes</p>
            <input type="radio" name="choice" value="popularity" <?php if($sortType == 'popularity') {echo 'checked'; ;} ?>>Par popularité
            <input type="radio" name="choice" value="chronological" <?php if($sortType == 'chronological') {echo 'checked'; ;} ?>>Par ordre de chronologique (de l'idée la plus récente à  la plus ancienne)
            <br><br>
            <input type="submit" name="form_sort_type" value="Afficher les idées">
            <p><strong>→ET<strong></p>
        <?php if($sortType == "popularity") { // by default, sorting is by popularity (but the user can also choose that sorting type). So he will see two selection forms to choose the type of filter he wants?> 
            <h5>Filtrer par nombre d'idées à afficher, en fonction du tri par popularité :</h5> <!-- With this form the user can choose if he wants to see the 3 or 10 most popular ideas (or all the ideas sorted by popularity)-->
                <p>Choisissez parmi les propositions suivantes</p>
                <select name="popularity" id="popularity-select">
                    <option value="" disabled selected>--Choisissez une option s.v.p.--</option>
                    <option value="3">3</option>
                    <option value="10">10</option>
                    <option value="ALL">ALL</option>
                </select>
                <input type="submit" name="form_popularity" value="Afficher les idées">
            <p><strong>⇒OU<strong></p>
            <h5>Filtrer par statut</h5> <!-- With this form, the user can choose between 4 different types of status that an idea can have, and with this filter, the website will show the ideas that have only this type of status (chosen) [always sorted by popularity]. -->
            <p>Choisissez parmi les propositions suivantes</p>
                <select name="status" id="status-select">
                    <option value="" disabled selected >--Choisissez une option s.v.p.--</option>
                    <option value="submitted">submitted</option>
                    <option value="accepted">accepted</option>
                    <option value="refused">refused</option>
                    <option value="closed">closed</option>
                </select>
                <input type="submit" name="form_status" value="Afficher les idées">
        </form>
        <?php }else{ //In the case where an user chosed to see the ideas sortered by chronological order. He will see two selection forms to choose the type of filter he wants.?> 
            <h5>Filtrer par nombre d'idées à afficher, en fonction du tri par ordre chronologique :</h5> <!-- With this form the user can choose if he wants to see the 3 or 10 most recent ideas (or all the ideas sorted by chronolical order)-->
                <p>Choisissez parmi les propositions suivantes</p>
                <select name="chronological" id="chronological-select">
                    <option value="" disabled selected>--Choisissez une option s.v.p.--</option>
                    <option value="3">3</option>
                    <option value="10">10</option>
                    <option value="ALL">ALL</option>
                </select>
                <input type="submit" name="form_chronological" value="Afficher les idées">
            <h5>Filtrer par statut</h5> <!-- With this form, the user can choose between 4 different types of status that an idea can have, and with this filter, the website will show the ideas that have only this type of status (chosen) [sorted by chronlogical order]. -->
            <p><strong>⇒OU<strong></p>
            <p>Choisissez parmi les propositions suivantes</p>
                <select name="status" id="status-select">
                    <option value="" disabled selected >--Choisissez une option s.v.p.--</option>
                    <option value="submitted">submitted</option>
                    <option value="accepted">accepted</option>
                    <option value="refused">refused</option>
                    <option value="closed">closed</option>
                </select>
                <input type="submit" name="form_status" value="Afficher les idées">
        </form>
        <?php } ?>
        <p>__________________________</p>
    </div>
        <?php if(isset($alert)){ // Notification that warns the user for wich idea he voted after he clicked on the button "vote" of an idea.?> 
            <strong style="color:greenyellow;"><?php echo $alert ?></strong>
        <?php }?>
        <?php if(isset($alertVote)){ // Notification that warns the user if he has already voted for the idea he wanted to vote for.?>
            <strong style="color:orangered;"><?php echo $alertVote ?></strong>
        <?php }?>
        <h2><?php echo $titleToDisplay ?></h2> <!-- Title that gives more informations about how the ideas showed below are sorted and filtred -->
    <form action="index.php?action=timelineidea" method="POST"> <!-- Form that manage the vote and comment button of each idea -->
        <table>
            <thead>
            <tr>
                <th>Auteur</th>
                <th>Titre</th>
                <th>Texte</th>
                <th>Statut</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($tabIdeas as $i => $ideas) { // show the different ideas with information of each ideas (author, the text, how many votes, how many comments, status)?>
                <tr>
                    <td><?php echo $ideas->html_Author() ?></td>
                    <td><?php echo $ideas->html_Title() ?></td>
                    <td><?php echo $ideas->html_Text() ?></td>
                    <td><?php echo $ideas->html_Status() ?></td>		
                </tr>
                <tr style="color:red;">
                    <td colspan = "1"></td>
                    <td colspan = "1"><?php if($ideas->getStatus()=="closed"){}else{?><input type="submit" name="form_vote[<?php echo $tabIdeas[$i]->getId_idea()?>]" value="voter"><?php }?>| nombre de votes : <strong><?php echo $tabIdeas[$i]->getNumber_of_votes()?></strong></td>
                    <!-- Vote button that's displayed when an idea isn't closed. "form_vote" is a table in POST. And if the user clicks on the "vote" button of an idea that "form table"is filled with the id_idea of which idea the user wants to vote for.-->
                    <td colspan = "1"><input type="submit" name="form_comment[<?php echo $tabIdeas[$i]->getId_idea()?>]" value="commenter"> | nombre de commentaire : <strong><?php echo $tabIdeas[$i]->getNumber_of_comments()?></strong></td>
                    <!-- Comment button that redirect the user to the comment page of an idea (a page where he can see the idea, comment on that idea and see the different comment posted for that idea).-->
                    <!-- "form_comment" is a table in POST. And if the user clicks on the "comment" button of an idea that "form table" is filled with the id_idea of which idea the user wants to see the comment page. -->
                    <td></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </form>
