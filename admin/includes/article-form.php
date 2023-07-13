<?php if (!empty($article->errors)) : ?>
    <ul>
        <?php foreach ($article->errors as $error) : ?>
            <li><?= $error ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form method="post" id="formArticle">

    <div class="mb-3">
        <label for="title">Title</label>
        <input name="title" id="title" placeholder="Article title" class="form-control" value="<?= htmlspecialchars($article->title) ?>">
    </div>

    <div class="mb-3">
        <label for="content">Content</label>
        <textarea name="content" id="content" rows="4" cols="40" class="form-control" placeholder="Article content"><?= htmlspecialchars($article->content) ?></textarea>
    </div>

    <div>
        <label for="published_at">Content Publication date and time</label>
        <input class="form-control" name="published_at" id="published_at" value="<?= 
        htmlspecialchars($article->published_at) ?>">
    </div>

    <fieldset>
        <legend>Categories</legend>
        <?php foreach ($categories as $category) : ?>
            <div class="form-check">
                
                <input class="form-check-input" type="checkbox" name="category[]" value="<?= $category['id'] ?>" 
                id="<?= $category['id'] ?>"
                <?php if (in_array($category['id'], $category_ids)): ?>
                    checked
                <?php endif; ?>

                <label class="form-check-label" for="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></label>
            </div>
        <?php endforeach; ?>
    </fieldset>

    <button class="btn btn-primary">Save</button>
</form>