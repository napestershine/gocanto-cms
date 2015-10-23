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

class customers extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_portafolio($arg)
    {
        $options = array('where' => '',
                         'limit' => 30,
                         'order' => 'name');
        $options =  $arg + $options;

        $where = $options['where']!=''? 'WHERE '.$options['where']:'';
        $order = $options['order']!=''? 'ORDER BY '.$options['order']:'';
        $limit = $options['limit']!=''? 'LIMIT '.$options['limit']:'';

        $sql="
			SELECT
				a.id AS id,
				a.id_status AS id_status,
				a.id_type AS id_type,
				(select x.name from customers_type x where x.id=a.id_type) AS type_name,
				a.name AS name,
				a.summary AS summary,
				a.url AS url,
				a.pic AS pic,
				a.date AS date,
				a.language AS language

			FROM customers a
			$where
			$order
			$limit
		";

        $query = $this->db->query($sql);
        return $query->result_array();
    }
}
