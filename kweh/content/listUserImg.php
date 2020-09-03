<ul class="card-list">
    <?php

  if (!$loggedIn) return;

  define("GALLERY_DIR", "gallery/");

  require __DIR__ . '/../db.php';;

  $query = <<<JOINEDUPLOADS
  SELECT 
    user.username,
    image.id,
    image.title,
    image.storedName,
    image.uploadedOn
  FROM image
  INNER JOIN user
    ON image.userId=user.id
  WHERE image.userId=:user_id
  ORDER BY image.uploadedOn DESC
  JOINEDUPLOADS;

  $stm = $con->prepare($query);

  $stm->bindParam(':userId', $_SESSION['userId']);

  $stm->execute();

  while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
    $uploadPath = GALLERY_DIR . $row['storedNname'];
    echo <<<EACHPOST
    <li>
      <form action="server.php" method="POST">
        <input name="action" type="hidden" value="deleteImg" />
        <input name="uploadId" type="hidden" value="{$row['id']}" />
        <button class="delete">X</button>
      </form>
      <img src="$uploadPath" />
      <h3>{$row['title']}</h3>
      <div>
        {$row['username']}
        <span>{$row['uploadedOn']}</span>
      </div>
    </li>
    EACHPOST;
  }

  ?>
</ul>