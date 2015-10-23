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

class payment extends CI_Model
{
    private $table;
    private $admin;
    private $current_user;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->table='payment';
        $this->current_user=false;
        if ($this->session->userdata('wp-user')) {
            $this->current_user = $this->session->userdata('wp-user');
            $this->admin = $this->current_user['id_profile']==1?true:false;
        }
    }

    public function getRows($options)
    {
        $defaults = ['fields'=>'*','where'=>'', 'limit' =>'', 'order'=>' ORDER BY datetime DESC'];

        $options = $options + $defaults;

        $sql="SELECT ".$options['fields']."
                       FROM $this->table ".
                       $options['where']." ".
                       $options['order']." ".
                       $options['limit'];

        $query = $this->db->query($sql);

        return $query->result_array();
    }

    public function getRow($id)
    {
        $sql = "SELECT *
                FROM $this->table
                WHERE id = $id
                LIMIT 1 ";

        $query = $this->db->query($sql);
        return $query->row();
    }

    public function getField($field, $id)
    {
        $sql = "SELECT $field
                FROM $this->table
                WHERE id = $id
                LIMIT 1 ";

        $query = $this->db->query($sql);
        $array = $query->row();
        return $array->$field;
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->table);
    }



    public function email_client($id='')
    {
        $query = $this->db->query("SELECT (SELECT w.email
                                           FROM `wpanel_users` w
                                           WHERE w.id = p.id_user
                                           LIMIT 1) as email
                                   FROM $this->table  p
                                   WHERE p.id = $id
                                   LIMIT 1");
        $email = $query->row();

        return $email->email;
    }

    public function name_client($id='')
    {
        $query = $this->db->query("SELECT (SELECT CONCAT( w.name, CONCAT(' ', w.last_name ) )
                                           FROM `wpanel_users` w
                                           WHERE w.id = p.id_user
                                           LIMIT 1) as name
                                   FROM $this->table p
                                   WHERE p.id = $id
                                   LIMIT 1");
        $email = $query->row();

        return $email->name;
    }
}
