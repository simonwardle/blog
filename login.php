<?php

require 'includes/init.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $conn = require 'includes/db.php';

    if (User::authenticate($conn, $_POST['username'], $_POST['password'])) {

        Auth::login();
        Url::redirect('/php/blog/');
    } else {

        $error = 'Login incorrect';
    }
}
?>

<?php require 'includes/header.php'; ?>

<h2>Login</h2>

<?php if (!empty($error)) : ?>
    <p><?= $error ?></p>
<?php endif; ?>

<form method="post">

    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" name="username" id="username" class="form-control">

    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" id="password" class="form-control">
    </div>

    <button class="btn btn-primary">Log in</button>

</form>

<?php require 'includes/footer.php'; ?>