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

class seo extends CI_Controller
{
    public function sitemap()
    {
        $data = [['loc' => 'content/body/news','changefreq' => 'daily', 'priority' => '1.0', ],
                 ['loc' => 'services/show/1','changefreq' => 'monthly', 'priority' => '0.5', ],
                 ['loc' => 'services/show/2','changefreq' => 'monthly', 'priority' => '0.5', ],
                 ['loc' => 'services/show/3','changefreq' => 'monthly', 'priority' => '0.5', ],
                 ['loc' => 'sales','changefreq' => 'monthly', 'priority' => '1.0', ],
                 ];
        $this->load->model(['ModelContents']);
        $last_post=$this->ModelContents->getRows(" WHERE type = 'Blog'", " LIMIT 6", 'ORDER BY id DESC');

        foreach ($last_post as $value) {
            $data[]=['loc' => 'content/body/'.$value['id'],'changefreq' => 'daily', 'priority' => '0.8' ];
        }

        header("Content-Type: text/xml;charset=iso-8859-1");

        $this->load->view("sitemap", ['data'=>$data]);
    }
}

/*
    Developed by Gustavo Ocanto
    gustavoocanto@gmail.com
    Version 1.0
    May 2014
    Valencia, Venezuela
*/

