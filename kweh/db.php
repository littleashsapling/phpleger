<?php

$dbHost = "localhost";
$dbName = "kweh";
$dbUser = "root";
 
$con = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser);
$con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
?>