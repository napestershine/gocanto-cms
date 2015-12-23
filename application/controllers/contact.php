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

class contact extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ModelContents');
    }

    public function sent()
    {
        $this->load->library('email');

        $body = '
			<table align="center" cellpadding="0" cellspacing="0" border="0" style="width: 600px; font-size: 12px; font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;font-weight: normal;border: 1px solid #2B7FE9; ">
			<tr>
			<td style="border: 1px solid #2B7FE9;border-bottom: none; background-color: #2B7FE9"><img src="'.base_url().'img/top_mail.png" alt=""></td>
			</tr>
			<tr>
			<td style="padding:10px;border: 1px solid #2B7FE9;border-bottom: none; border-top: none;"><h4>Customer Info</h4></td>
			</tr>
			<tr>
			<td style="padding:10px;border: 1px solid #2B7FE9;border-bottom: none;"><strong>Name:</strong>&nbsp;'.formatString($this->input->post('txtContactName')).'</td>
			</tr>
			<tr>
			<td style="padding:10px;border: 1px solid #2B7FE9;border-bottom: none;"><strong>Email:</strong>&nbsp;'.$this->input->post('txtContactEmail').'</td>
			</tr>
			<tr>
			<td style="padding:10px;border: 1px solid #2B7FE9;border-bottom: none;"><strong>Phone Number:</strong>&nbsp;'.formatString($this->input->post('txtContactTlf')).'</td>
			</tr>
			<tr>
			<td style="padding:10px;border: 1px solid #2B7FE9;border-bottom: none;"><h4>Support Info</h4></td>
			</tr>
			<tr>
			<td style="padding:10px;border: 1px solid #2B7FE9;border-bottom: none;"><strong>Subject:</strong>&nbsp;'.htmlentities(formatString($this->ModelContents->get_reason($this->input->post('cboContactReason'), 'name'), 2)).'</td>
			</tr>
			<tr>
			<td style="padding:10px;border: 1px solid #2B7FE9;border-bottom: none;"><strong>Message</strong>&nbsp;</td>
			</tr>
			<tr>
			<td style="padding:10px;border: 1px solid #2B7FE9;">'.formatString($this->input->post('txtContactMsg'), 2).'</td>
			</tr>
			<tr>
			<td>&nbsp;</td>
			</tr>
			</table>
		';

        $ci = get_instance();
        //_imprimir($ci->config->config['head']);

        $this->email->initialize(emailSetting());
        $this->email->from($ci->config->config['head']['no_reply'][1], $ci->config->config['head']['company']);
        $this->email->to('info@websarrollo.com');
        $this->email->subject(formatString($this->input->post('txtContactName')).' wants to cantact you!');
        $this->email->message($body);

        if (!$this->email->send()) {
            $data = [
                'title'    => 'Error',
                'message'  => 'there was an error when we tried to send the email, try again.',
                'debugger' => '', //$this->email->print_debugger()
            ];
        } else {
            $data = [
                'title'    => 'Thanks for your request!',
                'message'  => 'We have received your message. You will receive a message from us in 24 hours.',
                'out'      => 'ok',
                'url'      => $ci->config->config['head']['domain'].'/content/body/contact-us',
                'debugger' => '', //$this->email->print_debugger()
            ];
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
