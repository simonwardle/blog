<?php
//This page shows one individual article and gives links to the edit and delete pages
require 'includes/init.php';

$conn = require 'includes/db.php';

//This is the id passed in, is it actually set to something?
if (isset($_GET['id'])) {
    $article = Article::getWithCategories($conn, $_GET['id'], true);
} else {
    $article = null;
}

?>
<!-- HTML header -->
<?php require "includes/header.php"; ?>

<?php if ($article) : ?>

    <article>
        <h2><?= htmlspecialchars($article[0]['title']); ?></h2>

        <time datetime="<?= $article[0]['published_at'] ?>">
            <?php
            $datetime = new DateTime($article[0]['published_at']);
            echo $datetime->format("jS F, Y");
            ?>
        </time>

        <?php if ($article[0]['category_name']) : ?>
            <p>
                Categories:
                <?php foreach ($article as $a) : ?>
                    <?= htmlspecialchars($a['category_name']); ?>
                <?php endforeach; ?>
            </p>
        <?php endif; ?>

        <?php if ($article[0]['image_file']) : ?>
            <img width="50%" height="150" class="img-fluid" src="/php/blog/uploads/<?= $article[0]['image_file']; ?>">
        <?php endif; ?>


        <p><?= htmlspecialchars($article[0]['content']); ?></p>
    </article>

<?php else : ?>

    <p>Article not found.</p>
<?php endif; ?>

<!-- HTML footer -->
<?php require "includes/footer.php"; ?>