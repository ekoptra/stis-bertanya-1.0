<?php

class Login extends Controller
{
    private $user = null;

    public function __construct()
    {
        $this->user = $this->model('Login_model');
    }

    public function index($idPertanyaan = -1)
    {
        if ($this->user->is_login())
            header('Location: ' . BASEURL . '/home');

        $data = [];
        if (!empty($_POST)) {
            $data['error'] = $this->user->validateLogin($_POST);
            if (empty($data['error'])) {
                $this->user->login();
                if ($idPertanyaan == 'ask')
                    header('Location: ' . BASEURL . '/home/ask/');
                else if ($idPertanyaan != -1)
                    header('Location: ' . BASEURL . '/home/question/' . $idPertanyaan);
                else
                    header('Location: ' . BASEURL . '/home');
                die();
            }
        }
        $this->view('login/index', $data);
    }

    public function register()
    {
        if ($this->user->is_login())
            header('Location: ' . BASEURL . '/home');

        $data = [];
        if (!empty($_POST)) {
            $data['error'] = $this->user->validateRegister($_POST);
            if (empty($data['error'])) {
                $this->user->insert();
                header('Location: ' . BASEURL . '/login');
                die();
            }
        }
        $this->view('login/register', $data);
    }

    public function logout()
    {
        if (!$this->user->is_login())
            header('Location: ' . BASEURL . '/login');

        $this->user->logout();
        header('Location: ' . BASEURL . '/login');
    }
}
