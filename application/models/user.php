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

class user extends CI_Model
{
    private $last_id;
    private $table;
    private $admin;
    private $current_user;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->last_id = '';
        $this->table = 'wpanel_users';
        $this->current_user = false;
        if ($this->session->userdata('wp-user')) {
            $this->current_user = $this->session->userdata('wp-user');
            $this->admin = $this->current_user['id_profile'] == 1 ? true : false;
        }
    }

    public function getRow($id = '')
    {
        if ($id == '') {
            $id = $this->current_user['id'];
        }

        $query = $this->db->query("SELECT * FROM $this->table WHERE id = '".$id."' LIMIT 1 ");

        return $query->row();
    }

    public function get($id = '')
    {
        return $this->getRow($id);
    }

    public function getId()
    {
        return $this->current_user['id'];
    }

    public function exists($email, $select = '')
    {
        if ($select == '') {
            $select = 'email';
        }

        $query = $this->db->query("SELECT $select
                        			FROM $this->table
                        			WHERE email LIKE '$email'
                        		");

        return !$query->num_rows() ? false : $query->row();
    }

    public function is_token($token)
    {
        $query = $this->db->query("SELECT
                                        id,
                                        concat(name, ' ', last_name) AS name,
                                        md5(concat(id, '_', email, '_', id)) AS token

                                    FROM $this->table
                                    WHERE md5(concat(id, '_', email, '_', id)) = '$token'");

        return $query->num_rows() ? $query->row() : false;
    }

    public function existsFbId($fb_id)
    {
        $query = $this->db->query("SELECT email
                                    FROM $this->table
                                    WHERE fb_id LIKE '$fb_id'
                                ");

        return $query->num_rows() ? true : false;
    }

    public function get_user($login, $pass)
    {
        $query = $this->db->query("SELECT *
                        			FROM $this->table
                        			WHERE email LIKE '$login' AND password = '$pass'
                        			LIMIT 1
                        		");

        return $query->num_rows() ? $query->row() : false;
    }

    public function getByEmail($email)
    {
        $query = $this->db->query("SELECT *
                                    FROM $this->table
                                    WHERE email LIKE '$email'
                                    LIMIT 1
                                ");

        return $query->num_rows() ? $query->row() : false;
    }

    public function getByFbId($fb_id)
    {
        $query = $this->db->query("SELECT *
                                    FROM $this->table
                                    WHERE fb_id LIKE '$fb_id'
                                    LIMIT 1
                                ");

        return $query->num_rows() ? $query->row() : false;
    }

    public function getStripeIdByEmail($email)
    {
        $query = $this->db->query("SELECT stripe_id
                                    FROM $this->table
                                    WHERE email LIKE '$email'
                                    LIMIT 1
                                ");

        return $query->num_rows() ? $query->row()->stripe_id : false;
    }

    public function getStripeId($id)
    {
        if ($id == '') {
            $id = $this->current_user['id'];
        }
        $query = $this->db->query("SELECT stripe_id
                                    FROM $this->table
                                    WHERE id LIKE '$id'
                                    LIMIT 1
                                ");

        return $query->num_rows() ? $query->row()->stripe_id : false;
    }

    public function insert($array)
    {
        $this->db->insert($this->table, $array);

        return $this->last_id = $this->db->insert_id();
    }

    public function update($array, $id = '')
    {
        if ($id == '') {
            $id = $this->current_user['id'];
        }
        $this->db->where('id', $id);
        $this->db->update($this->table, $array);
    }

    public function get_last_id()
    {
        return $this->last_id;
    }

    public function get_field($field, $where)
    {
        $query = $this->db->query("SELECT $field
                                   FROM $this->table $where
                                   LIMIT 1 ");
        $array = $query->row();

        return $array->$field;
    }

    public function full_name($id)
    {
        if ($id == '') {
            $id = $this->current_user['id'];
        }
        $query = $this->db->query("SELECT name, last_name
                                   FROM $this->table
                                   WHERE id = '$id'
                                   LIMIT 1 ");
        $array = $query->row();

        return $array->first_name.' '.$array->last_name;
    }
}
