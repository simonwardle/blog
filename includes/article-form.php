<?php if (!empty($article->errors)) : ?>
    <ul>
        <?php foreach ($article->errors as $error) : ?>
            <li><?= $error ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form method="post">

    <div>
        <label for="title">Title</label>
        <input name="title" id="title" placeholder="Article title" value="<?= htmlspecialchars($article->title) ?>">
    </div>

    <div>
        <label for="content">Content</label>
        <textarea name="content" id="content" rows="4" cols="40" placeholder="Article content"><?= htmlspecialchars($article->content) ?></textarea>
    </div>

    <div>
        <label for="published_at">Published</label>
        <input name="published_at" id="published_at" value="<?= htmlspecialchars($article->published_at) ?>">
    </div>

    <button>Save</button>
</form>