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

if (!function_exists('formatString')) {
    function formatString($st, $type=1)
    {
        switch ($type) {
            case 1:return ucwords($st);break;
            case 2:return ucfirst($st);break;
            case 3:return strtolower($st);break;
            case 4:return strtoupper($st);break;
        }
    }
}

if (!function_exists('formatDate')) {
    function formatDate($date, $type=1)
    {
        switch ($type) {
            case 1: $format = 'F j, Y'; break; // - November 6, 2010
            case 2: $format = 'F j, Y g:i a'; break; // - November 6, 2010 12:50 am
            case 3: $format = 'F, Y'; break; // - November, 2010
        }
        return date($format, strtotime($date));
    }
}

if (!function_exists('_imprimir')) {
    function _imprimir($array='', $die=false)
    {
        if ($array=='') {
            $array=$_REQUEST;
        }
        echo '<pre>';
        print_r($array);
        echo '</pre>';
        if ($die) {
            die();
        }
    }
}

if (!function_exists('getPosSplit')) {
    function getPosSplit($st, $pos=0, $char='.')
    {
        $array = explode($char, $st);
        return $array[$pos];
    }
}

if (!function_exists('numberFormat')) {
    function numberFormat($num, $type=1)
    {
        switch ($type) {
            case 1:
                return number_format($num, 2, ',', '.');
            break;
            case 2:
                return number_format($num, 2, '.', ',');
            break;
        }
    }
}

if (!function_exists('showDate')) {
    function showDate($date)
    {
        $date = explode('-', $date);
        return $date[2].' / '.$date[1].' / '.$date[0];
    }
}

if (!function_exists('emailSetting')) {
    function emailSetting()
    {
        $config['protocol'] = 'mail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = true;
        $config['mailtype'] = 'html';
        $config['priority'] = 5;
        $config['charset'] = 'utf-8';

        return $config;
    }
}

if (!function_exists('paginationSetting')) {
    function paginationSetting($data)
    {
        //controller
        $config['base_url'] = $data['base_url'];
        $config['total_rows'] = $data['total_rows'];
        $config['per_page'] = $data['per_page'];
        $config["uri_segment"] = $data['uri_segment'];
        $config["num_links"] = round($config["total_rows"] / $config["per_page"]);

        //style
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li class="arrow">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li class="arrow">';
        $config['next_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="current"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['first_link'] = '&lt;&lt;';
        $config['last_link'] = '&gt;&gt;';

        return $config;
    }
}

if (!function_exists('comments')) {
    function comments($shortname)
    {
        return "
            <div id=\"disqus_thread\"></div>
            <script type=\"text/javascript\">
            /* * * CONFIGURATION VARIABLES * * */
            var disqus_shortname = '".$shortname."';

            /* * * DON'T EDIT BELOW THIS LINE * * */
            (function() {
            var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
            dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
            })();
            </script>
            <noscript>Please enable JavaScript to view the <a href=\"https://disqus.com/?ref_noscript\" rel=\"nofollow\">comments powered by Disqus.</a></noscript>
		";
    }
}

if (!function_exists('getCkEditorToolbar')) {
    function getCkEditorToolbar($advanced=false)
    {
        $insert = "
			{
				name: 'insert',
				items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ]
			},
		";

        return "
			{
				name: 'document', groups: [ 'mode', 'document', 'doctools' ],
				items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ]
			},
			{
				name: 'clipboard', groups: [ 'clipboard', 'undo' ],
				items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ]
			},
			{
				name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ],
				items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ]
			},
			{
				name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ]
			},
			{
				name: 'tools',
				items: [ 'Maximize', 'ShowBlocks' ]
			},
			'/',
			{
				name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ],
				items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ]
			},
			{
				name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ],
				items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ]
			},
			{
				name: 'colors',
				items: [ 'TextColor', 'BGColor' ]
			},
			'/',

			".($advanced?$insert:'')."

			{
				name: 'styles',
				items: [ 'Styles', 'Format', 'Font', 'FontSize' ]
			}
		";
    }
}

if (!function_exists('new_directory')) {
    function new_directory($path)
    {
        if (!is_dir($path)) {
            $old=umask(0);
            mkdir($path, 0777);
            umask($old);
            $fp=fopen($path.'index.html', 'w');
            fclose($fp);
        }
    }
}

if (!function_exists('upload_file')) {
    function upload_file($path, $file, &$error, &$photo)
    {
        $ci = get_instance();
        $config['upload_path'] = $path;
        $config['allowed_types'] = 'gif|jpg|png|pdf';
        // $config['max_size']	= '100';
        // $config['max_width']  = '1024';
        // $config['max_height']  = '768';
        $config['overwrite']  = true;
        $config['file_name']  = md5(mt_rand(1, 9999999)*microtime());

        $ci->load->library('upload', $config);
        $ci->upload->initialize($config);

        $photo = array();

        try {
            if ($ci->upload->do_upload($file)) {
                $photo = $ci->upload->data();
            } else {
                $error = $ci->upload->display_errors('', '');
            }
        } catch (Exception $e) {
            $error = $ci->upload->display_errors('', '').', Exception: '.$e;
        }

        return count($photo) > 0 ? true : false;
    }
}

