<ul class="card-list">
    <?php

  define("GALLERY_DIR", "gallery/");

  require __DIR__ . '/../db.php';

  $query = <<<JOINEDUPLOADS
  SELECT 
    user.username,
    image.title,
    image.storedName,
    image.uploadedOn
  FROM image
  INNER JOIN user
    ON image.userId=user.id
  ORDER BY image.uploadedOn DESC
  JOINEDUPLOADS;

  $stm = $con->prepare($query);

  $stm->execute();

  while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
    $uploadPath = GALLERY_DIR . $row['storedName'];
    echo <<<EACHPOST
    <li>
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