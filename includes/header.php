<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/dark.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="/php/blog/css/styles.css">
    <link rel="stylesheet" href="/php/blog/css/jquery.datetimepicker.min.css">
    <title>My Blog</title>
</head>

<body>
    <div class="container">
    <header>
        <h1>My Blog</h1>
    </header>

    <nav>
        <ul class="nav">
            <li class="nav-item"><a class="nav-link" href="/php/blog">Home</a></li>
            <?php if (Auth::isLoggedIn()) : ?>
                <li class="nav-item"><a class="nav-link" href="/php/blog/admin">Admin</a></li>
                <li class="nav-item"><a class="nav-link" href="/php/blog/logout.php">Log out</a></li>
            <?php else : ?>
                <li class="nav-item"><a class="nav-link" href="/php/blog/login.php">Log in</a></li>
            <?php endif; ?>
            <li class="nav-item"><a class="nav-link" href="/php/blog/contact.php">Contact</a></li>
        </ul>
    </nav>

    <main>