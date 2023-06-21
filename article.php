<?php
//This page shows one individual article and gives links to the edit and delete pages
require 'includes/database.php';
require 'includes/article.php';

$conn = getDB();

//This is the id passed in, is it actually set to something?
if (isset($_GET['id'])) {

    $id = $_GET['id'];
    $article = getArticle($conn, $id);
} else {

    $article = null;
}
?>
<!-- HTML header -->
<?php require "includes/header.php"; ?>

<?php if ($article === null) : ?>
    <p>Article not found.</p>
<?php else : ?>

    <article>
        <h2><?= htmlspecialchars($article['title']); ?></h2>
        <p><?= htmlspecialchars($article['content']); ?></p>
    </article>

    <a href="edit-article.php?id=<?= $article['id']; ?>">Edit</a>
    <a href="delete-article.php?id=<?= $article['id']; ?>">Delete</a>

<?php endif; ?>

<!-- HTML footer -->
<?php require "includes/footer.php"; ?>