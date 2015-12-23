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

class tickets extends CI_Controller
{
    private $admin;
    private $current_user;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['user', 'Ticket']);
        $this->lang->load('tickets', $this->session->userdata('ws-language'));
        $this->load->helper(['form', 'url']);
        $this->load->library('form_validation');
        $this->current_user = false;
        if ($this->session->userdata('wp-user')) {
            $this->current_user = $this->session->userdata('wp-user');
            $this->admin = $this->current_user['id_profile'] == 1 ? true : false;
        }
    }

    public function index()
    {
        if (!isset($this->admin)) {
            redirect(base_url().'wpanel');

            return;
        }
        if ($this->admin) {
            $options = ['where' => " WHERE  status = 'Waiting_Suport' AND id_ticket IS NULL"];
        } else {
            $options = ['where' => ' WHERE  id_user ='.$this->current_user['id'].' AND id_ticket IS NULL'];
        }

        $data = [
                 'tickets'        => $this->Ticket->getRows($options),
                 'ticket_types'   => enum('tickets', 'type'),
                 'can_put_ticket' => $this->Ticket->can_put_ticket(),
             ];
        $this->load->layout('wpanel/tickets/mytickets', $data, []);
    }

    public function add($type = '')
    {
        if (!isset($this->admin)) {
            redirect(base_url().'wpanel/tickets');

            return;
        }

        $data = [
                 'type'              => $type,
                 'ticket_types'      => enum('tickets', 'type'),
                 'ticket_priorities' => enum('tickets', 'priority'),
                 'can_put_ticket'    => $this->Ticket->can_put_ticket(),
                 'is_closet'         => false,
                 'was_reopen'        => false,
                ];

        $this->load->layout('wpanel/tickets/add', $data, []);
    }

    public function insert()
    {
        if (!isset($this->admin)) {
            redirect(base_url().'wpanel/tickets');

            return;
        }
        if (!$this->admin &&
            $this->input->post('id_dad') != null &&
            !$this->Ticket->is_owner($this->input->post('id_dad'))) {
            redirect(base_url().'wpanel/tickets');

            return;
        }

        $this->form_validation->set_rules('txtMessage', 'Message', 'trim|required|min_length[5]');

        if ($this->input->post('id_dad') == null) {
            $this->form_validation->set_rules('cboPriority', 'Priority', 'required');
            $this->form_validation->set_rules('txtSubject', 'Subject', 'trim|required|min_length[5]');
        }

        if ($this->form_validation->run() === false) {
            if ($this->input->post('id_dad') != '') {
                $this->issues($this->input->post('id_dad'));
            } else {
                $this->add($this->input->post('cboType'));
            }
        } else {
            $preInsert = [
                'id_ticket' => $this->input->post('id_dad') != null ? $this->input->post('id_dad') : '',
                'id_user'   => !$this->admin ? $this->current_user['id'] : '',
                'id_worker' => $this->admin ? $this->current_user['id'] : '',
                'status'    => $this->admin ? 'Waiting_Clients' : 'Waiting_Suport',
                'type'      => $this->input->post('cboType') != null ? $this->input->post('cboType') : '',
                'priority'  => $this->input->post('cboPriority') != null ? $this->input->post('cboPriority') : '',
                'subject'   => $this->input->post('txtSubject') != null ? $this->input->post('txtSubject') : '',
                'message'   => $this->input->post('txtMessage') != null ? $this->input->post('txtMessage') : '',
                'ip'        => $_SERVER['REMOTE_ADDR'],
            ];

            $insert = [];

            foreach ($preInsert as  $key => $value) {
                if (trim($value) != '') {
                    $insert[$key] = $value;
                }
            }

            $this->Ticket->insert($insert);

            $last = $this->db->insert_id();

            flash_message('successful_message', $this->admin ? $this->lang->line('tickets_successful_message_admin') : $this->lang->line('tickets_successful_message'));

            if ($this->input->post('id_dad') != '') {
                $this->email($this->input->post('id_dad'));

                $update = ['status' => $this->admin ? 'Waiting_Clients' : 'Waiting_Suport'];

                $this->Ticket->update($update, $this->input->post('id_dad'));

                redirect('tickets/issues/'.$this->input->post('id_dad'));
            } else {
                $this->email($last);

                redirect('tickets');
            }
        }
    }

    public function issues($id = '')
    {
        if (!isset($this->admin) || !$this->Ticket->is_owner($id)) {
            redirect(base_url().'wpanel');

            return;
        }
        $options = ['fields' => "*,(SELECT CONCAT( wpanel_users.name, CONCAT(  '_', wpanel_users.last_name ) )
                                    FROM  wpanel_users
                                    WHERE id = if(tickets.id_user IS NULL,tickets.id_worker,tickets.id_user)
                                    LIMIT 1) as author",
                    'where' => " WHERE  id = $id OR id_ticket = $id", ];

        $id_creator = $this->Ticket->getField('id_user', $id);

        $data = [
             'tickets'        => $this->Ticket->getRows($options),
             'creator'        => $this->user->getRow($id_creator),
             'id_dad'         => $id,
             'can_put_ticket' => $this->Ticket->can_put_ticket(),
             'is_closet'      => $this->Ticket->is_closet($id),
             'was_reopen'     => $this->Ticket->was_reopen($id),
        ];

        $this->load->layout('wpanel/tickets/issue', $data, []);
    }

    public function close($id = '')
    {
        if (!isset($this->admin) || !$this->Ticket->is_owner($id)) {
            redirect(base_url().'wpanel/tickets');

            return;
        }

        $update = ['status' => 'Closet'];

        $this->Ticket->update($update, $id);

        redirect('tickets');
    }

    public function reopen($id = '')
    {
        if (!isset($this->admin) || !$this->Ticket->is_owner($id)) {
            redirect(base_url().'wpanel/tickets');

            return;
        }

        $update = ['status' => 'Waiting_Client_Question'];

        $this->Ticket->update($update, $id);

        redirect('tickets/issues/'.$id);
    }

    public function email($id = '')
    {
        $link = base_url().'tickets/issues/'.$id;

        $email = $this->Ticket->email_owner($id);

        if ($email != '' || $this->admin) {
            if ($this->admin) {
                // Admin response
                $to_email = $email;
                $message = $this->lang->line('tickets_email_message_user');
                $tittle = $this->lang->line('tickets_email_tittle_user');
                $name = $this->Ticket->name_owner($id);
            } else {
                // User request
                $to_email = $this->config->config['head']['support'][1];
                $message = $this->lang->line('tickets_email_message_admin');
                $tittle = $this->lang->line('tickets_email_tittle_admin');
                $name = $this->config->config['head']['support'][0];
            }
        } else {
            return;
        }

        $content = '
                <table cellpadding="0" cellspacing="0" border="0" style="width: 100%;  font-size: 14px">
                <tr>
                <td style="padding:10px 0">'.$tittle.'</td>
                </tr>
                <tr>
                <td style="padding:10px 0">'.$message.'</td>
                </tr>
                <tr>
                <td style="padding:10px 0"><a href="'.$link.'">'.$link.'</a></td>
                </tr>
                </table>
            ';

        $body = $this->load->view(
            'partial/email',
            [
                'config'   => $this->config->config['head'],
                'language' => $this->session->userdata('ws-language'),
                'title'    => $tittle,
                'name'     => $name,
                'content'  => $content,
            ],
            true
        );

        $this->load->library('email');
        $this->email->initialize(emailSetting());
        $this->email->from($this->config->config['head']['no_reply'][1], $this->config->config['head']['company']);
        $this->email->to($to_email);
        $this->email->subject($tittle);
        $this->email->message($body);
        $this->email->send();
    }
}
