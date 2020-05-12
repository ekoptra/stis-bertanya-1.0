<?php

$allQuestions = isset($data['question']) ? $data['question'] : '';

?>


<main>
    <div class="judul">
        <p>Semua Pertanyaan</p>
        <a href="<?= BASEURL; ?>/home/ask"><button class="btn">Bertanya</button></a>
    </div>

    <nav>
        <p><?= number_format(count($allQuestions), 0, '.', '.') ?> Pertanyaan</p>
        <ul class="pagination">
            <a href="">
                <li>Bulan Ini</li>
            </a>
            <a href="">
                <li>Belum Terjawab</li>
            </a>
            <a href="">
                <li>Unvoted</li>
            </a>
        </ul>
    </nav>

    <?php if (count($allQuestions) != 0) { ?>
        <div class="all-questions">
            <?php foreach ($allQuestions as $question) { ?>
                <section class="question">
                    <div class="info-question">
                        <div class="box">
                            <h4><?= $question->jumlah_voted ?></h4>
                            <small>Vote</small>
                        </div>
                        <div class="box">
                            <h4><?= $question->jumlah_jawaban ?></h4>
                            <small>Answer</small>
                        </div>
                    </div>
                    <div class="detail-question">
                        <div class="header-detail">
                            <a href="<?= BASEURL . '/home/question/' . $question->id_pertanyaan ?>"><?= $question->judul ?></a>
                            <small><a href="<?= BASEURL . '/user/detail/' . $question->username ?>"><?= $question->nama_lengkap ?></a> - <?= $question->tanggal_bertanya ?></small>
                        </div>

                        <div>
                            <?php foreach ($question->tags as $tag) { ?>
                                <a href="<?= BASEURL . '/tag/detail/' . $tag ?>"><span class="badge"><?= $tag ?></span></a>
                            <?php } ?>
                        </div>
                    </div>
                </section>
            <?php } ?>
        </div>

        <!-- <div class="pagination-question">
            <ul class="pagination">
                <a href="" class="active">
                    <li>1</li>
                </a>
                <a href="">
                    <li>2</li>
                </a>
                <a href="">
                    <li>3</li>
                </a>
            </ul>
        </div> -->

    <?php } ?>

</main>