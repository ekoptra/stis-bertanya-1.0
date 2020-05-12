<?php

$allUser = isset($data['user']) ? $data['user'] : '';

?>

<nav>
    <p><?= number_format(count($allUser), 0, '.', '.') ?> User</p>
    <ul class="pagination">
        <a href="">
            <li>Terbaru</li>
        </a>
        <a href="">
            <li>Tervoted</li>
        </a>
        <a href="">
            <li>Popular</li>
        </a>
    </ul>
</nav>

<?php if ($allUser != '') { ?>
    <div class="all-user">
        <?php foreach ($allUser as $user) { ?>
            <div class="user">
                <div class="img-thumnail">
                    <a href="<?= BASEURL . '/user/detail/' . $user->username ?>">
                        <img src="<?= BASEURL . '/img/' . $user->foto_profile; ?>" alt="Profile">
                    </a>
                </div>
                <div class="body">
                    <span><?= $user->nama_lengkap ?></span>
                    <span><a href="<?= BASEURL . '/user/detail/' . $user->username ?>"><?= $user->username ?></a></span>
                    <span><?= $user->jumlah_question ?> Pertanyaan - <?= $user->jumlah_voted ?> Voted</span>
                    <span><?= $user->jumlah_menjawab ?> Menjawab</span>
                </div>
                <div class="footer">
                    <p>Bergabung <?= getTanggal($user->tanggal_bergabung)  ?></p>
                </div>
            </div>
        <?php } ?>
    </div>
<?php } ?>