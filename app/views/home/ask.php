<?php

$errorJudul = isset($data['error']['judul']) ? $data['error']['judul'] : '';
$errorPertanyaan = isset($data['error']['pertanyaan']) ? $data['error']['pertanyaan'] : '';
$errorTag = isset($data['error']['tag']) ? $data['error']['tag'] : '';
?>

<main id="ask">
    <p>Ask A Question</p>
    <form action="" method="POST">
        <div class="input-group">
            <h4><label for="judul">Title</label></h4>
            <input type="text" name="judul" id="judul" placeholder="Judul yang spesific" value="<?= Input::get('judul') ?>">
            <small class="error"><?= $errorJudul; ?></small>
        </div>

        <div class="input-group">
            <h4><label for="pertanyaan">Pertanyaan</label></h4>
            <textarea name="pertanyaan" id="pertanyaan"><?= Input::get('pertanyaan') ?></textarea>
            <small class="error"><?= $errorPertanyaan; ?></small>
        </div>

        <div class="input-group">
            <h4><label for="tag">Tags</label></h4>
            <input type="text" name="tag" id="tag" placeholder="Contoh : r-studio statmat anareg" value="<?= Input::get('tag') ?>">
            <small class="error"><?= $errorTag; ?></small>
        </div>
        <button class="btn" type="submit">Ask My Question</button>
    </form>

</main>