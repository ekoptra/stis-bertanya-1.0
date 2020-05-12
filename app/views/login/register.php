<?php

$errorNama = isset($data['error']['nama_lengkap']) ? $data['error']['nama_lengkap'] : '';
$errorUsername = isset($data['error']['username']) ? $data['error']['username'] : '';
$errorPass = isset($data['error']['password']) ? $data['error']['password'] : '';
$errorPass2 = isset($data['error']['password2']) ? $data['error']['password2'] : '';
$errorEmail = isset($data['error']['email']) ? $data['error']['email'] : '';

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
        <form action="" method="post" class="register">
            <div class="card">
                <div class="card-header">
                    <h2>Daftar STIS Bertanya</h2>
                </div>
                <div class="card-body">
                    <div class="input-group">
                        <h4>Nama Lengkap</h4>
                        <input type="text" name="nama_lengkap" id="nama_lengkap" placeholder="Nama Lengkap" autocomplete="off" value="<?= Input::get('nama_lengkap') ?>">
                        <small class="error"><?= $errorNama; ?></small>
                    </div>
                    <div class="input-group">
                        <h4>Username</h4>
                        <input type="text" name="username" id="username" placeholder="Username" autocomplete="off" value="<?= Input::get('username') ?>">
                        <small class="error"><?= $errorUsername; ?></small>
                    </div>
                    <div class="input-group">
                        <h4>Email</h4>
                        <input type="text" name="email" id="email" placeholder="Email" autocomplete="off" value="<?= Input::get('email') ?>">
                        <small class="error"><?= $errorEmail; ?></small>
                    </div>
                    <div class="input-group">
                        <h4>Password</h4>
                        <input type="password" name="password" id="password" placeholder="Password" value="<?= Input::get('password') ?>">
                        <small class="error"><?= $errorPass; ?></small>
                    </div>
                    <div class="input-group">
                        <h4>Ulangi Password</h4>
                        <input type="password" name="password2" id="password2" placeholder="Ulangi Password">
                        <small class="error"><?= $errorPass2; ?></small>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn">Daftar</button>
                    <small>Sudah Punya Akun? <a href="<?= BASEURL; ?>/login">Login</a></small>
                </div>
            </div>
        </form>
    </div>

    <footer>
        <h4>STIS Bertanya - &copy; 2020</h4>
        <div>
            <a href="https://github.com/ekoptra/stis-bertanya-1.0" target="_blank">Github</a> -
            <a href="https://www.instagram.com/eko_ptra/" target="_blank">Instagram</a> -
            <a href="https://www.facebook.com/ekoputra.wahyuddin" target="_blank">Facebook</a>
        </div>
    </footer>

    <script src="<?= BASEURL; ?>/js/script.js"></script>
</body>

</html>