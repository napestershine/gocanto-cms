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

class modelcontents extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getRows($where = '', $limit = '', $order = ' ORDER BY sequence')
    {
        $query = $this->db->query("SELECT *, DATE_FORMAT(date, '%Y-%m-%dT%H:%i:%s0Z') as dateiso FROM contents $where $order $limit");

        return $query->result_array();
    }

    public function getRow($content)
    {
        $query = $this->db->query("SELECT *, DATE_FORMAT(date, '%Y-%m-%dT%H:%i:%s0Z') as dateiso FROM contents ".$this->get_where($content).' LIMIT 1 ');

        return $query->row();
    }

    public function getField($field, $content)
    {
        $query = $this->db->query("SELECT $field FROM contents ".$this->get_where($content).' LIMIT 1 ');
        $array = $query->row();

        return $array->$field;
    }

    public function get_reasons($id)
    {
        $query = $this->db->query("SELECT * FROM content_reason WHERE id_content = '".$id."' ORDER BY id");

        return $query->result_array();
    }

    public function get_status($id)
    {
        $query = $this->db->query('SELECT id_status FROM contents WHERE id = '.$id);
        $status = $query->row();

        return $status->id_status;
    }

    public function get_reason($id, $field)
    {
        $query = $this->db->query("SELECT $field FROM content_reason WHERE id = '".$id."' LIMIT 1 ");
        $array = $query->row();

        return $array->$field;
    }

    public function get_types($where = '')
    {
        $query = $this->db->query("SELECT * FROM content_type $where ORDER BY id");

        return $query->result_array();
    }

    public function get_joined_types()
    {
        $query = $this->db->query('
			SELECT a.id AS id, a.name AS name
			FROM content_type a JOIN contents b ON a.id = b.id_type
			GROUP BY a.id
			ORDER BY a.id
		');

        return $query->result_array();
    }

    private function get_where($content)
    {
        if (is_numeric($content)) {
            $where = " WHERE id = '".$content."' ";
        } elseif (is_string($content)) {
            $where = " WHERE LOWER(title) LIKE '".str_replace('-', ' ', utf8_decode($content))."' ";
        }

        return $where;
    }

    public function record_count($type)
    {
        $query = $this->db->query("
            SELECT COUNT(*) AS num
            FROM contents
            WHERE type LIKE '".$type."'
        ");
        $row = $query->row();

        return $row->num;
    }

    public function fetch_contents($type, $limit, $start)
    {
        $query = $this->db->query("
            SELECT id, title, image, body, date
            FROM contents
            WHERE type LIKE '".$type."'
            ORDER BY id DESC
            LIMIT $start, $limit
        ");

        return $query->result_array();
    }

    public function insert($data)
    {
        return $this->db->insert('contents', $data) ? 1 : 0;
    }

    public function update($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('contents', $data);
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('contents');
    }
}
