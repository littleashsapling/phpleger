<html>

<head>
    <title>Kweh!</title>
</head>

<body>
    <h2>Registration Page</h2>
    <form action="register.php" method="POST">
        <label for="username">Enter Username</label>
        <input type="text" name="username" required="required" /> <br />
        <label for="email">Enter Email </label>
        <input type="text" name="email" required="required" /> <br />
        <label for="password">Enter password</label>
        <input type="password" name="password" required="required" /> <br />
        <input type="submit" value="Register" />
        <a href="index.php">Cancel<br /><br />
    </form>
</body>

</html>
<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = mysql_real_escape_string($_POST['useremail']);
	$username = mysql_real_escape_string($_POST['username']);
	$password = mysql_real_escape_string($_POST['userpass']);
    $bool = true;

	mysql_connect("localhost", "root","") or die(mysql_error()); //Connect to server
	mysql_select_db("khew") or die("Cannot connect to database"); //Connect to database
	$query = mysql_query("Select * from user"); //Query the user table
	while($row = mysql_fetch_array($query)) //display all rows from query
	{
		$table_users = $row['useremail']; // the first email row is passed on to $table_users, and so on until the query is finished
		if($email == $table_user) // checks if there are any matching fields
		{
			$bool = false; // sets bool to false
			Print '<script>alert("Username has been taken!");</script>'; //Prompts the user
			Print '<script>window.location.assign("register.php");</script>'; // redirects to register.php
		}
	}

	if($bool) // checks if bool is true
	{
		mysql_query("INSERT INTO user (useremail, username, userpass) VALUES ('$email','$username','$password')"); //Inserts the value to table users
		Print '<script>alert("Successfully Registered!");</script>'; // Prompts the user
		Print '<script>window.location.assign("register.php");</script>'; // redirects to register.php
	}
}
?>