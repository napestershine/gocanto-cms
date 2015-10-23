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

class MY_Loader extends CI_Loader
{
    public function layout($template_name, $vars = array(), $jsLibraries = array())
    {
        //Settings
        $ci = get_instance();
        $vars['config'] = $ci->config->item('head');

        //language
        $ci->session->set_userdata('ws-language', get_language());
        $ci->lang->load('general', $ci->session->userdata('ws-language'));
        $vars['language'] = $ci->lang;

        //Models
        $ci->load->model('ModelContents');
        $ci->load->model('Company');

        //top menu data
        $vars['firstMenuSideBar'] = $ci->ModelContents->getRows(" WHERE type = 'Who_we_are' AND id_status='1' AND id NOT IN ('13', '30')"); //id 13 = Contact

        $vars['secondMenuSideBar'] = $ci->ModelContents->getRows(" WHERE type = 'Why_Us' AND id_status='1'");

        $vars['weOfferMenu'] = $ci->ModelContents->getRows(" WHERE type = 'Our_Products' AND id_status='1'");

        $vars['Terms'] = $ci->ModelContents->getRows(" WHERE type = 'Terms' AND id_status='1'");

        $vars['wp_user']=$ci->session->userdata('wp-user');

        if (isset($vars['wp_user']) && count($vars['wp_user']) > 1) {
            $in = ($vars['wp_user']['id_profile'] != '1') ? ",'17'" : "";
            $vars['wpanelMenu'] = $ci->ModelContents->getRows(" WHERE type = 'Wpanel' AND id NOT IN ('14','15','16','63','64'$in) ");
        }

        $vars['companyInfo'] = $ci->Company->getRow();

        //Body
        $content  = $this->view('partial/header', $vars);
        $content .= $this->view($template_name, $vars);
        $content .= $this->view('partial/sideBar', $vars);

        if (count($jsLibraries)>0) {
            $vars['jsLibraries'] = $jsLibraries;
        }

        $content .= $this->view('partial/footer', $vars);
    }

    public function layout_top($template_name, $vars = array(), $jsLibraries = array())
    {
        //Settings
        $ci = get_instance();
        $vars['config'] = $ci->config->item('head');

        //language
        $ci->session->set_userdata('ws-language', get_language());
        $ci->lang->load('general', $ci->session->userdata('ws-language'));
        $vars['language'] = $ci->lang;

        //Models
        $ci->load->model('ModelContents');
        $ci->load->model('Company');

        //top menu data
        $vars['firstMenuSideBar'] = $ci->ModelContents->getRows(" WHERE type = 'Who_we_are' AND id_status='1' AND id NOT IN ('13', '30')"); //id 13 = Contact

        $vars['secondMenuSideBar'] = $ci->ModelContents->getRows(" WHERE type = 'Why_Us' AND id_status='1'");

        $vars['weOfferMenu'] = $ci->ModelContents->getRows(" WHERE type = 'Our_Products' AND id_status='1'");


        $vars['companyInfo'] = $ci->Company->getRow();

        //Body
        $content  = $this->view('partial/header', $vars);
        $content .= $this->view($template_name, $vars);
    }
}

/*
    Developed by Gustavo Ocanto
    gustavoocanto@gmail.com
    Version 1.0
    May 2014
    Valencia, Venezuela
*/
