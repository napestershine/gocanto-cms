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

class ticket extends CI_Model
{
    private $table;
    private $admin;
    private $current_user;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->table = 'tickets';
        $this->current_user = false;
        if ($this->session->userdata('wp-user')) {
            $this->current_user = $this->session->userdata('wp-user');
            $this->admin = $this->current_user['id_profile'] == 1 ? true : false;
        }
    }

    public function getRows($options)
    {
        $defaults = ['fields' => '*', 'where' => '', 'limit' => '', 'order' => ' ORDER BY datetime DESC'];

        $options = $options + $defaults;

        $sql = 'SELECT '.$options['fields']."
                       FROM $this->table ".
                       $options['where'].' '.
                       $options['order'].' '.
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

    public function can_put_ticket($id_user = '')
    {
        if ($id_user == '') {
            if ($this->admin) {
                return true;
            }
            $id_user = $this->current_user['id'];
        }
        $query = $this->db->query("SELECT id
                                   FROM $this->table
                                   WHERE id_user = $id_user and status = 'Waiting_Suport' and id_ticket is NULL
                                   LIMIT 1");

        return !$query->num_rows();
    }

    public function is_closet($id = '')
    {
        $query = $this->db->query("SELECT id
                                   FROM $this->table
                                   WHERE id = $id and status = 'Closet'
                                   LIMIT 1");

        return $query->num_rows();
    }

    public function was_reopen($id = '')
    {
        $query = $this->db->query("SELECT id
                                   FROM $this->table
                                   WHERE id = $id and status = 'Waiting_Client_Question'
                                   LIMIT 1");

        return $query->num_rows();
    }

    public function is_owner($id = '')
    {
        if ($this->admin) {
            return true;
        }
        if ($id == '') {
            return false;
        }

        $id_user = $this->current_user['id'];

        $query = $this->db->query("SELECT id
                                   FROM $this->table
                                   WHERE id_user = $id_user and id = $id
                                   LIMIT 1");

        return $query->num_rows();
    }

    public function email_owner($id = '')
    {
        $query = $this->db->query("SELECT (SELECT w.email
                                           FROM `wpanel_users` w
                                           WHERE w.id = t.id_user
                                           LIMIT 1) as email
                                   FROM `tickets` t
                                   WHERE t.id = $id
                                   LIMIT 1");
        $email = $query->row();

        return $email->email;
    }

    public function name_owner($id = '')
    {
        $query = $this->db->query("SELECT (SELECT CONCAT( w.name, CONCAT(' ', w.last_name ) )
                                           FROM `wpanel_users` w
                                           WHERE w.id = t.id_user
                                           LIMIT 1) as name
                                   FROM `tickets` t
                                   WHERE t.id = $id
                                   LIMIT 1");
        $email = $query->row();

        return $email->name;
    }
}
