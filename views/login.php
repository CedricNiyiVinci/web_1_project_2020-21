<p><?php echo $notification ?></p>
<form action="action_page.php" method="post">    
    <img src="views/images/Default_Avatar.png" alt="Avatar">
    <div class="container">
        <label for="uname"><b>Username</b></label>
        <input type="text" placeholder="Enter Username" name="uname" required></br>

        <label for="psw"><b>Password</b></label>
        <input type="password" placeholder="Enter Password" name="psw" required></br>

        <button type="submit">Login</button>
    </div>
</form>