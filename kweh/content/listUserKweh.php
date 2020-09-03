<ul class="card-list">
    <?php

  if (!$loggedIn) return;

  require __DIR__ . '/../db.php';

  $query = <<<JOINEDPOSTS
  SELECT 
    user.username,
    post.id,
    post.content,
    post.postedOn
  FROM post
  INNER JOIN user
    ON post.userId=user.id
  WHERE post.userId=:userId
  ORDER BY post.postedOn DESC
  JOINEDPOSTS;

  $stm = $con->prepare($query);

  $stm->bindParam(':userId', $_SESSION['userId']);

  $stm->execute();

  while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
    echo <<<EACHPOST
    <li>
      <form action="server.php" method="POST">
        <input name="action" type="hidden" value="deleteKweh" />
        <input name="postId" type="hidden" value="{$row['id']}" />
        <button class="delete">X</button>
      </form>
      <h3>{$row['content']}</h3>
      <div>
        {$row['username']}
        <span>{$row['postedOn']}</span>
      </div>
    </li>
    EACHPOST;
  }

  ?>
</ul>