<p><?php echo $notification ?></p>
     <form action="?action=memberlistadmin" method="post">   
        <table >
            <thead>
                <tr>
                    <th>username</th>
                    <th>hierarchy_level</th>
                    <th>email</th>    
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tabMembers as $i => $members) { ?>
                    <tr>
                        <td><?php echo $members->html_username() ?></td>
                        <td><?php echo $members->html_hierarchy_level() ?></td>	
                        <td><?php echo $members->html_email() ?></td>	
                        <td><input type="submit" name="idea_member[<?php echo $members->getId_member()?>]" value="idée du membre"/></td>	
                        <td><input type="submit" name="form_delete[<?php echo $members->getId_member()?>]" value="desactivé"/></td>
                        <td><input type="submit" name="hierarchy_admin[<?php echo $members->getId_member()?>]" value="nommer admin"/></td>     
                    </tr>  
                <?php } ?>
            </tbody>
        </table>
    </from>
