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

class wpanel extends CI_Controller
{
    private $data;
    private $main_page;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['ModelContents', 'user']);
        $this->lang->load('login', $this->session->userdata('ws-language'));
        $this->lang->load('passAssistance', $this->session->userdata('ws-language'));
        $this->data = array();
        $this->main_page = 'my-products';
        $this->load->library('facebook/facebook');
    }

    public function index()
    {
        $this->access();
    }

    public function login($email='', $pass='')
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('txtLogin', $this->lang->line('login_signup_frm_email'), 'required');
        $this->form_validation->set_rules('txtPass', $this->lang->line('login_pass_label'), 'required');

        if ($this->form_validation->run() == false && !$this->facebook->session) {
            $data = [
                'title' => $this->lang->line('login_validation_title'),
                'message' => $this->lang->line('login_validation_msg'),
                'label_button' =>  $this->lang->line('login_button_label')
            ];

            echo json_encode($data);
        } else {
            if ($this->facebook->session) {
                $user = $this->login_fb();
            } elseif ($email!='' && $pass!='') {
                $user = $this->user->get_user($email, $pass);
            } elseif ($this->input->post('txtLogin') !== null && $this->input->post('txtPass')!== null) {
                $user = $this->user->get_user($this->input->post('txtLogin'), $this->input->post('txtPass'));
            }

            if ($user===0) {
                $data = array(
                    'title' => $this->lang->line('login_error_dialog_title'),
                    'message' => $this->lang->line('login_error_dialog_message'),
                    'label_button' =>  $this->lang->line('login_button_label')
                );
            } else {
                $this->session->set_userdata('wp-user', array(
                    'id' => $user->id,
                    'id_status' => $user->id_status,
                    'id_profile' => $user->id_profile,
                    'name' => $user->name,
                    'email' => $user->email,
                    'pass' => $user->password
                ));

                $data = array(
                    'title' => 'ok',
                    'message' => 'ok',
                    'url' => base_url().'content/body/'.$this->main_page
                );
            }

            if ($this->facebook->session) {
                redirect(base_url().'content/body/'.$this->main_page);
            } else {
                echo json_encode($data);
            }
        }
    }

    public function login_fb($value='')
    {
        $user_fb = $this->facebook->get_user();

        if (empty($user_fb['email'])) {
            $user_fb['email']='';
        }

        if ($this->user->existsFbId($user_fb['id'])||
           $this->user->exists($user_fb['email'])) {
            $user = $this->user->getByEmail($user_fb['email']);
            if ($user===0) {
                $user = $this->user->getByFbId($user_fb['id']);
            }

            $this->user->update(
                    array(
                        'id_status' => '1',
                        'name' => $user_fb['first_name'],
                        'last_name' => $user_fb['last_name'],
                        'email' => $user_fb['email'],
                        'fb_id' => $user_fb['id'],
                        'gender' => $user_fb['gender'],
                        'locale' => $user_fb['locale'],
                        // 'country' => $this->input->post('txtContactCountry'),
                        // 'state' => $this->input->post('txtContactState'),
                        // 'city' => $this->input->post('txtContactCity'),
                        // 'zip' => $this->input->post('txtContactZip')
                    ),
                    $user->id
                );

            $user = $this->user->getByEmail($user->email);
        } else {
            $this->user->insert(
                    array(
                        'id_status' => '1',
                        'id_profile' => '2',
                        'name' => $user_fb['first_name'],
                        'last_name' => $user_fb['last_name'],
                        'email' => $user_fb['email'],
                        'fb_id' => $user_fb['id'],
                        'gender' => $user_fb['gender'],
                        'locale' => $user_fb['locale'],
                        // 'address' => $this->input->post('txtContactAddress'),
                        // 'country' => $this->input->post('txtContactCountry'),
                        // 'state' => $this->input->post('txtContactState'),
                        // 'city' => $this->input->post('txtContactCity'),
                        // 'zip' => $this->input->post('txtContactZip')
                    )
                );
            $user = $this->user->getByEmail($user_fb['email']);
        }
        return  $user;
    }

    public function logout()
    {
        $this->session->sess_destroy();
        $this->access();
    }

    public function access($ref='')
    {
        if ($this->session->userdata('wp-user')) {
            redirect(base_url().'content/body/'.$this->main_page);
        } else {
            $body = $this->ModelContents->getRow('my-account-login');
            $this->data = array(
                'content' => $body,
                'blogBox' => 1,
                'blogList' => $this->ModelContents->getRows(" WHERE type = 'Blog' AND id_status = '1' ", " LIMIT 6", " ORDER BY id DESC"),
                'ref' => $ref,
                'facebook_login_url' => $this->facebook->login_url(),
            );
            $this->load->layout($body->body, $this->data, explode('-', $body->jsLibraries));
        }
    }

    public function forgotPass()
    {
        $this->load->library('email');
        $this->lang->load('emails', $this->session->userdata('ws-language'));

        $user = $this->user->exists($this->input->post('mailForgot'), 'id, name, last_name, email');

        if (!$user) {
            $data = [
                'out' => 'notOk',
                'title' => $this->lang->line('login_forgot_error_title'),
                'message' => $this->lang->line('login_forgot_error_message'),
                'class' => 'alert',
                'title_class' => 'alert-box-title',
                'debug' => ''//$this->email->print_debugger()
            ];
        } else {
            $token = md5($user->id.'_'.$user->email.'_'.$user->id);
            $link = base_url().'wpanel/resetPass/'.$token;

            $content = '
                <table cellpadding="0" cellspacing="0" border="0" style="width: 100%;  font-size: 14px">
                <tr>
                <td style="padding:10px 0">'.$this->lang->line('email_reset_msg01').'</td>
                </tr>
                <tr>
                <td style="padding:10px 0">'.$this->lang->line('email_reset_msg02').'</td>
                </tr>
                <tr>
                <td style="padding:10px 0"><a href="'.$link.'">'.$link.'</a></td>
                </tr>
                </table>
            ';

            $body = $this->load->view(
                'partial/email',
                [
                    'config' => $this->config->config['head'],
                    'language' => $this->session->userdata('ws-language'),
                    'title' => $this->lang->line('login_forgot_title'),
                    'name' => formatString($user->name.' '.$user->last_name),
                    'content' => $content
                ],
                true
            );

            $this->email->initialize(emailSetting());
            $this->email->from($this->config->config['head']['no_reply'][1], $this->config->config['head']['company']);
            $this->email->to($user->email);
            $this->email->subject($this->lang->line('login_forgot_title'));
            $this->email->message($body);

            if (!$this->email->send()) {
                $data = [
                    'out' => 'notOk',
                    'title' => $this->lang->line('login_forgot_title_error_sending_email'),
                    'message' => str_replace('[here]', '<a href="'.base_url().'content/body/contact-us" style="color:#FFF; text-decoration: underline;">'.$this->lang->line('reset_here_label').'</a>', $this->lang->line('login_forgot_msg_error_sending_email')),
                    'class' => 'alert',
                    'title_class' => 'alert-box-title',
                    'debugger' => ''//$this->email->print_debugger()
                ];
            } else {
                $data = [
                    'out' => 'ok',
                    'title' => str_replace('[email]', $user->email, $this->lang->line('login_forgot_ok_title')),
                    'message' => $this->lang->line('login_forgot_ok_message'),
                    'class' => 'success',
                    'title_class' => 'success-box-title'
                ];
            }
        }

        echo json_encode($data);
    }

    public function resetPass($token = '')
    {
        $body = $this->ModelContents->getRow(63);
        $user = $this->user->is_token($token);

        $this->data = array(
            'content' => $body,
            'user' => is_object($user) ? $user : ['error_title' => $this->lang->line('passAss_reset_token_error_title'), 'error_msg' => str_replace('[here]', '<a target="_blank" href="'.base_url().'content/body/contact-us" style="color:#FFF; text-decoration: underline;">'.$this->lang->line('reset_here_label').'</a>', $this->lang->line('passAss_reset_token_error_msg'))],
            'blogBox' => 1,
            'blogList' => $this->ModelContents->getRows(" WHERE type = 'Blog' AND id_status = '1' ", " LIMIT 6", " ORDER BY id DESC")
        );

        $this->load->helper('form');
        $this->load->layout($body->body, $this->data, explode('-', $body->jsLibraries));
    }

    public function updatePass()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('txtPass1', $this->lang->line('passAss_reset_new_pass_label_01'), 'required');
        $this->form_validation->set_rules('txtPass2', $this->lang->line('passAss_reset_new_pass_label_02'), 'required');
        $this->form_validation->set_rules('token', 'token', 'required');

        if ($this->form_validation->run() == false) {
            $data = [
                'out' => 'notOk',
                'title' => $this->lang->line('passAss_reset_validation_title'),
                'message' => $this->lang->line('passAss_reset_validation_msg'),
            ];
        } else {
            $user = $this->user->is_token($this->input->post('token'));

            if (is_object($user)) {
                $this->user->update(['password' => $this->input->post('txtPass1')], $user->id);
                $data = [
                    'out' => 'ok',
                    'title' => $this->lang->line('passAss_reset_change_ok_title'),
                    'message' => $this->lang->line('passAss_reset_change_ok_msg'),
                    'url' => base_url().'wpanel'
                ];
            } else {
                $data = [
                    'out' => 'notOk',
                    'title' => $this->lang->line('passAss_reset_validation_title'),
                    'message' => str_replace('[here]', '<a target="_blank" href="'.base_url().'content/body/contact-us" style="text-decoration: underline;">'.$this->lang->line('reset_here_label').'</a>', $this->lang->line('passAss_reset_token_error_msg')),
                ];
            }
        }

        echo json_encode($data);
    }

    public function signUp()
    {
        $this->lang->load('signUp', $this->session->userdata('ws-language'));
        $body = $this->ModelContents->getRow(64);

        $this->data = array(
            'content' => $body,
            'blogBox' => 1,
            'blogList' => $this->ModelContents->getRows(" WHERE type = 'Blog' AND id_status = '1' ", " LIMIT 6", " ORDER BY id DESC")
        );

        $this->load->helper('form');
        $this->load->layout($body->body, $this->data, explode('-', $body->jsLibraries));
    }

    public function processSignUp()
    {
        $this->lang->load('signUp', $this->session->userdata('ws-language'));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('txtName', $this->lang->line('signup_frm_name_error'), 'required');
        $this->form_validation->set_rules('txtLastName', $this->lang->line('signup_frm_lastname_error'), 'required');
        $this->form_validation->set_rules('txtEmail', $this->lang->line('signup_frm_email_error'), 'required');
        $this->form_validation->set_rules('txtPass01', $this->lang->line('signup_frm_phone_error'), 'required');

        if ($this->form_validation->run() == false) {
            $this->data = [
                'out' => '0',
                'title' => $this->lang->line('signup_validation_title'),
                'message' => $this->lang->line('signup_validation_msg'),
            ];
        } else {
            if ($this->user->exists($this->input->post('txtEmail'))) {
                $this->data = [
                    'title' => $this->lang->line('signup_title_error'),
                    'message' => $this->lang->line('signup_message_error'),
                    'out' => '0'
                ];
            } else {
                $this->user->insert([
                        'id_status' => '1',
                        'id_profile' => '2',
                        'name' => $this->input->post('txtName'),
                        'last_name' => $this->input->post('txtLastName'),
                        'phone' => $this->input->post('txtPhone'),
                        'email' => $this->input->post('txtEmail'),
                        'password' => $this->input->post('txtPass01')
                ]);

                $this->data = [
                    'title' => $this->lang->line('signup_title_success'),
                    'message' => $this->lang->line('signup_message_success'),
                    'out' => 'ok',
                    'url' => base_url().'wpanel'
                ];
            }
        }

        $this->data['label_button'] = $this->lang->line('signup_frm_signup');
        echo json_encode($this->data);
    }
}
