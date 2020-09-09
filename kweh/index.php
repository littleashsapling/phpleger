<html>

<head>
    <?php require 'components/header.php'; ?>
</head>

<body>
    <?php require "components/navbar.php" ?>
    <title>Kweh!</title>
    <div class="center">
        <div class="contain">
            <?php require "content/listKweh.php"; ?>
            <?php require "content/listImg.php"; ?>
        </div>
    </div>
    <a href="login.php"> Click here to login <br />
        <a href="register.php"> Click here to register <br />
</body>
<footer>
    <?php require "components/footer.php"?>
</footer>

</html>