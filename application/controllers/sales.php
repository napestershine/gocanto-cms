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

class sales extends CI_Controller
{
    private $data;
    //private $language;

    public function __construct()
    {
        parent::__construct();
        $this->data = [];
        $this->load->model('ModelContents');
    }

    //home page

    public function index()
    {
        $this->data = [
            'blogBox'  => 1,
            'blogList' => $this->ModelContents->getRows(" WHERE type = 'Blog' AND id_status = '1' ", ' LIMIT 6', ' ORDER BY id DESC'),
            'index'    => '1',
        ];

        //wpanel session
        if ($this->session->userdata('wp-user')) {
            $this->data['wp_user'] = $this->session->userdata('wp-user');
        }

        $this->load->layout_top('sales', $this->data);
    }
}

/*
    Developed by Gustavo Ocanto
    gustavoocanto@gmail.com
    Version 1.0
    May 2014
    Valencia, Venezuela
*/
