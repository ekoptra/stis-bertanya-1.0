<?php

class Login_model
{
    private $_db = null;
    private $_formItem = [];

    public function __construct()
    {
        $this->_db = Database::getInstance();
    }

    public function validateRegister($method)
    {
        $validate = new Validate($method);

        $this->_formItem['nama_lengkap'] = $validate->setRules('nama_lengkap', 'Nama lengkap', [
            'sanitize' => 'string',
            'required' => true,
            'min_char' => 4
        ]);

        $this->_formItem['username'] = $validate->setRules('username', 'Username', [
            'sanitize' => 'string',
            'required' => true,
            'min_char' => 4,
            'regexp' => '/[A-Za-z0-9]+$/',
            'unique' => ['user', 'username']
        ]);

        $this->_formItem['email'] = $validate->setRules('email', 'Email', [
            'sanitize' => 'string',
            'required' => true,
            'regexp' => '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD',
            'email' => true
        ]);

        $this->_formItem['password'] = $validate->setRules('password', 'Password', [
            'sanitize' => 'string',
            'required' => true,
            'min_char' => 6,
            'regexp' => '/[A-Za-z]+[0-9]|[0-9][A-Za-z]/'
        ]);

        $this->_formItem['password2'] = $validate->setRules('password2', 'Password', [
            'sanitize' => 'string',
            'required' => true,
            'matches' => 'password'
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
        $newUser = [
            'nama_lengkap' => $this->getItem('nama_lengkap'),
            'username' => $this->getItem('username'),
            'password' => password_hash($this->getItem('password'), PASSWORD_DEFAULT),
            'email' => $this->getItem('email'),
            'tanggal_bergabung' => date("Y-m-d")
        ];

        $this->_db->insert('user', $newUser);
    }

    public function validateLogin($metdod)
    {
        $validate = new Validate($metdod);

        $this->_formItem['username'] = $validate->setRules('username', 'Username', [
            'sanitize' => 'string',
            'required' => true
        ]);

        $this->_formItem['password'] = $validate->setRules('password', 'Password', [
            'sanitize' => 'string',
            'required' => true
        ]);

        if (!$validate->passed())
            return $validate->getError();
        else {
            $this->_db->select('password');
            $result = $this->_db->getWhereOnce('user', ['username', '=', $this->_formItem['username']]);
            if (empty($result) || !password_verify($this->_formItem['password'], $result->password)) {
                $pesanError['invalid'] = 'Maaf, username / password salah';
                return $pesanError;
            }
        }
    }

    public function login()
    {
        $data = [
            'status' => 1
        ];
        $this->_db->update('user', $data, ['username', '=', $this->getItem('username')]);
        $_SESSION['username'] = $this->getItem('username');
    }

    public function logout()
    {
        $data = [
            'status' => 0
        ];
        $this->_db->update('user', $data, ['username', '=', $_SESSION['username']]);
        unset($_SESSION['username']);
    }

    public function is_login()
    {
        return isset($_SESSION['username']) ? true : false;
    }
}
