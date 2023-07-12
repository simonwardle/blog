<?php

require '../includes/init.php';

Auth::requiresLogin();

$conn = require '../includes/db.php';

//?? replaces checking if the page is set. If it is set use it otherwise use 1 
$paginator = new Paginator($_GET['page'] ?? 1, 10, Article::getTotal($conn));

$articles = Article::getPage($conn, $paginator->limit, $paginator->offset);

?>

<!-- HTML header -->
<?php require "../includes/header.php"; ?>

<h1>Administration</h1>

<p><a href="/php/blog/admin/new-article.php">New article</a></p>

<?php if (empty($articles)) : ?>
    <p>No articles found.</p>
<?php else : ?>
    <table class="table">
        <thead>
            <th>Title</th>
            <th>Published</th>
        </thead>

        <tbody>
            <?php foreach ($articles as $article) : ?>
                <tr>
                    <td>
                        <a href="/php/blog/admin/article.php?id=<?= $article['id']; ?>">
                            <?= htmlspecialchars($article['title']); ?></a>
                    </td>
                    <td>
                        <?php if ($article['published_at']) : ?>
                            <time>
                                <?= $article['published_at']; ?>
                            </time>
                        <?php else : ?>
                            Unpublished
                            <button class="btn btn-primary btn-sm publish" data-id="<?= $article['id'] ?>" >Publish</button>
                        <?php endif; ?>
                    </td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php require "../includes/pagination.php"; ?>

<?php endif; ?>

<!-- HTML footer -->
<?php require "../includes/footer.php"; ?>