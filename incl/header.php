

<!doctype html>
<html lang="sv">
<head>
    <meta charset="utf-8" />
    <!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link rel="stylesheet" href="style/style.css" title="General stylesheet">
    <title><?php echo $title; ?></title>

    <link rel="shortcut icon" href="img/shortcut.ico">

    <?php
    error_reporting(-1);
    ?>

    <!-- Each page can set $pageStyle to create additional style -->
    <?php if(isset($pageStyle)) : ?>
        <style type="text/css">
            <?php echo $pageStyle; ?>
        </style>
    <?php endif; ?>
</head>
<!-- The body id helps with highlighting current menu choice -->
<body<?php if(isset($pageId)) echo " id='$pageId' "; ?>>
<div class="wrapper">

    <header class="header-container">
        <div class="grid_16 header">
            <h1 class="grid_4 alpha logo"><a href="home.php" title="BMO" class="logo"><img src="img/logo.png" alt="BMO"></a></h1>
            <div class="grid_12 omega top-navigation">

                <ul class="links">
                    <li id="home-" class="grid_2 alpha"><a href="home.php" title="Hem">Hem</a></li>
                    <li id="gallery-" class="grid_2"><a href="gallery.php" title="Galleri">Galleri</a></li>
                    <li id="articles-" class="grid_2"><a href="articles.php" title="Artiklar">Artiklar</a></li>
                    <li id="about-" class="grid_2 omega"><a href="about.php" title="Om BMO">Om BMO</a></li>
                </ul>
            </div>
        </div>
    </header><!-- .header-->


