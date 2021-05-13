<p><?php echo $notification ?></p>  <!-- Notification that tells to the user the function of the current this page-->
<p style="color:chocolate;"><?php echo $notificationAction ?></p>  <!-- Notification that tells to the admin which member he just deactivated or which member he just upgraded -->
     <form action="?action=memberlistadmin" method="post">   
        <table >
            <thead>
                <tr>
                    <th>username</th>
                    <th>hierarchy_level</th>
                    <th>email</th>    
                    <th>regarder les idees</th>
                    <th>descativer membre</th>
                    <th>promouvoir</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tabMembers as $i => $members) { // show the different members with information of each member (username, hierarchy level & email) ?>
                    <tr>
                        <td><?php echo $members->html_username() ?></td>
                        <td><?php echo $members->html_hierarchy_level() ?></td>	
                        <td><?php echo $members->html_email() ?></td>	
                        <td><input type="submit" name="idea_member[<?php echo $members->getId_member()?>]" value="idées du membre"/></td> <!-- Redirect the user to a page with all the ideas of a specific member-->
                        <td><input type="submit" name="form_disable[<?php echo $members->getId_member()?>]" value="desactivé"/></td> <!-- Button that allows an admin to disable a specific user-->
                        <td><input type="submit" name="hierarchy_admin[<?php echo $members->getId_member()?>]" value="nommer admin"/></td>  <!-- Button that allows an admin to upgrade to admin grade a specific user-->
                    </tr>  
                <?php } ?>
            </tbody>
        </table>
    </form>
