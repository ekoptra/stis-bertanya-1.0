<?php

class Question_model
{

    private $_db = null;
    private $_formItem = [];
    private $_jumlahQuestion = 0;

    public function __construct()
    {
        $this->_db = Database::getInstance();
    }

    public function validateQuestion($method)
    {
        $validate = new Validate($method);

        $this->_formItem['judul'] = $validate->setRules('judul', 'Judul', [
            'sanitize' => 'string',
            'required' => true,
            'spesific' => true
        ]);

        $this->_formItem['pertanyaan'] = $validate->setRules('pertanyaan', 'Pertanyaan', [
            'sanitize' => 'string',
            'required' => true,
            'jelas' => true
        ]);

        $this->_formItem['tag'] = $validate->setRules('tag', 'Tag', [
            'sanitize' => 'string',
            'required' => true,
        ]);

        if (!$validate->passed())
            return $validate->getError();
    }

    public function getItem($item)
    {
        return (isset($this->_formItem[$item])) ? $this->_formItem[$item] : '';
    }

    public function insert()
    {
        $newQuestion = [
            'username' => $_SESSION['username'],
            'judul' => $this->getItem('judul'),
            'pertanyaan' => $this->getItem('pertanyaan'),
            'tanggal_bertanya' => date("Y-m-d H:i:s")
        ];
        $this->_db->insert('question', $newQuestion);
    }

    public function getIdByJudul($judul)
    {
        $this->_db->select('id_pertanyaan');
        return $this->_db->getWhereOnce('question', ['judul', '=', $judul])->id_pertanyaan;
    }

    public function insertTag()
    {
        $tags = explode(" ", $this->getItem('tag'));
        $id = $this->getIdByJudul($this->getItem('judul'));
        foreach ($tags as $tag) {
            $newTag = [
                'id_pertanyaan' => $id,
                'tag' => strtolower($tag)
            ];
            $this->_db->insert('tag', $newTag);
        }
    }

    public function getAllQuestions()
    {
        $this->_db->select('u.nama_lengkap, q.*');
        $this->_db->orderby('q.tanggal_bertanya', 'DESC');
        return $this->_db->get('user AS u, question AS q', 'WHERE q.username = u.username');
    }

    public function getTags($id)
    {
        $this->_db->select('tag');
        $this->_db->fetchAssoc();
        $result = $this->_db->getWhere('tag', ['id_pertanyaan', '=', $id]);
        $tags = [];
        foreach ($result as $tag) {
            $tags[] = $tag['tag'];
        }
        return $tags;
    }

    public function getQuestionById($id)
    {
        $this->_db->select('u.username, u.foto_profile, q.*');
        return $this->_db->get('user AS u, question AS q', 'WHERE u.username = q.username AND q.id_pertanyaan = ' . $id);
    }

    public function getQuestionByUsername($username)
    {
        $this->_db->orderby('tanggal_bertanya', 'DESC');
        return $this->_db->get('question', 'WHERE username = ?', [$username]);
    }

    public function addAnswer($id)
    {
        $this->_db->select('jumlah_jawaban');
        $jumlah = (int) $this->_db->getWhereOnce('question', ['id_pertanyaan', '=', $id])->jumlah_jawaban;
        $this->_db->update('question', ['jumlah_jawaban' => $jumlah + 1], ['id_pertanyaan', '=', $id]);
    }

    public function deleteAnswer($id)
    {
        $this->_db->select('jumlah_jawaban');
        $jumlah = (int) $this->_db->getWhereOnce('question', ['id_pertanyaan', '=', $id])->jumlah_jawaban;
        $this->_db->update('question', ['jumlah_jawaban' => $jumlah - 1], ['id_pertanyaan', '=', $id]);
    }

    private function is_voted($username, $idPertanyaan)
    {
        $result = $this->_db->get('voted_question', "WHERE username = ? AND id_pertanyaan = ?", [$username, $idPertanyaan]);
        if (count($result) > 0)
            return true;
        else
            return false;
    }

    public function voted($username, $idPertanyaan)
    {
        if (!$this->is_voted($username, $idPertanyaan)) {
            $newVoted = [
                'id_pertanyaan' => $idPertanyaan,
                'username' => $username
            ];
            $this->_db->insert('voted_question', $newVoted);

            $this->_db->select('jumlah_voted');
            $jumlah = (int) $this->_db->getWhereOnce('question', ['id_pertanyaan', '=', $idPertanyaan])->jumlah_voted;
            $this->_db->update('question', ['jumlah_voted' => $jumlah + 1], ['id_pertanyaan', '=', $idPertanyaan]);

            $this->_db->select('jumlah_voted');
            $jumlah = (int) $this->_db->getWhereOnce('user', ['username', '=', $username])->jumlah_voted;
            $this->_db->update('user', ['jumlah_voted' => $jumlah + 1], ['username', '=', $username]);
        }
    }

    public function unvoted($username, $idPertanyaan)
    {
        if ($this->is_voted($username, $idPertanyaan)) {
            $this->_db->delete2('voted_question', ['id_pertanyaan', '=', $idPertanyaan], ['username', '=', $username]);
            $this->_db->select('jumlah_voted');
            $jumlah = (int) $this->_db->getWhereOnce('question', ['id_pertanyaan', '=', $idPertanyaan])->jumlah_voted;
            $this->_db->update('question', ['jumlah_voted' => $jumlah - 1], ['id_pertanyaan', '=', $idPertanyaan]);

            $this->_db->select('jumlah_voted');
            $jumlah = (int) $this->_db->getWhereOnce('user', ['username', '=', $username])->jumlah_voted;
            $this->_db->update('user', ['jumlah_voted' => $jumlah - 1], ['username', '=', $username]);
        }
    }

    public function getPopularQuestions()
    {
        $this->_db->select('id_pertanyaan, judul');
        return $this->_db->get('question', 'ORDER BY jumlah_jawaban DESC, jumlah_voted DESC LIMIT 8');
    }

    public function deleteQuestion($idPertanyaan)
    {
        $this->_db->select('jumlah_voted');
        $jumlahVoted = (int) $this->_db->getWhereOnce('question', ['id_pertanyaan', '=', $idPertanyaan])->jumlah_voted;
        $this->_db->select('jumlah_voted');
        $jumlah = (int) $this->_db->getWhereOnce('user', ['username', '=', $_SESSION['username']])->jumlah_voted;
        $this->_db->update('user', ['jumlah_voted' => $jumlah - $jumlahVoted], ['username', '=', $_SESSION['username']]);

        $this->_db->select('jumlah_question');
        $jumlah = (int) $this->_db->getWhereOnce('user', ['username', '=', $_SESSION['username']])->jumlah_question;
        $this->_db->update('user', ['jumlah_question' => $jumlah - 1], ['username', '=', $_SESSION['username']]);

        $this->_db->delete('question', ['id_pertanyaan', '=', $idPertanyaan]);
    }
}
