<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/*
    Developed by Gustavo Ocanto
    gustavoocanto@gmail.com
    Version 1.0
    May 2014
    Valencia, Venezuela
*/

class modelnewsletters extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function insert($id_type, $name, $email)
    {
        $data = array(
            'id_type' => $id_type,
            'name' => formatString($name, 3),
            'email' => formatString($email, 3)
        );

        $this->db->insert('newsletters', $data);
    }

    public function exists($email)
    {
        $query = $this->db->query("SELECT email FROM newsletters WHERE email LIKE '".$email."'");
        return ($query->num_rows()) > 0 ? true : false;
    }
}
