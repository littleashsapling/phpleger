<!DOCTYPE html>
<html lang="en">

<body>
  <h1>Upload Image</h1>
  <form action="server.php" method="POST" enctype="multipart/form-data" class="center">
    <input name="action" value="uploadFile" type="hidden" />
    <input name="newFile" type="file" required />
    <input name="title" required />
    <button>Upload</button>
  </form>
  <div class="center">
    <div class="contain">
      <?php require "content/listUserUploads.php" ?> //added as placeholder
    </div>
  </div>
  <script>
    if (cookies.statusMsg) {
      document.getElementById('status').innerText = cookies.statusMsg
    }
  </script>
</body>

</html>