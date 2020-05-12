<?php

class Home extends Controller
{
    private $dataHeader = [];
    private $dataSidebar = [];

    public function __construct()
    {
        if (isset($_SESSION['username']))
            $this->dataHeader['foto_profile'] = $this->model('User_model')->getPicture($_SESSION['username']);
        $this->dataHeader['active'] = 'Home';
        $this->dataSidebar['tag'] = $this->model('Tag_model')->getAllTags();
        $this->dataSidebar['popular'] = $this->model('Question_model')->getPopularQuestions();
        $this->dataSidebar['active'] = 'Home';
    }

    public function index()
    {
        $data = [];
        $data['question'] = $this->model('Question_model')->getAllQuestions();
        foreach ($data['question'] as $question) {
            $question->tags = $this->model('Question_model')->getTags($question->id_pertanyaan);
            $question->tanggal_bertanya = getTanggal($question->tanggal_bertanya);
        }
        $this->dataHeader['title'] = "STIS Bertanya";
        $this->view('templates/header', $this->dataHeader);
        $this->view('home/index', $data);
        $this->view('templates/aside', $this->dataSidebar);
        $this->view('templates/footer');
    }

    public function question($id = null, $action = null)
    {
        if (!is_null($action) && isset($_SESSION['username'])) {

            if ($action == 'delete' && !is_null($id)) {
                $allAnswer = $this->model('Answer_model')->getAllAnswers($id);
                if (count($allAnswer) != 0)
                    foreach ($allAnswer as $answer) {
                        $this->model('Answer_model')->deleteAnswer($id, $answer->id_jawaban);
                        $this->model('Question_model')->deleteAnswer($id);
                        $this->model('User_model')->deleteAnswer($answer->username);
                    }
                $this->model('Question_model')->deleteQuestion($id);
                header('Location: ' . BASEURL . '/user/editprofile');
            } else if ($action == 'voted' && !is_null($id)) {
                $this->model('Question_model')->voted($_SESSION['username'], $id);
            } else if ($action == 'unvoted' && !is_null($id)) {
                $this->model('Question_model')->unvoted($_SESSION['username'], $id);
            }
            header('Location: ' . BASEURL . '/home/question/' . $id);
        } else if (is_null($id))
            $this->index();
        else {
            $this->dataHeader['title'] = "Pertanyaan";
            $data = [];
            $data['question'] = $this->model('Question_model')->getQuestionById($id);

            if (empty($data['question']))
                $this->index();
            else {
                $tanggal = $data['question'][0]->tanggal_bertanya;
                $data['question'][0]->tanggal_bertanya = getTanggal($tanggal);
                $data['question'][0]->jam_bertanya = getJam($tanggal);

                if ($data['question'][0]->jumlah_jawaban != 0) {
                    $data['answer'] = $this->model('Answer_model')->getAllAnswer($id);
                }

                $data['error'] = [];
                if (isset($_SESSION['error'])) {
                    $data['error'] = $_SESSION['error'];
                    unset($_SESSION['error']);
                }

                $this->view('templates/header', $this->dataHeader);
                $this->view('home/question', $data);
                $this->view('templates/aside', $this->dataSidebar);
                $this->view('templates/footer');
            }
        }
    }

    public function ask()
    {
        if (!isset($_SESSION['username']))
            header('Location: ' . BASEURL . '/login/ask');
        else {
            $this->dataHeader['title'] = "Bertanya";
            $data = [];
            if (!empty($_POST)) {
                $question = $this->model('Question_model');
                $data['error'] = $question->validateQuestion($_POST);
                if (empty($data['error'])) {
                    $question->insert();
                    $question->insertTag();
                    $this->model('User_model')->addQuestion($_SESSION['username']);
                    header('Location: ' . BASEURL . '/home');
                }
            }

            $this->view('templates/header', $this->dataHeader);
            $this->view('home/ask', $data);
            $this->view('templates/aside', $this->dataSidebar);
            $this->view('templates/footer');
        }
    }

    public function answer($idPertanyaan = null, $action = null, $idAnswer = null)
    {
        if (!is_null($action) && isset($_SESSION['username'])) {

            if ($action == 'delete' && !is_null($idAnswer)) {
                $this->model('Answer_model')->deleteAnswer($idPertanyaan, $idAnswer);
                $this->model('Question_model')->deleteAnswer($idPertanyaan);
                $this->model('User_model')->deleteAnswer($_SESSION['username']);
            } else if ($action == 'voted' && !is_null($idAnswer)) {
                $this->model('Answer_model')->voted($_SESSION['username'], $idAnswer);
            } else if ($action == 'unvoted' && !is_null($idAnswer)) {
                $this->model('Answer_model')->unvoted($_SESSION['username'], $idAnswer);
            }
            header('Location: ' . BASEURL . '/home/question/' . $idPertanyaan);
        } else if (is_null($idPertanyaan)) {
            header('Location: ' . BASEURL . '/home');
        } else {
            if (!isset($_POST))
                header('Location: ' . BASEURL . '/home/question/' . $idPertanyaan);
            else {
                $data = [];
                $answer = $this->model('Answer_model');
                $data['error'] = $answer->validateAnswer($_POST);
                if (!empty($data['error'])) {
                    $data['error']['input'] = Input::get('jawaban');
                    $_SESSION['error'] = $data['error'];
                } else {
                    $answer->insert($idPertanyaan);
                    $this->model('Question_model')->addAnswer($idPertanyaan);
                    $this->model('User_model')->addAnswer($_SESSION['username']);
                }
                header('Location: ' . BASEURL . '/home/question/' . $idPertanyaan);
            }
        }
    }
}
