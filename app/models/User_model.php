<?php

class User_model
{
    private $_db = null;
    private $_formItem = [];

    public function __construct()
    {
        $this->_db = Database::getInstance();
    }

    public function getPicture($username)
    {
        $this->_db->select('foto_profile');
        return $this->_db->getWhereOnce('user', ['username', '=', $username])->foto_profile;
    }

    public function addQuestion($username)
    {
        $this->_db->select('jumlah_question');
        $jumlah = (int) $this->_db->getWhereOnce('user', ['username', '=', $username])->jumlah_question;
        $this->_db->update('user', ['jumlah_question' => $jumlah + 1], ['username', '=', $username]);
    }

    public function addAnswer($username)
    {
        $this->_db->select('jumlah_menjawab');
        $jumlah = (int) $this->_db->getWhereOnce('user', ['username', '=', $username])->jumlah_menjawab;
        $this->_db->update('user', ['jumlah_menjawab' => $jumlah + 1], ['username', '=', $username]);
    }

    public function deleteAnswer($username)
    {
        $this->_db->select('jumlah_menjawab');
        $jumlah = (int) $this->_db->getWhereOnce('user', ['username', '=', $username])->jumlah_menjawab;
        $this->_db->update('user', ['jumlah_menjawab' => $jumlah - 1], ['username', '=', $username]);
    }

    public function getData($username)
    {
        return $this->_db->get('user', 'WHERE username = ?', [$username]);
    }

    public function validateChangePassword($method)
    {
        $validate = new Validate($method);

        $this->_formItem['password_lama'] = $validate->setRules('password_lama', 'Password Lama', [
            'sanitize' => 'string',
            'required' => true
        ]);

        $this->_formItem['password_baru'] = $validate->setRules('password_baru', 'Password Baru', [
            'sanitize' => 'string',
            'required' => true,
            'min_char' => 6,
            'regexp' => '/[A-Za-z]+[0-9]|[0-9][A-Za-z]/'
        ]);

        $this->_formItem['password_baru1'] = $validate->setRules('password_baru1', 'Password', [
            'sanitize' => 'string',
            'required' => true,
            'matches' => 'password_baru'
        ]);

        if (!$validate->passed())
            return $validate->getError();
        else {
            $this->_db->select('password');
            $result = $this->_db->getWhereOnce('user', ['username', '=', $_SESSION['username']]);

            if (empty($result) || !password_verify($this->_formItem['password_lama'], $result->password)) {
                $error['invalid'] = 'Maaf, Password lama anda salah';
                return $error;
            }
        }
    }

    public function changePassword()
    {
        $newUser = [
            'password' => password_hash($this->_formItem['password_baru'], PASSWORD_DEFAULT)
        ];
        $this->_db->update('user', $newUser, ['username', '=', $_SESSION['username']]);
    }

    public function getAllUsers($keyword = null)
    {
        if (is_null($keyword))
            return $this->_db->get('user');
        else
            return $this->_db->get('user', 'WHERE username LIKE ? OR nama_lengkap LIKE ?', ["%{$keyword}%", "%{$keyword}%"]);
    }

    public function validateChangeDetail($method)
    {
        $validate = new Validate($method);

        $this->_formItem['nama'] = $validate->setRules('nama', 'Nama', [
            'sanitize' => 'string',
            'required' => true,
            'min_char' => 4
        ]);

        $this->_formItem['password'] = $validate->setRules('password', 'Password', [
            'sanitize' => 'string',
            'required' => true,
        ]);

        if ($method['username'] != $_SESSION['username'])
            $this->_formItem['username'] = $validate->setRules('username', 'Username', [
                'sanitize' => 'string',
                'required' => true,
                'min_char' => 4,
                'regexp' => '/[A-Za-z0-9]+$/',
                'unique' => ['user', 'username']
            ]);
        else
            $this->_formItem['username'] = $_SESSION['username'];

        if (!$validate->passed())
            return $validate->getError();
        else {
            $this->_db->select('password');
            $result = $this->_db->getWhereOnce('user', ['username', '=', $_SESSION['username']]);

            if (empty($result) || !password_verify($this->_formItem['password'], $result->password)) {
                $error['invalid'] = 'Maaf, Password anda salah';
                return $error;
            }
        }
    }

    public function getItem($item)
    {
        return (isset($this->_formItem[$item])) ? $this->_formItem[$item] : '';
    }

    public function changeDetail($pathFile = null)
    {
        if (is_null($pathFile)) {
            $newUser = [
                'nama_lengkap' => $this->getItem('nama'),
                'username' => $this->getItem('username')
            ];
        } else {
            $newUser = [
                'nama_lengkap' => $this->getItem('nama'),
                'username' => $this->getItem('username'),
                'foto_profile' => $pathFile
            ];
        }
        $this->_db->update('user', $newUser, ['username', '=', $_SESSION['username']]);
    }
}
