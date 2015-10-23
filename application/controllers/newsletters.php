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

class newsletters extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ModelNewsletters');
    }

    public function sent()
    {
        if (trim($this->input->post('txtNewslettersName'))!='' && trim($this->input->post('txtNewslettersEmail'))!='') {
            if (!$this->ModelNewsletters->exists($this->input->post('txtNewslettersEmail'))) {
                $this->ModelNewsletters->insert(0, $this->input->post('txtNewslettersName'), $this->input->post('txtNewslettersEmail'));
                $data = array(
                    'title' => 'Thanks for choosing us!',
                    'message' => 'We have received your subscription successfully.'
                );
            } else {
                $data = array(
                    'title' => 'Error',
                    'message' => 'The email provided is in our records already.'
                );
            }
        } else {
            $data = array(
                'title' => 'Error',
                'message' => 'The information provided is wrong, try again!.'
            );
        }

        echo json_encode($data);
    }
}

/*
    Developed by Gustavo Ocanto
    gustavoocanto@gmail.com
    Version 1.0
    May 2014
    Valencia, Venezuela
*/

