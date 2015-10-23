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

class whois extends CI_Model
{
    private $servers;
    private $out;
    private $error_number;
    private $error;
    private $available;
    private $tld_domain;
    private $domain;

    public function __construct()
    {
        parent::__construct();
        $this->servers = $this->get_servers();
        $this->out = '';
        $this->error_number = '';
        $this->error = '';
        $this->available = 0;
        $this->tld_domain = '';
    }

    public function get_out()
    {
        return $this->out;
    }

    public function get_error()
    {
        switch ($this->error_number) {
            case '1':
                return 'El dominio solictado no esta disponible';
            break;

            case '2':
                return 'El dominio suministrado es invalido';
            break;

            case '3':
                return 'Error de conexi&oacute;n, Intente de nuevo';
            break;

            case '4':
                return 'Servidor no apropiado para el dominio indicado, Intente de nuevo';
            break;
        }
    }

    public function get_available()
    {
        return $this->available;
    }

    public function get_tld_domain()
    {
        return '.'.$this->tld_domain;
    }

    public function get_domain()
    {
        return $this->domain;
    }

    public function lookup($domain)
    {
        $domain = trim(formatString($domain, 3)); //remove space from start and end of domain

        $aux = explode('.', $domain);

        if (end($aux)=='ve') {
            $this->nic_ve($domain);
            $this->tld_domain = $aux[count($aux)-2].'.'.array_pop($aux);
            return;
        }

        $domain = empty($aux[1]) ? $domain.'.com' : $domain; //if the domain does not have type we put it

        if (substr(strtolower($domain), 0, 7) == "http://") {
            $domain = substr($domain, 7);
        } // remove http:// if included

        if (substr(strtolower($domain), 0, 4) == "www.") {
            $domain = substr($domain, 4);
        }//remove www from domain

        if (preg_match("/^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/", $domain)) {
            $this->out = $this->queryWhois("whois.lacnic.net", $domain);
        } elseif (preg_match("/^([-a-z0-9]{2,100})\.([a-z\.]{2,8})$/i", $domain)) {
            $domain_parts = explode(".", $domain);
            $this->tld_domain = $tld = strtolower(array_pop($domain_parts));
            $server = $this->servers[$tld][0];

            if (!$server) {
                $this->error_number = 4;
                //echo "Error: No appropriate Whois server found for $domain domain!";
            }

            $this->out = $this->queryWhois($server, $domain);

            while (preg_match_all("/Whois Server: (.*)/", $this->out, $matches)) {
                $server=array_pop($matches[1]);
                $this->out = $this->queryWhois($server, $domain);
            }
            //return $res;
        } else {
            $this->error_number = 2;
            //return "Invalid Input";
        }
        $this->domain = $domain;
        $this->available = preg_match('/No match for/', $this->out, $info) ? 1 : 0;
    }

    private function nic_ve($domain)
    {
        $url = 'https://registro.nic.ve/modules/whois?query='.$domain;
        $page = file_get_contents($url);
        $pattern = '/No match for/';
        $start = strpos($page, '<pre>') + 5;
        $end  = strpos($page, '</pre>');

        if (preg_match($pattern, $page, $info_ve)) {
            $this->available = 1;
        } else {
            $this->available = 0;
            $this->error_number = 1;
        }
        $this->out = substr($page, $start, $end-$start);
    }

    private function get_servers()
    {
        $array = array();
        $plans = $this->db->query("
			SELECT
				id,
				name
			FROM services_plans
			WHERE id_service = '2'
			ORDER BY id
		");
        foreach ($plans->result_array() as $p) { //plans
            $s_whois = $this->db->query("
				SELECT server
				FROM whois_server
				WHERE id_plan = '".$p['id']."'
				ORDER BY id
			");
            $i=0;
            foreach ($s_whois->result_array() as $whois) {
                $array[str_replace('.', '', $p['name'])][$i++] = $whois['server'];
            }
        }//plans
        return $array;
    }

    private function queryWhois($server, $domain)
    {
        if (@fsockopen($server, 43, $errno, $errstr, 20)) {
            $fp = @fsockopen($server, 43, $errno, $errstr, 20); // or die("Socket Error " . $errno . " - " . $errstr);

            if ($server=="whois.verisign-grs.com") {
                $domain="=".$domain;
            }

            fputs($fp, $domain . "\r\n");
            $out = "";
            while (!feof($fp)) {
                $out .= fgets($fp);
            }

            fclose($fp);

            return $out;
        } else {
            $this->error_number = 3;
        }
    }
}
