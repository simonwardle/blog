<?php
//This page shows one individual article and gives links to the edit and delete pages
require '../includes/init.php';

Auth::requiresLogin();

$conn = require '../includes/db.php';

//This is the id passed in, is it actually set to something?
if (isset($_GET['id'])) {
    $article = Article::getById($conn, $_GET['id']);
} else {
    $article = null;
}
?>
<!-- HTML header -->
<?php require "../includes/header.php"; ?>

<?php if ($article) : ?>

    <article>
        <h2><?= htmlspecialchars($article->title); ?></h2>
        <p><?= htmlspecialchars($article->content); ?></p>
    </article>

    <a href="edit-article.php?id=<?= $article->id; ?>">Edit</a>
    <a href="delete-article.php?id=<?= $article->id; ?>">Delete</a>
    <a href="edit-article-image.php?id=<?= $article->id; ?>">Edit image</a>
    
<?php else : ?>

    <p>Article not found.</p>
<?php endif; ?>

<!-- HTML footer -->
<?php require "../includes/footer.php"; ?>