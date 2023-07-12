<?php

require 'includes/init.php';

$conn = require 'includes/db.php';

//?? replaces checking if the page is set. If it is set use it otherwise use 1 
$paginator = new Paginator($_GET['page'] ?? 1, 4, Article::getTotal($conn, true));

$articles = Article::getPage($conn, $paginator->limit, $paginator->offset, true);
?>

<!-- HTML header -->
<?php require "includes/header.php"; ?>

<?php if (empty($articles)) : ?>
    <p>No articles found.</p>
<?php else : ?>
    <ul>
        <?php foreach ($articles as $article) : ?>
            <li>
                <article>
                    <h2><a href="article.php?id=<?= $article['id']; ?>"><?= htmlspecialchars($article['title']); ?></a></h2>

                    <time datetime="<?= $article['published_at'] ?>">
                        <?php
                        $datetime = new DateTime($article['published_at']);
                        echo $datetime->format("jS F, Y");
                        ?>
                    </time>

                    <?php if ($article['category_names']) : ?>
                        <p>Categories:
                            <?php foreach ($article['category_names'] as $category_name) : ?>
                                <?= htmlspecialchars($category_name); ?>
                            <?php endforeach; ?>
                        </p>
                    <?php endif; ?>
                    <p><?= htmlspecialchars($article['content']); ?></p>
                </article>
            </li>
        <?php endforeach; ?>
    </ul>

    <?php require 'includes/pagination.php'; ?>

<?php endif; ?>

<!-- HTML footer -->
<?php require "includes/footer.php"; ?>