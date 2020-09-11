<html>

<head>
    <?php require 'components/header.php'; ?>
    <title>Kweh!</title>
</head>

<body>
    <?php require "components/navbar.php" ?>
    <div class="shading">
        <h1>Kweh!</h1>
        <h3>Yours to discover</h3>
        <div class="center">
            <div class="contain">
                <?php require "content/listKweh.php"; ?>
                <?php require "content/listImg.php"; ?>
            </div>
        </div>
        <?php
    if($loggedIn){
        //no div
    }else{
        echo <<<NOTLOGGEDIN
        <div>
        <a href="register.php" class="button"> Click here to register </a>
    </div>
    NOTLOGGEDIN;
    }
    ?>
    </div>

</body>

</html>