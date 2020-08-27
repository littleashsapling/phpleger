<html>
    <head>
        <title>Kweh!</title>
    </head>
    <body>
        <h2>Login Page</h2>
        
        <form action="checklogin.php" method="POST">
        <label for="username">Enter Username</label>
            <input type="text" name="username" required="required" /> <br/>
            <label for="password">Enter password</label>
            <input type="password" name="password" required="required" /> <br/>
           <input type="submit" value="Login"/>
           <a href="index.php">Cancel<br/><br/>
        </form>
    </body>
</html>