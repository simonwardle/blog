<?php

require '../includes/init.php';

Auth::requiresLogin();

$conn = require '../includes/db.php';

$article = new Article();

//This is a new article so just initialize category ids to a blank array.
$category_ids = [];
$categories = Category::getAll($conn);

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $article->title = $_POST['title'];
    $article->content = $_POST['content'];
    $article->published_at = $_POST['published_at'];

    $category_ids = $_POST['category'] ?? [];

    if ($article->create($conn)) {
        $article->setCategories($conn, $category_ids);
        Url::redirect("/php/blog/admin/article.php?id={$article->id}");
    }
}
?>

<?php require '../includes/header.php'; ?>

<h2>New article</h2>

<?php require 'includes/article-form.php'; ?>

<?php require '../includes/footer.php'; ?>