<!DOCTYPE html>
<html lang="en">

<head>
    <?php require 'components/header.php'; ?>
</head>

<body>
    <?php require "components/navbar.php" ?>
    <h1>Upload Image</h1>
    <form action="server.php" method="POST" enctype="multipart/form-data" class="center">
        <input name="action" value="uploadImg" type="hidden" />
        <input name="newFile" type="file" required />
        <input name="title" required />
        <button>Upload</button>
    </form>
    <div class="center">
        <div class="contain">
            <?php require "content/listUserImg.php" ?>
        </div>
    </div>
    <script>
    if (cookies.statusMsg) {
        document.getElementById('status').innerText = cookies.statusMsg
    }
    </script>
</body>

</html>