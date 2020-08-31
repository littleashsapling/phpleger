<?php

define('GALLERY_DIR', 'gallery/'); //why is it angry, precious?

require 'db.php'; //fixed

//action dispatcher - built

$action = $_POST['action'] ?? false;

switch ($action) {
  case 'register':
    register();
    break;
  case 'login':
    login();
    break;
  case 'logout':
    logout();
    break;
  case 'addKweh':
    addPost();
    break;
  case 'deleteKweh':
    deletePost();
    break;
  case 'uploadImg':
    uploadFile();
    break;
  case 'deleteImg':
    deleteUpload();
    break;
    case 'comment':
      comment();
    break;
  default:
    redirect("404.php");
}

//helpers
function authError($msg = "Bad Credentials, Please try again!")
{
  setcookie("authError", $msg, time() + 3);
}


//all my functions
function register(){
//registers user
$useremail = $_POST['useremail']?? false;
  $username = $_POST['username'] ?? false;
  $password = $_POST['password'] ?? false;


  if (!$useremail || !$username || !$password) {
    echo "Need email, username and password";
    return;
}

global $con;

  $query = <<<QUERY
  INSERT INTO user (email, username, password) VALUE (:uemail, :uname , :pass)
  QUERY;

  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

  $stm = $con->prepare($query);

  $stm->bindParam(:"uemail", $useremail);
  $stm->bindParam(":uname", $username);
  $stm->bindParam(":pword", $hashedPassword);

  if ($stm->execute()) {
    loginSuccess([
      'id' => $con->lastInsertId(),
      'username' => $username,
      'admin' => false
    ]);
  } else {
    redirect("index.php");
    authError("Username taken");
  }
}


function login(){
//logs in user
  $username = $_POST['username'] ?? false;
  $password = $_POST['password'] ?? false;

  if (!$username || !$password) {
    echo "Need username and password";
    return;
  }

  global $con;

  $query = <<<QUERY
  SELECT id, username, password 
  FROM user 
  WHERE username = :uname
  QUERY;

  $stm = $con->prepare($query);

  $stm->bindParam(":uname", $username);

  if ($stm->execute()) {
    if ($user = $stm->fetch(PDO::FETCH_ASSOC)) {
      // Found a user
      if (password_verify($password, $user['password'])) {
        // Login successful
        loginSuccess($user);
      } else {
        redirect("index.php");
        authError();
      }
    } else {
      redirect("index.php");
      authError();
    }
  } else {
    // Something went wrong with the DB
    redirect("index.php");
    authError("Internal DB Error");
  }

}

function loginSuccess($user){
//login success
  redirect("posts.php");

  // session stuff
  session_start();
  $_SESSION['userId'] = $user['id'];
  $_SESSION['username'] = $user['username'];
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