<?php

class Tag_model
{
    private $_db = null;
    private $_jumlahQuestion = 0;

    public function __construct()
    {
        $this->_db = Database::getInstance();
    }

    public function getAllTags()
    {
        $this->_db->select('DISTINCT(tag)');
        $this->_db->orderby('tag', 'ASC');
        return $this->_db->get('tag');
    }
}
