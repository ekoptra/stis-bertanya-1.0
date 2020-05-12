<?php

$errorUsername = isset($data['error']['username']) ? $data['error']['username'] : '';
$errorPass = isset($data['error']['password']) ? $data['error']['password'] : '';
$errorInvalid = isset($data['error']['invalid']) ? $data['error']['invalid'] : '';

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STIS Bertanya</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Pacifico&displasy=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/globalStyle.css">
    <link rel="stylesheet" href="<?= BASEURL; ?>/fontawesome/css/all.css">
</head>

<body>
    <div class="container" id="login">
        <form action="" method="post">
            <div class="card">
                <div class="card-header">
                    <h2>Login STIS Bertanya</h2>
                </div>
                <div class="card-body">
                    <?php if (!empty($errorInvalid)) { ?>
                        <div class="alert">
                            <p class="alert-pesan">
                                <?= $errorInvalid; ?>
                            </p>
                            <div class="toggle">
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="input-group">
                        <h4>Username</h4>
                        <input type="text" name="username" id="username" placeholder="Username" value="<?= Input::get('username') ?>" autocomplete="off">
                        <small class="error"><?= $errorUsername; ?></small>
                    </div>
                    <div class="input-group">
                        <h4>Password</h4>
                        <input type="password" name="password" id="password" placeholder="Password">
                        <small class="error"><?= $errorPass; ?></small>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn">Login</button>
                    <small>Belum Punya Akun? <a href="<?= BASEURL; ?>/login/register">Daftar</a></small>
                </div>
            </div>
        </form>
    </div>

    <footer class="login">
        <h4>STIS Bertanya - &copy; 2020</h4>
        <div>
            <a href="https://github.com/ekoptra/stis-bertanya-1.0" target="_blank">Github</a> -
            <a href="https://www.instagram.com/eko_ptra/" target="_blank">Instagram</a> -
            <a href="https://www.facebook.com/ekoputra.wahyuddin" target="_blank">Facebook</a>
        </div>
    </footer>
    <script src="<?= BASEURL; ?>/js/script2.js"></script>
</body>

</html>