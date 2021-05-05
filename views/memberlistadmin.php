<p><?php echo $notification ?></p>
     <form action="?action=memberlistadmin" method="post">   
        <table >
            <thead>
            <tr>
                <th>username</th>
                <th>password</th>
                <th>hierarchy_level</th>
                <th>email</th>
                
            </tr>
            </thead>
            <tbody>
            <?php foreach ($tabMembers as $i => $members) { ?>
                <tr>
                    <td><?php echo $members->html_username() ?></td>
                    <td><?php echo $members->html_password() ?></td>
                    <td><?php echo $members->html_hierarchy_level() ?></td>	
                    <td><?php echo $members->html_email() ?></td>	
                    <td><input type="submit" name="idea_member[<?php echo $members->getId_member()?>]" value="idée du membre"/></td>	
                    <td><input type="submit" name="form_delete[<?php echo $members->getId_member()?>]" value="supprimer"/></td>
                    <td>
                        <select name="hierarchy">
                            <option value="">Choose a hierarchy</option>
                            <option name ="hierarchy_membre[<?php echo $members->getId_member()?>]" value="member">membre</option>
                            <option name ="hierarchy_admin[<?php echo $members->getId_member()?>]" value="admin">admin</option>
                        </select>
                    </td>
                    <td><input type="submit" name="hierarchy_select[<?php echo $members->getId_member()?>]" value="select"/></td>     
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
