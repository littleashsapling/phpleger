<?php

define('GALLERY_DIR', 'gallery/'); //why is it angry, precious?

require 'db.php'; //says to use include instead?

//action dispatcher - if you build it they will come

//helpers
function authError($msg = "Bad Credentials, Please try again!")
{
  setcookie("authError", $msg, time() + 3);
}


//all my functions
function register(){
//registers user
}
function login(){
//logs in user
}

function loginSuccess(){
//login success
}

function logout(){
//logs user out
}

function addKweh(){
//adds post, requires img
}

function uploadImg(){
//uploads img
}

function deleteImg(){
//delete img
}

function deleteKweh(){
//delete post
}
function comment(){
//comment on post
}

function helloUser(){
//greets username in navbar-would be cool
echo str_replace('world', $username, 'Hello world!');
}
?>