if (!function_exists('resize_image')) {
    function resize_image($image, $width, $height=0)
    {
        $ci = get_instance();
        $img_nueva_anchura = $width;
        $img_nueva_altura = $height;

        list($img_original_anchura, $img_original_altura) = getimagesize($image);

        if ($img_original_anchura > $img_nueva_anchura && $img_nueva_anchura > 0) {
            $percent = (double)(($img_nueva_anchura * 100) / $img_original_anchura);
        }

        if ($img_original_anchura <= $img_nueva_anchura) {
            $percent = 100;
        }

        if (floor(($img_original_altura * $percent)/100) > $img_nueva_altura && $img_nueva_altura > 0) {
            $percent = (double)(($img_nueva_altura * 100) / $img_original_altura);
        }

        $img_nueva_anchura = ($img_original_anchura*$percent)/100;
        $img_nueva_altura = ($img_original_altura*$percent)/100;

        $config['image_library'] = 'gd2';
        $config['source_image']    = $image;
        $config['create_thumb'] = false;
        $config['maintain_ratio'] = false;
        $config['width'] = intval($img_nueva_anchura);
        $config['height'] = intval($img_nueva_altura);
        $config['quality'] = '100%';

        $ci->load->library('image_lib', $config);
        $ci->image_lib->resize();

        $ci->image_lib->clear();
    }
}

if (!function_exists('get_language')) {
    function get_language($print=false)
    {
        return 'english';
        if ($print) {
            _imprimir($_SERVER["HTTP_ACCEPT_LANGUAGE"]);
        }

        switch (substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2)) {
            case 'en':
                return 'english';
            break;

            case 'es':
                return 'spanish';
            break;

            default:
                return 'english';
            break;
        }
    }
}

if (!function_exists('postLimit')) {
    function postLimit($post, $limit=100)
    {
        $array = explode(' ', $post);
        $out = '';
        for ($i=0; $i<count($array) && $i<=$limit; $i++) {
            $out .= $array[$i].' ';
        }
        $out = rtrim($out, ', ');
        return rtrim($out, ' ');
    }
}

if (!function_exists('stripEvents')) {
    function stripEvents($data = [])
    {
        $ci = get_instance();
        $ci->load->helper('file');

        $content = "
                    var handler = StripeCheckout.configure({
                        key: '".$data['config']['publishable_key']."',
                        image: '".$data['config']['image']."',
                        token: function(token) {
                            $('#process_form .stripeToken').val(token.id);
                            $('#process_form .email').val(token.email);
                            $('#process_form').submit();
                        }
                    });
                ";

         /* token object

         {"id":"tok_16NUmSJ9fq2HBXMOqQ8dgS4k",
          "livemode":false,
          "created":1436647264,
          "used":false,
          "object":"token",
          "type":"card",
          "card":{"id":"card_16NUmSJ9fq2HBXMOlP4IKw1X",
                  "object":"card",
                  "last4":"4242",
                  "brand":"Visa",
                  "funding":"credit",
                  "exp_month":12,
                  "exp_year":2016,
                  "country":"US",
                  "name":"gustavoocanto@gmail.com",
                  "address_line1":null,
                  "address_line2":null,
                  "address_city":null,
                  "address_state":null,
                  "address_zip":null,
                  "address_country":null,
                  "cvc_check":null,
                  "address_line1_check":null,
                  "address_zip_check":null,
                  "tokenization_method":null,
                  "dynamic_last4":null,
                  "metadata":{}},
            "email":"email@email.com",
            "client_ip":"24.253.223.21"}
          */

        //strip buttons events
        foreach ($data as $key => $value)
        {
            if ($key != 'config')
            {
                $content .= "
                    $('#".$value['btn_id']."').on('click', function(e) {
                            handler.open({
                            name: '".$value['name']."',
                            description: '".$value['description']."',
                            amount: ".$value['amount'].",
                            email: '".$data['config']['email']."'
                        });

                        $('#process_form .plan').val('".$value['plan']."');

                        e.preventDefault();

                    });
                ";
            }
        }

        $content .= "
            $(window).on('popstate', function() {
            handler.close();
            });
        ";

        if (!write_file('js/stripeEvents.js', $content))
        {
            return false;
        }

        else
        {
            return true;
        }
    }
}

if (!function_exists('enum')) {
    function enum($table_name, $column_name)
    {
        $result = mysql_query("SELECT COLUMN_TYPE
                              FROM INFORMATION_SCHEMA.COLUMNS
                              WHERE TABLE_NAME = '$table_name' AND COLUMN_NAME = '$column_name'")or die(mysql_error());

        $row = mysql_fetch_array($result);
        $enumList = explode(",", str_replace("'", "", substr($row['COLUMN_TYPE'], 5, (strlen($row['COLUMN_TYPE'])-6))));
        $values=[];
        foreach ($enumList as $value) {
            $values[] = $value;
        }

        return $values;
    }
}
if (!function_exists('flash_message')) {

    function flash_message($keys, $value='')
    {
        @session_start();
        if (is_string($keys)) {

            $_SESSION['flash_message'][$keys]=$value;
            return;

        }else{

            if (count($keys)==1) {
                $return='';
                if(isset($_SESSION['flash_message'][$keys[0]])){
                    $return=$_SESSION['flash_message'][$keys[0]];
                    unset($_SESSION['flash_message'][$keys[0]]);
                }
                return  $return;
            }

            foreach ($keys as $key ) {

                $return[$key]='';

                if(isset($_SESSION['flash_message'][$key])){
                    $return[$key]=$_SESSION['flash_message'][$key];
                    unset($_SESSION['flash_message'][$key]);
                }


            }
            return $return;
        }
    }
}

if (!function_exists('uploadImgFromUrl')) {
    function uploadImgFromUrl($path, $url)
    {
        $url_arr = explode ('/', $url);
        $ct = count($url_arr);
        $name = $url_arr[$ct-1];
        $name_div = explode('.', $name);
        $ct_dot = count($name_div);
        $img_type = $name_div[$ct_dot -1];

        $new = $path.md5($name.rand ()). "." . $img_type;

        $data = file_get_contents($url);

        file_put_contents($new, $data);

        return $new;

    }
}