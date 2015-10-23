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

class service extends CI_Model
{
    private $table;
    private $admin;
    private $current_user;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->table='services';
        $this->current_user=false;
        if ($this->session->userdata('wp-user')) {
            $this->current_user = $this->session->userdata('wp-user');
            $this->admin = $this->current_user['id_profile']==1?true:false;
        }
    }

    public function getPlans($where="", $limit=" LIMIT 3", $full_detail=true)
    {
        $plans = $this->db->query("SELECT
                    				a.id AS id,
                    				a.id_status AS id_status,
                    				a.name AS name,
                    				a.monthly AS month,
                                    a.quarterly AS quarter,
                                    a.semesterly AS semester,
                                    a.yearly AS year,
                                    a.content_id,
                                    (SELECT c.text_small FROM contents c WHERE c.id = a.content_id) AS text_small
                    			FROM $this->table a
                    			$where
                    			ORDER BY id
                    			$limit
                    		");
        $i = 0;
        foreach ($plans->result_array() as $array) { //plans
            $i=$array['id'];
            $result[$i]['id'] = $array['id'];
            $result[$i]['name'] = formatString($array['name']);
            $result[$i]['month'] = numberFormat($array['month'], 2);
            $result[$i]['quarter'] = numberFormat($array['quarter'], 2);
            $result[$i]['semester'] = numberFormat($array['semester'], 2);
            $result[$i]['year'] = numberFormat($array['year'], 2);
            $result[$i]['text_small'] = $array['text_small'];
            $result[$i]['content_id'] = $array['content_id'];
            $details = $this->db->query("SELECT description
                            				FROM ".$this->table."_details
                            				WHERE id_plan = '".$array['id']."'
                            				ORDER BY id
                            				".($full_detail?'':" LIMIT 3")."
                            			");
            $j=0;
            foreach ($details->result_array() as $detail) { //details
                $result[$i]['details'][$j++] = formatString($detail['description']);
            }
            $i++;
        }
        return $result;
    }
    // example "1_3" id=1 period of pay = 3 = quarterly
    public function getPrice($stripe_id)
    {
        $stripe_id = explode('_', $stripe_id);
        $id = $stripe_id[1];
        switch ($stripe_id[1]) {
            case '3':
                $plan='quarterly';
                break;
            case '6':
                $plan='semesterly';
                break;
            case '12':
                $plan='yearly';
                break;
            default:
                $plan='monthly';
                break;
        }

        $sql = "SELECT $plan as price
                FROM $this->table
                WHERE id = '".$stripe_id[0]."'
                LIMIT 1 ";

        $query = $this->db->query($sql);

        return $query->num_rows()? $query->row()->price : false;
    }

    public function get_name($plan)
    {
        $plans = $this->db->query("
			SELECT
				name
			FROM $this->table
			WHERE id = '".$plan."'
		");
        $array = $plans->row();
        return $array->name;
    }

    public function getRows($options =[])
    {
        $defaults = ['fields'=>'*','where'=>'', 'limit' =>'', 'order'=>' ORDER BY name DESC'];

        $options = $options + $defaults;

        $sql="SELECT ".$options['fields']."
                       FROM $this->table ".
                       $options['where']." ".
                       $options['order']." ".
                       $options['limit'];

        $query = $this->db->query($sql);

        return $query->result_array();
    }

    public function getDetails($data = [])
    {
        $defaults =  ['id_plan' => '', 'fields' => '*', 'limit' => ' LIMIT 50', 'order' => ' ORDER BY RAND()'];

        $data = $data + $defaults;

        $query = $this->db->query("
            SELECT ".$data['fields']."

            FROM services_details

            ".($data['id_plan'] != '' ? " WHERE id_plan = '".$data['id_plan']."' " : "")."

            ".$data['order'].' '.$data['limit']
        );
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

    public function getSubscriptions($sub = '')
    {
        $query = $this->db->query("
            SELECT
                b.id AS sub_id,
                b.id_user AS sub_user,
                b.status AS sub_status,
                b.created_at AS sub_created_at,
                b.updated_at AS sub_updated_at,
                b.stripe_id AS sub_stripe_id,
                b.id_service AS sub_id_service,
                (select c.stripe_id from wpanel_users c where c.id = b.id_user) AS user_stripe_id,
                a.id AS id,
                a.name AS name

            FROM services a Join subscriptions b ON a.id = b.id_service

            ".($sub!=''?" WHERE b.id = '".$sub."'":"")."

            ORDER BY b.updated_at DESC
        ");

        return $sub == '' ? $query->result_array() : $query->row();
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
}
