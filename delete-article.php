<?php

require 'classes/Database.php';
require 'classes/Article.php';
require 'includes/url.php';

$db = new Database();
$conn = $db->getConn();

//This is the id passed in, is it actually set to something?
if (isset($_GET['id'])) {
    $article = Article::getById($conn, $_GET['id']);

    if (!$article) {
        die("article not found!");
    }
} else {

    die("id not suppliced, article not found!");
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if ($article->delete($conn)) {
        redirect("/php/blog/index.php");
    }
}
?>

<?php require 'includes/header.php'; ?>

<h2>Delete article</h2>

<form method="post">
    <p>Are you sure?</p>

    <button>Delete</button>
    <a href="article.php?id=<?= $article->id; ?>">Cancel</a>
</form>

<?php require 'includes/footer.php'; ?>