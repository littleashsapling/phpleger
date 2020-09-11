<!DOCTYPE html>
<html lang="en">

<head>
    <?php require 'components/header.php'; ?>
</head>

<body>
    <?php require "components/navbar.php" ?>
    <div class="shading">
        <h1>Posts</h1>
        <div id="status" class="center"></div>
        <?php
  if ($loggedIn) {
    echo <<<NEWPOST
    <form action="server.php" method="post" class="center">
      <input name="action" value="addKweh" type="hidden" />
      <textarea name="content" cols="60" rows="2"></textarea>
      <br>
      <button>Submit</button>
    </form>
    NEWPOST;
  }
  ?>
        <?php require "content/listUserKweh.php"; ?>
    </div>
    <script>
    if (cookies.statusMsg) {
        document.getElementById('status').innerText = cookies.statusMsg
    }
    </script>
</body>

</html>