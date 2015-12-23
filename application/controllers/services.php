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

class services extends CI_Controller
{
    private $admin;
    private $current_user;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Service', 'Payment', 'Subscription', 'User', 'ModelContents']);
        $this->lang->load('services', $this->session->userdata('ws-language'));
        $this->load->helper(['form', 'url', 'email']);
        $this->load->library(['form_validation', 'stripe', 'email']);
        $this->current_user = false;
        if ($this->session->userdata('wp-user')) {
            $this->current_user = $this->session->userdata('wp-user');
            $this->admin = $this->current_user['id_profile'] == 1 ? true : false;
        }
    }

    public function index()
    {
        $data = ['publishable_key' => $this->stripe->config['publishable_key'],
                 'error'           => $error,
                 'success'         => $success,
                ];

        $this->load->layout('stripeTest', $data, []);
    }

    public function show($id = '')
    {
        if ($id == '') {
            redirect(base_url());
            die();
        } else {
            $service = $this->Service->getRow($id);
            $data = [
                'service'         => $service,
                'details'         => $this->Service->getDetails(['id_plan' => $id]),
                'content'         => $this->ModelContents->getRow($service->content_id),
                'email'           => $this->current_user['email'],
                'publishable_key' => $this->stripe->config['publishable_key'],
            ];

            $this->load->layout('services/show', $data, ['https://checkout.stripe.com/checkout.js', 'stripeEvents.js']);
        }
    }

    /**
     * process
     * This method is responsible of registering and updating customers
     * it will insert and updates users in your system with new
     * information or retrieving the stripe data.
     *
     * @return [type] [description]
     */
    public function process()
    {
        if ($_POST) {

                //simple validation
                if (!isset($_POST['email']) || !isset($_POST['plan']) || !isset($_POST['stripeToken'])) {
                    flash_message('fail_message', '01)'.$this->lang->line('services_process_email_error').$this->lang->line('services_if_still_problem'));
                    redirect(base_url());
                }

            $email = $this->current_user ? $this->current_user['email'] : $_POST['email'];
            $description = 'WSIMPLE CUSTOMER '.$_POST['plan'];
            $amount = $this->Service->getPrice($_POST['plan']);
            $plan = $_POST['plan'];
            $source = $_POST['stripeToken'];
            $client = $this->User->getByEmail($email);

                //plan & email validation
                if (!$amount || !valid_email($email)) {
                    flash_message('fail_message', '02)'.$this->lang->line('services_process_plan_error').$this->lang->line('services_if_still_problem'));
                    redirect(base_url());
                }

                //facebook user without email
                if (!$client && $this->current_user && $email != '') {
                    $userUpdate['email'] = $email;
                    $client = $this->current_user;
                }

                //new customer
                if (!$client) {
                    $options_customer = ['description' => $description,
                                       'email'         => $email,
                                       'source'        => $source, ];

                    $customer = $this->stripe->addCustomer($options_customer);

                    $this->User->insert(['id_status'  => '1',
                                         'id_profile' => '2',
                                         'email'      => $email,
                                         'stripe_id'  => $customer->id,
                                        ]);
                } else {
                    //g-ocanto-com customers

                    //If our customers are not in stripe, we registered them in there and retrieve the stripe object
                    if (!$this->User->getStripeId($client->id)) {
                        $options_customer = [
                            'description' => $description,
                            'email'       => $email,
                            'source'      => $source,
                        ];

                        $customer = $this->stripe->addCustomer($options_customer);
                    } else {
                        //retrieving the stripe object
                        $customer = $this->stripe->getCustomer($this->User->getStripeId($client->id));
                    }

                    $userUpdate['stripe_id'] = $customer->id;
                    $this->User->update($userUpdate, $client->id);
                }

                //selecting service plan
                $options_subscription = ['plan' => $plan]; //, 'trial_end' => 'now'

                //creating stripe suscription
                $subscription = $customer->subscriptions->create($options_subscription);

                //successfully registration
                if ($subscription->status == 'trialing' || $subscription->status == 'active') {
                    $insert_subscription = [
                        'id_user'    => $client->id,
                        'id_service' => $plan,
                        'stripe_id'  => $subscription->id,
                        'status'     => 'active',
                    ];

                    $this->Subscription->insert($insert_subscription);

                    $this->emailsSuccessfullyActivated($email);

                    flash_message('successful_message', $this->lang->line('services_successfully_activated'));
                } else {
                    flash_message('fail_message', '03)'.$this->lang->line('services_process_email_error').$this->lang->line('services_if_still_problem'));
                }
        }

        redirect(base_url());
    }

    //administrative method in process

    public function add()
    {
        if (!isset($this->admin)) {
            redirect(base_url().'wpanel');

            return;
        }
        $data = [];
        $this->load->layout('wpanel/services/add', $data, []);
    }

    //administrative method in process

    public function insert()
    {
        if (!isset($this->admin)) {
            redirect(base_url().'wpanel');

            return;
        }
        if ($this->form_validation->run() === false) {
            $this->add();
        } else {
            $preInsert = [];
            $insert = [];

            foreach ($preInsert as  $key => $value) {
                if (trim($value) != '') {
                    $insert[$key] = $value;
                }
            }

            $this->Service->insert($insert);
            $last = $this->db->insert_id();
            flash_message('successful_message', $this->admin ? $this->lang->line('services_successful_message_admin') : $this->lang->line('services_successful_message'));
            redirect('services');
        }
    }

    /**
     * User services.
     */
    public function mine()
    {
        $data = [
            'services' => $this->Service->getSubscriptions(),
        ];

        $this->load->layout('services/mine', $data, []);
    }

    /**
     * suspend
     * Suspend customer services. It can be triggered by and an admin or an customer.
     *
     * @param string $id, services id
     */
    public function suspend($id = '')
    {
        $subscription = $this->Service->getSubscriptions($id);

        $update = ['status' => 'Suspend'];

        $this->stripe->cancelSubscription($subscription->user_stripe_id, $subscription->sub_stripe_id);

        flash_message('successful_message', 'The Subscription was suspended successfully!');

        redirect(base_url().'services/mine');
    }

    /**
     * reactive
     * Allows the services activation. It can be triggered by and an admin or an customer.
     *
     * @param string $id, id services
     */
    public function reactive($id = '')
    {
        if (!isset($this->admin) || !$this->service->is_owner($id)) {
            redirect(base_url().'wpanel/services');

            return;
        }

        $update = ['status' => 'Active'];

        $this->service->update($update, $id);

        redirect('services/myservice/'.$id);
    }

    /**
     * emailsSuccessfullyActivated
     * Send an activation emails message to the customer.
     *
     * @param string $email, cutomer email
     */
    public function emailsSuccessfullyActivated($email = '')
    {
        $link = base_url().'services/myservices/';

        if ($email != '') {
            $message = $this->lang->line('services_email_message');
            $tittle = $this->lang->line('services_email_tittle');
            $name = $this->lang->line('services_email_tittle');
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

        $this->email->initialize(emailSetting());
        $this->email->from($this->config->config['head']['no_reply'][1], $this->config->config['head']['company']);
        $this->email->to($email);
        $this->email->subject($tittle);
        $this->email->message($body);
        $this->email->send();
    }
}
