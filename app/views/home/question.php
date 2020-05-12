<?php

$question = isset($data['question'][0]) ? $data['question'][0] : '';
$allAnswers = isset($data['answer']) ? $data['answer'] : '';
$errorAnswer = isset($data['error']['jawaban']) ? $data['error']['jawaban'] : '';
$input = isset($data['error']['input']) ? $data['error']['input'] : '';

?>

<main id="question">
    <div class="my-question">

        <div class="vote">
            <a href="<?= BASEURL . '/home/question/' . $question->id_pertanyaan . '/voted' ?>" class="arrow" title="Voted Pertanyaan"><i class="fas fa-caret-up"></i></a>
            <h4><?= $question->jumlah_voted ?></h4>
            <a href="<?= BASEURL . '/home/question/' . $question->id_pertanyaan . '/unvoted' ?>" class="arrow" title="Unvoted Pertanyaan"><i class="fas fa-caret-down"></i></a>
        </div>

        <article>

            <div class="article-header">
                <p class="title">
                    <?= $question->judul ?>
                </p>
                <div class="profile">
                    <div class="img-thumnail">
                        <a href="<?= BASEURL . '/user/detail/' . $question->username ?>">
                            <img title="<?= $question->username ?>" src="<?= BASEURL; ?>/img/<?= $question->foto_profile ?>" alt="Profile">
                        </a>
                    </div>
                    <div class="detail">
                        <small><a href="<?= BASEURL . '/user/detail/' . $question->username ?>"><?= $question->username ?></a></small>
                        <small><?= $question->tanggal_bertanya ?></small>
                        <small><?= $question->jam_bertanya ?></small>
                    </div>
                </div>
            </div>

            <div class="article-content">
                <p>
                    <?= $question->pertanyaan ?>
                </p>
            </div>
        </article>
    </div>

    <hr>
    <?php if ($question->jumlah_jawaban != 0) { ?>
        <div class="all-answers">
            <p class="jumlah-answer"><?= $question->jumlah_jawaban ?> Jawaban</p>

            <?php foreach ($allAnswers as $answer) { ?>
                <section class="answer">

                    <div class="vote">
                        <a href="<?= BASEURL . '/home/answer/' . $question->id_pertanyaan  . '/voted/' . $answer->id_jawaban ?>" class="arrow" title="Voted Jawaban"><i class="fas fa-caret-up"></i></a>
                        <h4><?= $answer->jumlah_voted ?></h4>
                        <a href="<?= BASEURL . '/home/answer/' . $question->id_pertanyaan . '/unvoted/' . $answer->id_jawaban ?>" class="arrow" title="Unvoted Jawaban"><i class="fas fa-caret-down"></i></a>
                    </div>

                    <div class="answer-content">
                        <p class="answer-isi"><?= $answer->jawaban ?></p>

                        <div class="profile">
                            <div class="img-thumnail">
                                <a href="<?= BASEURL . '/user/detail/' . $answer->username ?>">
                                    <img src="<?= BASEURL; ?>/img/<?= $answer->foto_profile ?>" alt="Profile" title="<?= $answer->nama_lengkap ?>">
                                </a>
                            </div>
                            <div class="detail">
                                <small><a href="<?= BASEURL . '/user/detail/' . $answer->username ?>"><?= $answer->username ?></a></small>
                                <small><?= getTanggal($answer->tanggal_menjawab) ?></small>
                                <small><?= getJam($answer->tanggal_menjawab) ?></small>
                            </div>
                            <?php if (isset($_SESSION['username']) && $_SESSION['username'] == $answer->username) { ?>
                                <a href="<?= BASEURL . '/home/answer/' . $question->id_pertanyaan . '/delete/' . $answer->id_jawaban ?>" class="hapus">Hapus</a>
                            <?php } ?>
                        </div>
                    </div>
                </section>
            <?php } ?>
        </div>
        <hr>

    <?php } ?>

    <?php if (isset($_SESSION['username'])) { ?>
        <form action="<?= BASEURL . '/home/answer/' . $question->id_pertanyaan ?>" method="post">
            <h4>Bagikan Jawabanmu</h4>
            <textarea name="jawaban" id="jawaban" placeholder="Jawabanmu"><?= $input ?></textarea>
            <small class=" error"><?= $errorAnswer ?></small>
            <button class="btn">Jawab</button>
        </form>
    <?php } else { ?>
        <a href="<?= BASEURL . '/login/index/' . $question->id_pertanyaan ?>"><button class="btn btn-login">Login Untuk Menjawab</button></a>
    <?php } ?>

</main>