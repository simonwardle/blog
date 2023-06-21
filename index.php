<?php

require 'includes/database.php';
require 'includes/auth.php';

session_start();

$conn = getDB();

$sql = "SELECT * 
        FROM article
        ORDER BY published_at;";

$results = mysqli_query($conn, $sql);

if ($results === false) {
    echo mysqli_error($conn);
} else {
    $articals = mysqli_fetch_all($results, MYSQLI_ASSOC);
}

?>
<!-- HTML header -->
<?php require "includes/header.php"; ?>


<?php if (isLoggedIn()) : ?>

    <p>You are logged in. <a href="logout.php">Log out</a></p>
    <p><a href="new-article.php">New article</a></p>
<?php else : ?>

    <p>You are not logged in. <a href="login.php">Log in</a></p>
<?php endif; ?>


<?php if (empty($articals)) : ?>
    <p>No articles found.</p>
<?php else : ?>

    <ul>
        <?php foreach ($articals as $article) : ?>
            <li>
                <article>
                    <h2><a href="article.php?id=<?= $article['id']; ?>"><?= htmlspecialchars($article['title']); ?></a></h2>
                    <p><?= htmlspecialchars($article['content']); ?></p>
                </article>
            </li>
        <?php endforeach; ?>
    </ul>

<?php endif; ?>

<!-- HTML footer -->
<?php require "includes/footer.php"; ?>