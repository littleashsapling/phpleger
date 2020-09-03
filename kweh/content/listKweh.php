<ul class="card-list">
    <?php


  require 'db.php';

  $query = <<<JOINEDPOSTS
  SELECT 
    user.username,
    post.content,
    post.postedOn
  FROM post
  INNER JOIN user
    ON post.userid=user.id
  ORDER BY post.postedOn DESC
  JOINEDPOSTS;

  $stm = $con->prepare($query);

  $stm->execute();

  while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
    echo <<<EACHPOST
    <li>
      <h3>{$row['content']}</h3>
      <div>
        {$row['username']}
        <span>{$row['posted_on']}</span>
      </div>
    </li>
    EACHPOST;
  }

  ?>
</ul>