<?php

class User extends Controller
{
    private $dataHeader = [];
    private $dataSidebar = [];
    public function __construct()
    {
        if (isset($_SESSION['username']))
            $this->dataHeader['foto_profile'] = $this->model('User_model')->getPicture($_SESSION['username']);
        $this->dataHeader['active'] = 'Users';
        $this->dataSidebar['tag'] = $this->model('Tag_model')->getAllTags();
        $this->dataSidebar['popular'] = $this->model('Question_model')->getPopularQuestions();
        $this->dataSidebar['active'] = 'Users';
    }

    public function index()
    {
        $data = [];
        $data['user'] = $this->model('User_model')->getAllUsers();
        $this->dataHeader['title'] = "Semua User";
        $this->view('templates/header', $this->dataHeader);
        $this->view('user/index', $data);
        $this->view('templates/aside', $this->dataSidebar);
        $this->view('templates/footer');
    }

    public function detail($username = null)
    {
        if (is_null($username))
            $this->index();
        else {
            $data = [];
            $data['user'] = $this->model('User_model')->getData($username);
            if (count($data['user']) == 0) {
                $this->index();
            } else {
                $data['question'] = $this->model('Question_model')->getQuestionByUsername($username);
                $this->dataHeader['title'] = "Detail";
                $this->view('templates/header', $this->dataHeader);
                $this->view('user/detail', $data);
                $this->view('templates/aside', $this->dataSidebar);
                $this->view('templates/footer');
            }
        }
    }

    public function editProfile()
    {
        if (!isset($_SESSION['username']))
            $this->detail();
        else {
            $data = [];
            $data['user'] = $this->model('User_model')->getData($_SESSION['username']);
            $data['question'] = $this->model('Question_model')->getQuestionByUsername($_SESSION['username']);
            $this->dataHeader['title'] = "My Profile";
            $this->view('templates/header', $this->dataHeader);
            $this->view('user/editProfile', $data);
            $this->view('templates/aside', $this->dataSidebar);
            $this->view('templates/footer');
        }
    }

    public function changePassword()
    {
        if (!isset($_SESSION['username']))
            $this->editProfile();
        if (!empty($_POST)) {
            $data = [];
            $user = $this->model('User_model');
            $data['errorPass'] = $user->validateChangePassword($_POST);
            if (!empty($data['errorPass'])) {
                $data['user'] = $this->model('User_model')->getData($_SESSION['username']);
                $data['question'] = $this->model('Question_model')->getQuestionByUsername($_SESSION['username']);
                $data['formPass'] = true;
                $this->dataHeader['title'] = "My Profile";
                $this->view('templates/header', $this->dataHeader);
                $this->view('user/editProfile', $data);
                $this->view('templates/aside', $this->dataSidebar);
                $this->view('templates/footer');
            } else {
                $user->changePassword();
                $_SESSION['pesan'] = 'Password berhasil dirubah';
                $this->editProfile();
            }
        } else
            $this->editProfile();
    }

    public function changeDetail()
    {
        if (!isset($_SESSION['username']))
            $this->editProfile();
        if (!empty($_POST)) {
            $data = [];
            $user = $this->model('User_model');
            $data['errorDetail'] = $user->validateChangeDetail($_POST);
            $data['foto'] = '';
            if (!empty($_FILES["foto"]["name"])) {
                // Error Upload Foto
                $array_error = [
                    0 => "",
                    1 => "Upload gagal, ukuran file melebihi batas maksimal 2MB",
                    3 => "Upload gagal, file hanya terupload sebagian",
                    4 => "Masukkan foto Anda",
                    6 => "Upload gagal, server bermasalah",
                    7 => "Upload gagal, server bermasalah",
                    8 => "Upload gagal, server bermasalah"
                ];

                $error_foto = $_FILES["foto"]["error"];
                $data['foto'] = $array_error[$error_foto];

                if ($data['foto'] == 0) {
                    //Persiapan Pemindahan File
                    $namaFolder = "img";
                    $tmp = $_FILES["foto"]["tmp_name"];

                    $namaFile =  $_SESSION['username'] . '.' . ltrim($_FILES["foto"]["type"], "image/");

                    $pathFile = "$namaFolder/$namaFile";
                    //Cek apakah file gambar atau tidak
                    $check = getimagesize($tmp);
                    if ($check === false) {
                        $data['foto'] = "Mohon upload file gambar";
                    } else {
                        $data['foto'] = '';
                    }
                }
            }

            // echo $namaFile;
            if (!empty($data['errorDetail']) || !empty($data['foto'])) {
                $data['user'] = $this->model('User_model')->getData($_SESSION['username']);
                $data['question'] = $this->model('Question_model')->getQuestionByUsername($_SESSION['username']);
                $data['formPass'] = false;
                $this->dataHeader['title'] = "My Profile";
                $this->view('templates/header', $this->dataHeader);
                $this->view('user/editProfile', $data);
                $this->view('templates/aside', $this->dataSidebar);
                $this->view('templates/footer');
            } else {
                if ($namaFile != '') {
                    echo 'masuk';
                    move_uploaded_file($tmp, $pathFile);
                    $user->changeDetail($namaFile);
                } else {
                    $user->changeDetail();
                }
                $_SESSION['pesan'] = 'Data berhasil disimpan';
                header('Location: ' . BASEURL . '/user/editprofile');
            }
        } else
            $this->editProfile();
    }

    public function search($keyword = '')
    {
        $data = [];
        if (empty($keyword))
            $data['user'] = $this->model('User_model')->getAllUsers();
        else
            $data['user'] = $this->model('User_model')->getAllUsers($keyword);
        if (count($data['user']) == 0)
            $data['user'] = [];
        $this->view('user/search', $data);
    }
}
