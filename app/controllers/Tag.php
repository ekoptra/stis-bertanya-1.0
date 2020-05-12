<?php

class Tag extends Controller
{
    private $dataHeader = [];
    private $dataSidebar = [];

    public function __construct()
    {
        if (isset($_SESSION['username']))
            $this->dataHeader['foto_profile'] = $this->model('User_model')->getPicture($_SESSION['username']);
        $this->dataHeader['active'] = 'Tags';
        $this->dataSidebar['tag'] = $this->model('Tag_model')->getAllTags();
        $this->dataSidebar['popular'] = $this->model('Question_model')->getPopularQuestions();
        $this->dataSidebar['active'] = 'Tags';
    }

    public function index()
    {
        $this->dataHeader['title'] = "Tags";
        $this->view('templates/header', $this->dataHeader);
        $this->view('tag/index');
        $this->view('templates/aside', $this->dataSidebar);
        $this->view('templates/footer');
    }
}
