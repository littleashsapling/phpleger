<html>

<head>
    <title>Kweh!</title>
</head>

<body>
    <h2>Login Page</h2>

    <form action="server.php" method="POST" enctype="multipart/form-data" class="center">
        <label for="username">Enter Username</label>
        <input type="text" name="username" required="required" /> <br />
        <label for="password">Enter password</label>
        <input type="password" name="password" required="required" /> <br />
        <input name="action" value="login" type="hidden" />
        <button onclick="login()">Login</button>
        <a href="index.php">Cancel<br /><br />
    </form>
</body>

</html>