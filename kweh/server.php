<?php

define('GALLERY_DIR', 'gallery/');

require 'db.php'; //fixed

function redirect($url)
{
  header("Location: $url");
}
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
    addKweh();
    break;
  case 'deleteKweh':
    deleteKweh();
    break;
  case 'uploadImg':
    uploadImg();
    break;
  case 'deleteImg':
    deleteImg();
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

function setStatusMessage($msg = "")
{
  setcookie("statusMsg", $msg, time() + 3);
}
//all my functions

function register(){
  //registers user
  $useremail = $_POST['email']?? false;
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

  $stm->bindParam(":uemail", $useremail);
  $stm->bindParam(":uname", $username);
  $stm->bindParam(":pass", $hashedPassword);

  if ($stm->execute()) {
    loginSuccess([
      'id' => $con->lastInsertId(),
      'username' => $username,
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
  session_start();
  session_destroy();
  redirect("index.php");
}

function addKweh(){
  //adds post, requires img?
  session_start();
  $loggedIn = $_SESSION['userId'] ?? false;
  $content = $_POST['content'] ?? false;

  if (!$loggedIn || !$content) {
    redirect("posts.php");
    setStatusMessage("Missing parameters");
    return;
  }

  global $con;

  $query = <<<QUERY
  INSERT INTO post (content, userId, postedOn) 
  VALUE (:content , :uid, NOW())
  QUERY;

  $stm = $con->prepare($query);

  $stm->bindParam(":content", $content);
  $stm->bindParam(":uid", $_SESSION['userId']);

  if ($stm->execute()) {
    setStatusMessage("Added post");
  } else {
    setStatusMessage("Failed to add post");
  }
  redirect("posts.php");
}

function uploadImg(){
  //uploads img 
  session_start();
  $loggedIn = $_SESSION['userId'] ?? false;
  $title = $_POST['title'] ?? false;
  $newFile = $_FILES['newFile'] ?? false;

  if (!$loggedIn || !$title || !$newFile) {
    redirect("upload.php");
    return;
  }

  $storedName = time() . "_" . rand(1000, 9999);

  global $con;

  $query = <<<QUERY
  INSERT INTO image (userId, filename, storedName, title, uploadedOn) 
  VALUE (:userid, :filename, :storedname, :title, NOW())
  QUERY;

  $stm = $con->prepare($query);

  $stm->bindParam(":userid", $_SESSION['userId']);
  $stm->bindParam(":filename", $newFile['name']);
  $stm->bindParam(":storedname", $storedName);
  $stm->bindParam(":title", $title);

  if (!$stm->execute()) {
    redirect("upload.php");
    setStatusMessage("Upload failed");
    return;
  }

  move_uploaded_file($newFile['tmp_name'], GALLERY_DIR . $storedName);

  redirect("upload.php");
  setStatusMessage("Upload Success");
}

function deleteImg(){
  //delete img
  session_start();
  $userId = $_SESSION['userId'] ?? false;
  $uploadId = $_POST['uploadId'] ?? false;

  if (!$userId || !$uploadId) {
    redirect("upload.php");
    return;
  }

  global $con;

  $query = <<<QUERY
  DELETE FROM image WHERE id = :postId AND userId = :userId;
  QUERY;

  $stm = $con->prepare($query);

  $stm->bindParam(":userId", $_SESSION['userId']);
  $stm->bindParam(":postId", $uploadId);

  if ($stm->execute()) {
    setStatusMessage("Upload deleted");
  } else {
    setStatusMessage("Upload delete failed. Something went wrong.");
  }
  redirect("gallery.php");

}

function deleteKweh(){
//delete post
session_start();
  $userId = $_SESSION['userId'] ?? false;
  $postId = $_POST['postId'] ?? false;

  if (!$userId || !$postId) {
    redirect("posts.php");
    setStatusMessage("Missing parameters");
    return;
  }
  global $con;

  $query = <<<QUERY
  DELETE FROM post WHERE id = :postId AND userId = :userId;
  QUERY;

  $stm = $con->prepare($query);

  $stm->bindParam(":userId", $_SESSION['userId']);
  $stm->bindParam(":postId", $postId);

  if ($stm->execute()) {
    setStatusMessage("Post deleted");
  } else {
    setStatusMessage("Post delete failed. Something went wrong.");
  }
  redirect("posts.php");
}

function comment(){
  //comment on post
}
?>