<?php
$db_host = "localhost";
$db_user = "simon";
$db_pass = "Nal149--";
$db_name = "cms";

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (mysqli_connect_error()) {
    echo mysqli_connect_error();
    exit;
}

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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Blog</title>
</head>

<body>
    <header>
        <h1>My Blog</h1>
    </header>

    <main>
        <?php if (empty($articals)) : ?>
            <p>No articles found.</p>
        <?php else : ?>
            <ul>
                <?php foreach ($articals as $article) : ?>
                    <li>
                        <article>
                            <h2><?= $article['title']; ?></h2>
                            <p><?= $article['content']; ?></p>
                            <p><?= $article['published_at']; ?></p>
                        </article>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </main>
</body>

</html>