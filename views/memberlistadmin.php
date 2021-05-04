<p><?php echo $notification ?></p>
     <form action="?action=memberlistadmin" method="post">   
        <table >
            <thead>
            <tr>
                <th>id_member</th>
                <th>username</th>
                <th>password</th>
                <th>hierarchy_level</th>
                <th>email</th>
                <th><input type="submit" name="idea_member" value="idée du membre"/></th>	
                <th><input type="submit" name="form_delete" value="supprimer"/></th>
                <th><label for="hierarchy-selection">Choose a hierarchy:</label></th>
                    <th><select name="hierarchy" id="hierarchy-selection">
                            <option value="">--Please choose an option--</option>
                            <option value="member">member</option>
                            <option value="admin">admin</option>
                        </select></th>
                    <th><input type="submit" name="hierarchy-select" value="select"/></th>  
            </tr>
            </thead>
            <tbody>
            <?php foreach ($tabMembers as $i => $members) { ?>
                <tr>
                    <td><?php echo $members->html_id_member() ?></td>
                    <td><?php echo $members->html_username() ?></td>
                    <td><?php echo $members->html_password() ?></td>
                    <td><?php echo $members->html_hierarchy_level() ?></td>	
                    <td><?php echo $members->html_email() ?></td>	
                    <td><input type="radio" name="Members[]" value="<?php echo $tabMembers[$i]->html_id_member() ?>"></td>     
                </tr>
                <tr> 
                </tr>
                <tr>
                </tr>
                <tr>
                </tr>  
            <?php } ?>
            </tbody>
        </table>
    </from>
