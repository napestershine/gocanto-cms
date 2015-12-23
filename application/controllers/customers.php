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

class customers extends CI_Controller
{
    private $data;

    public function __construct()
    {
        parent::__construct();
        $this->lang->load('login', $this->session->userdata('ws-language'));
        $this->load->model('user');
        $this->data = [];
    }

    public function index()
    {
    }

    public function update()
    {
        $sql = [
                'name'      => $this->input->post('txtContactName'),
                'last_name' => $this->input->post('txtContactLastName'),
                'phone'     => $this->input->post('txtContactTlf'),
                'password'  => $this->input->post('txtContactPass'),
                'address'   => $this->input->post('txtContactAddress'),
                'country'   => $this->input->post('txtContactCountry'),
                'state'     => $this->input->post('txtContactState'),
                'city'      => $this->input->post('txtContactCity'),
                'zip'       => $this->input->post('txtContactZip'),
        ];

        if (!$this->user->exists($this->input->post('txtContactEmail'))) {
            $sql['email'] = $this->input->post('txtContactEmail');
        }

        $this->user->update($sql, $this->user->getId());

        $this->data = [
            'title'   => $this->lang->line('login_signup_title_success'),
            'message' => $this->lang->line('login_profileupdate_success'),
            'out'     => '1',
            'url'     => base_url().'index.php/content/body/my-profile',
        ];

        $this->data['label_button'] = $this->lang->line('login_profileupdate_btn_update');
        echo json_encode($this->data);
    }
}

/*
    Developed by Gustavo Ocanto
    gustavoocanto@gmail.com
    Version 1.0
    May 2014
    Valencia, Venezuela
*/
