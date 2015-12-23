<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/*
    Developed by Gustavo Ocanto
    gustavoocanto@gmail.com
    Version 1.0
    May 2014
    Valencia, Venezuela
*/

class company extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getRow()
    {
        $query = $this->db->query("SELECT * FROM company WHERE id = '1' LIMIT 1 ");

        return $query->row();
    }
}
