<?php

class Answer_model
{

    private $_db = null;
    private $_formItem = [];

    public function __construct()
    {
        $this->_db = Database::getInstance();
    }

    public function validateAnswer($method)
    {
        $validate = new Validate($method);

        $this->_formItem['jawaban'] = $validate->setRules('jawaban', 'Jawaban', [
            'required' => true,
            'jelas' => true
        ]);

        if (!$validate->passed())
            return $validate->getError();
    }

    public function getItem($item)
    {
        return (isset($this->_formItem[$item])) ? $this->_formItem[$item] : '';
    }

    public function insert($id)
    {
        $newAnswer = [
            'id_pertanyaan' => $id,
            'username' => $_SESSION['username'],
            'jawaban' => $this->getItem('jawaban'),
            'tanggal_menjawab' => date("Y-m-d H:i:s")
        ];
        $this->_db->insert('answer', $newAnswer);
    }

    public function getAllAnswer($idPrtanyaan)
    {
        $this->_db->select('u.nama_lengkap, u.foto_profile, a.*');
        $this->_db->orderby('a.jumlah_voted', 'DESC');
        return $this->_db->get('user AS u, answer as a', 'WHERE a.username = u.username AND id_pertanyaan = ' . $idPrtanyaan);
    }

    public function deleteAnswer($idPertanyaan, $idJawaban)
    {
        $this->_db->delete2('answer', ['id_pertanyaan', '=', $idPertanyaan], ['id_jawaban', '=', $idJawaban]);
    }

    private function is_voted($username, $idJawaban)
    {
        $result = $this->_db->get('voted_answer', "WHERE username = ? AND id_jawaban = ?", [$username, $idJawaban]);
        if (count($result) > 0)
            return true;
        else
            return false;
    }

    public function voted($username, $idJawaban)
    {
        if (!$this->is_voted($username, $idJawaban)) {
            $newVoted = [
                'id_jawaban' => $idJawaban,
                'username' => $username
            ];
            $this->_db->insert('voted_answer', $newVoted);

            $this->_db->select('jumlah_voted');
            $jumlah = (int) $this->_db->getWhereOnce('answer', ['id_jawaban', '=', $idJawaban])->jumlah_voted;
            $this->_db->update('answer', ['jumlah_voted' => $jumlah + 1], ['id_jawaban', '=', $idJawaban]);
        }
    }

    public function unvoted($username, $idJawaban)
    {
        if ($this->is_voted($username, $idJawaban)) {
            $this->_db->delete2('voted_answer', ['id_jawaban', '=', $idJawaban], ['username', '=', $username]);
            $this->_db->select('jumlah_voted');
            $jumlah = (int) $this->_db->getWhereOnce('answer', ['id_jawaban', '=', $idJawaban])->jumlah_voted;
            $this->_db->update('answer', ['jumlah_voted' => $jumlah - 1], ['id_jawaban', '=', $idJawaban]);
        }
    }

    public function getAllAnswers($idPrtanyaan)
    {
        $this->_db->select('id_jawaban, username');
        return $this->_db->get('answer', 'WHERE id_pertanyaan = ?', [$idPrtanyaan]);
    }
}
