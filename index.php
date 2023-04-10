<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="author" content="Madeline Quang">
    <meta name="email" content="quan0039@algonquinlive.com">

    <meta name="author" content="Ore Adegbesan">
    <meta name="email" content="adeg0013@algonquinlive.com">

    <meta name="author" content="Sayfullah Eid">
    <meta name="email" content="eid00029@algonquinlive.com">

    <meta name="date" content="31/03/2023">

    <!-- Stylesheet -->
    <link rel="stylesheet" href="styles/main.css" />
    <script async type="text/javascript" src="js/script.js"></script>

    <title>
        <?php print ucfirst(isset($_GET['page']) ? $_GET['page'] : 'home') . ' | GoodStreams' ?>
    </title>
</head>

<body>
    <?php
    // Render the header
    $_SERVER['DOCUMENT_ROOT'] = __DIR__;

    require_once $_SERVER['DOCUMENT_ROOT'] . '/components/header.php';
    ?>
    <?php
    // Render the navbar
    require_once $_SERVER['DOCUMENT_ROOT'] . '/components/navbar.php';
    ?>

    <main>
        <?php

        $page = isset($_GET['page']) != '' ? $_GET['page'] : 'results'; // Get which page is currently requested. "results" is default
        require_once $_SERVER['DOCUMENT_ROOT'] . '/content/' . $page . '.php'; // Display contents of requested page
        ?>
    </main>

    <?php
    // Render the footer
    require_once $_SERVER['DOCUMENT_ROOT'] . '/components/footer.php';
    ?>

</body>

</html>