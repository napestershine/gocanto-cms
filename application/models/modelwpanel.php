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

class modelwpanel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_user($login, $pass)
    {
        $query = $this->db->query("
			SELECT *
			FROM wpanel_users
			WHERE email LIKE '".$login."' AND password LIKE '".$pass."'
			LIMIT 1
		");

        return $query->num_rows() > 0 ? $query->row() : 0;
    }
}
