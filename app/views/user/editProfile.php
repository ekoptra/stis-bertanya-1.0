<?php
$biodata = isset($data['user'][0]) ? $data['user'][0] : '';
$allQuestions = isset($data['question']) ? $data['question'] : '';
$errorPassBaru = isset($data['errorPass']['password_baru']) ? $data['errorPass']['password_baru'] : '';
$errorPassBaru1 = isset($data['errorPass']['password_baru1']) ? $data['errorPass']['password_baru1'] : '';
$errorPassLama = isset($data['errorPass']['password_lama']) ? $data['errorPass']['password_lama'] : '';
$errorinvalid = isset($data['errorPass']['invalid']) ? $data['errorPass']['invalid'] : '';
$formPass = isset($data['formPass']) ? $data['formPass'] : false;
$errorNama = isset($data['errorDetail']['nama']) ? $data['errorDetail']['nama'] : '';
$errorUsername = isset($data['errorDetail']['username']) ? $data['errorDetail']['username'] : '';
$errorPassword = isset($data['errorDetail']['password']) ? $data['errorDetail']['password'] : '';
$errorinvalid2 = isset($data['errorDetail']['invalid']) ? $data['errorDetail']['invalid'] : '';
$errorFoto = isset($data['foto']) ? $data['foto'] : '';

?>
<main id="detail">
    <ul>
        <a href="<?= BASEURL . '/user/detail/' . $biodata->username ?>">
            <li>Profile</li>
        </a>
        <a href="#">
            <li class="active">Edit Profile</li>
        </a>
    </ul>

    <div class="my-profile">
        <div class="img-thumnail <?= $formPass ? '' : 'hover' ?>" id='img-hover'>
            <img src="<?= BASEURL . '/img/' . $biodata->foto_profile; ?>" alt="Profile">
        </div>

        <div class="profile profile-2" id="profile">
            <form action="<?= BASEURL . '/user/changedetail' ?>" method="POST" id='rubah-detail' class="<?= $formPass ? 'hidden' : '' ?>" enctype="multipart/form-data">
                <div class="input">
                    <div class="input-group" id="edit-nama">
                        <input type="text" name="nama" id="nama" value="<?= $biodata->nama_lengkap ?>">
                        <small class="error"><?= $errorNama ?></small>
                    </div>
                    <div class="input-group" id="edit-username">
                        <input type="text" name="username" id="username" value="<?= $biodata->username ?>">
                        <small class="error"><?= $errorUsername ?></small>
                    </div>
                    <div class="input-group">
                        <input type="password" name="password" id="password" placeholder="Your Password">
                        <small class="error"><?= $errorPassword ?><?= $errorinvalid2 ?></small>
                    </div>
                    <small class="error"><?= $errorFoto ?></small>
                    <input type="file" name="foto" id="foto-profile" accept="image/*" hidden>
                </div>
            </form>

            <form action="<?= BASEURL . '/user/changepassword' ?>" method="POST" class="<?= $formPass ? '' : 'hidden' ?>" id='rubah-password'>
                <div class="input">
                    <div class="input-group" id="edit-password">
                        <input type="password" name="password_baru" id="password_baru" placeholder="Your New Password">
                        <small class="error"><?= $errorPassBaru ?></small>
                    </div>
                    <div class="input-group" id="edit-password2">
                        <input type="password" name="password_baru1" id="password_baru1" placeholder="Re-write Your New Password">
                        <small class="error"><?= $errorPassBaru1 ?></small>
                    </div>
                    <div class="input-group">
                        <input type="password" name="password_lama" id="password_lama" placeholder="Your Password">
                        <small class="error"><?= $errorPassLama ?><?= $errorinvalid ?></small>
                    </div>
                </div>
            </form>

            <div class="button">
                <button class="btn" type="button" id="tombol-rubah"><?= $formPass ? 'Rubah Detail' : 'Rubah Password' ?></button>
                <button class="btn" type="submit" form='<?= $formPass ? 'rubah-password' : 'rubah-detail' ?>' id="tombol-save">Simpan</button>
            </div>
            <?php if (isset($_SESSION['pesan'])) { ?>
                <small><?= $_SESSION['pesan'] ?></small>
            <?php unset($_SESSION['pesan']);
            } ?>
        </div>
    </div>

    <hr>


    <div class="all-my-questions">
        <?php if ($biodata->jumlah_question != 0) { ?>
            <p><?= count($allQuestions) ?> Question</p>
            <?php foreach ($allQuestions as $question) { ?>
                <div class="my-question">
                    <a href="<?= BASEURL . '/home/question/' . $question->id_pertanyaan . '/delete' ?>" id="hapus">
                        <span>Hapus</span>
                    </a>
                    <p class="title">
                        <a href="<?= BASEURL . '/home/question/' . $question->id_pertanyaan ?>">
                            <?= $question->judul ?>
                        </a>
                    </p>
                    <small><?= getTanggal($question->tanggal_bertanya)  ?></small>
                </div>
                <hr>
            <?php } ?>
        <?php } ?>
    </div>
</main>