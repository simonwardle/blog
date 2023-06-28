<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/dark.css">
    <title>My Blog</title>
</head>

<body>
    <header>
        <h1>My Blog</h1>
    </header>

    <nav>
        <ul>
            <?php if (Auth::isLoggedIn()) : ?>
                <li><a href="/php/blog/logout.php">Log out</a></li>
            <?php else : ?>
                <li><a href="/php/blog//login.php">Log in</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <main>