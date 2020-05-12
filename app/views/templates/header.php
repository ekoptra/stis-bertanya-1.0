<?php

$fotoProfile = isset($data['foto_profile']) ? $data['foto_profile'] : '';
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$title = isset($data['title']) ? $data['title'] : '';


$menu = [
    'Home' => '/home',
    'Users' => '/user',
    'Tags' => '/tag'
];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Pacifico&displasy=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/globalStyle.css">
    <link rel="stylesheet" href="<?= BASEURL; ?>/fontawesome/css/all.css">
</head>

<body>
    <header>
        <div class="logo">
            <h4><a href="<?= BASEURL ?>" class="white-hover">STIS Bertanya</a></h4>
        </div>

        <form action="#" method="GET">
            <input type="text" placeholder="Mohon Maaf Search ini belum berfungsi">
        </form>

        <div class="info">
            <?php if (!empty($username)) { ?>
                <div class="img-thumnail">
                    <a href="<?= BASEURL . '/user/detail/' . $username ?>">
                        <img src="<?= BASEURL; ?>/img/<?= $fotoProfile; ?>" alt="Profile" title="<?= $username; ?>">
                    </a>
                </div>
            <?php } ?>

            <div class="logout">
                <?php if (!empty($username)) { ?>
                    <a href="<?= BASEURL; ?>/login/logout" class="white-hover" title="Logout">
                        <i class="fas fa-sign-out-alt "></i>
                    </a>
                <?php } else { ?>
                    <a href="<?= BASEURL; ?>/login" class="white-hover" title="Login">
                        <i class="fas fa-sign-in-alt"></i>
                    </a>
                <?php } ?>

            </div>
        </div>

        <div class="menu-toggle">
            <input type="checkbox">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <div class="dropdown">
            <ul>
                <?php foreach ($menu as $key => $value) { ?>
                    <a href="<?= BASEURL . $value ?>">
                        <?php if ($key == $data['active']) { ?>
                            <li class="active"><?= $key; ?></li>
                        <?php } else { ?>
                            <li><?= $key; ?></li>
                        <?php } ?>
                    </a>
                <?php } ?>

                <?php if (!empty($username)) { ?>
                    <a href="<?= BASEURL ?>/user/detail/<?= $username; ?>">
                        <li>My Profile</li>
                    </a>
                    <a href="<?= BASEURL ?>/login/logout">
                        <li>Logout</li>
                    </a>
                <?php } else { ?>
                    <a href="<?= BASEURL ?>/login">
                        <li>Login</li>
                    </a>
                <?php } ?>

            </ul>
        </div>
    </header>

    <div class="container">