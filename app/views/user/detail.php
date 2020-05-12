<?php

$biodata = isset($data['user'][0]) ? $data['user'][0] : '';
$allQuestions = isset($data['question']) ? $data['question'] : '';

?>

<main id="detail">
    <ul>
        <a href="">
            <li class="active">Profile</li>
        </a>
        <?php if (isset($_SESSION['username']) && $biodata->username == $_SESSION['username']) { ?>
            <a href="<?= BASEURL . '/user/editprofile' ?>">
                <li>Edit Profile</li>
            </a>
        <?php } ?>
    </ul>

    <div class="my-profile">
        <div class="img-thumnail">
            <img src="<?= BASEURL . '/img/' . $biodata->foto_profile; ?>" alt="Profile">
        </div>

        <div class="profile">
            <h2><?= $biodata->nama_lengkap ?></h2>
            <span><?= $biodata->username ?></span>
            <span><?= $biodata->email ?></span>
            <span><?= $biodata->jumlah_question ?> Pertanyaan - <?= $biodata->jumlah_voted ?> Voted</span>
            <span><?= $biodata->jumlah_menjawab ?> Kali Menjawab</span>
        </div>
    </div>

    <hr>

    <div class="all-my-questions">
        <?php if ($biodata->jumlah_question != 0) { ?>
            <p><?= count($allQuestions) ?> Pertanyaan</p>
            <?php foreach ($allQuestions as $question) { ?>
                <div class="my-question">
                    <div class="info-question">
                        <div class="box">
                            <h4><?= $question->jumlah_voted ?></h4>
                            <small>Vote</small>
                        </div>
                        <div class="box">
                            <h4><?= $question->jumlah_jawaban ?></h4>
                            <small>Jawaban</small>
                        </div>
                    </div>
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