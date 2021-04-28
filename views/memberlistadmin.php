<p><?php echo $notification ?></p>
     <form>   
        <table >
            <thead>
            <tr>
                <th>id_member</th>
                <th>username</th>
                <th>password</th>
                <th>hierarchy_level</th>
                <th>email</th>
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
                    <td><input type="submit" name="idea_member" value="idée du membre"/></td>	
                    <td><input type="submit" name="form_delete" value="supprimer"/></td>
                    <td><input type="submit" name="hierarchy_level" value="hierarchy"/></td>
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
