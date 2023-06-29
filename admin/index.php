<?php

require '../includes/init.php';

Auth::requiresLogin();

$conn = require '../includes/db.php';

$articles = Article::getAll($conn);

?>

<!-- HTML header -->
<?php require "../includes/header.php"; ?>

<h1>Administration</h1>

<p><a href="/php/blog/admin/new-article.php">New article</a></p>

<?php if (empty($articles)) : ?>
    <p>No articles found.</p>
<?php else : ?>
    <table>
        <thead>
            <th>Title</th>
        </thead>

        <tbody>
            <?php foreach ($articles as $article) : ?>
                <tr>
                    <td>
                        <a href="/php/blog/admin/article.php?id=<?= $article['id']; ?>">
                            <?= htmlspecialchars($article['title']); ?></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<!-- HTML footer -->
<?php require "../includes/footer.php"; ?>