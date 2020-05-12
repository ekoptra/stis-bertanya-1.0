<?php

$allTags = isset($data['tag']) ? $data['tag'] : '';
$active = isset($data['active']) ? $data['active'] : '';
$popularQuestions = isset($data['popular']) ? $data['popular'] : '';
$menu = [
    'Home' => '/home',
    'Users' => '/user',
    'Tags' => '/tag'
];

?>

<aside>
    <nav>
        <ul>
            <?php foreach ($menu as $key => $value) { ?>
                <?php if ($key == $active) {  ?>
                    <li class="active-2">
                    <?php } else { ?>
                    <li>
                    <?php } ?>
                    <a href="<?= BASEURL . $value ?>"><?= $key ?></a>
                    </li>
                <?php } ?>
        </ul>
    </nav>

    <section class="popular">
        <?php if ($popularQuestions != '') { ?>
            <h3>Pertanyaan Popular</h3>
            <ul>
                <?php foreach ($popularQuestions as $question) { ?>
                    <a href="<?= BASEURL . '/home/question/' . $question->id_pertanyaan ?>">
                        <li><?= $question->judul ?></li>
                    </a>
                <?php } ?>
            </ul>
        <?php } ?>
    </section>

    <section class="list-tag">
        <?php if ($allTags != '') { ?>
            <h3>Semua Tag</h3>
            <div>
                <?php foreach ($allTags as $tag) { ?>
                    <a href="<?= BASEURL . '/tag/detail/' . $tag->tag ?>"><span class="badge"><?= $tag->tag ?></span></a>
                <?php } ?>
            </div>
        <?php } ?>
    </section>
</aside>