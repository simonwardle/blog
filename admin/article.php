<?php
//This page shows one individual article and gives links to the edit and delete pages
require '../includes/init.php';

Auth::requiresLogin();

$conn = require '../includes/db.php';

//This is the id passed in, is it actually set to something?
if (isset($_GET['id'])) {
    $article = Article::getWithCategories($conn, $_GET['id']);
} else {
    $article = null;
}
?>
<!-- HTML header -->
<?php require "../includes/header.php"; ?>

<?php if ($article) : ?>

    <article>
        <h2><?= htmlspecialchars($article[0]['title']); ?></h2>

        <?php if ($article[0]['category_name']) : ?>
            <p>
                Categories:
                <?php foreach ($article as $a) : ?>
                    <?= htmlspecialchars($a['category_name']); ?>
                <?php endforeach; ?>
            </p>
        <?php endif; ?>

        <?php if ($article[0]['image_file']) : ?>
            <img src="/php/blog/uploads/<?= $article[0]['image_file']; ?>">
        <?php endif; ?>


        <p><?= htmlspecialchars($article[0]['content']); ?></p>
    </article>


    <a href="edit-article.php?id=<?= $article[0]['id']; ?>">Edit</a>
    <a href="delete-article.php?id=<?= $article[0]['id']; ?>">Delete</a>
    <a href="edit-article-image.php?id=<?= $article[0]['id']; ?>">Edit image</a>
    
<?php else : ?>

    <p>Article not found.</p>
<?php endif; ?>

<!-- HTML footer -->
<?php require "../includes/footer.php"; ?>