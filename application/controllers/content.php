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

class content extends CI_Controller
{
    private $data;
    private $admin;
    private $type_list;
    //private $language;

    public function __construct()
    {
        parent::__construct();
        $this->data = array();
        $this->load->model(['Service', 'Customers', 'ModelContents', 'Autopost']);//,
        $this->load->library(['twitteroauth', 'facebook/facebook']);
        if ($this->session->userdata('wp-user')) {
            $user = $this->session->userdata('wp-user');
            $this->admin = $user['id_profile']==1?true:false;
        }
        //
        if ($this->admin) {
            $this->type_list = ['Who_we_are','Why_Us','Blog','Our_Products','Wpanel','Terms'];
        } else {
            $this->type_list = ['Blog'];
        }
    }

    //home page
    public function index()
    {
        $this->data = array(
            'blogBox' => 1,
            'blogList' => $this->ModelContents->getRows(" WHERE type = 'Blog' AND id_status = '1' ", " LIMIT 6", " ORDER BY id DESC"),
            'services' => $this->Service->getPlans(" WHERE id_status='1'", " LIMIT 3", true),
            'details' => $this->Service->getDetails(['limit' => 'LIMIT 20'])
        );

        $this->lang->load('services', $this->session->userdata('ws-language'));
        $this->load->layout('home_summary', $this->data);
    }

    //control all view in the system
    public function body($content='sections')
    {
        $this->load->model('ModelContents');
        $body = $this->ModelContents->getRow($content);

        if (!count($body)) {
            redirect(base_url());
            return;
            die();
        }

        if ($body->type=='Blog') {
            $this->data = array(
                'is_post' => true,
                'blogBox' => 1,
                'blogList' => $this->ModelContents->getRows(" WHERE type = 'Blog' AND id_status = '1' ", " LIMIT 6", " ORDER BY id DESC")
            );
        } else {
            switch ($body->id) {

                case '2': //customers
                    $this->data = array(
                        'blogBox' => 1,
                        'blogList' => $this->ModelContents->getRows(" WHERE type = 'Blog' AND id_status = '1' ", " LIMIT 6", " ORDER BY id DESC"),
                        'gallery' => $this->Customers->get_portafolio(['where'=>"id_status = '1'", 'order' => 'ord'])
                    );
                break;

                case '13': //contact
                    $this->data = array(
                        'reasons' => $this->ModelContents->get_reasons($body->id),
                        'language' => $this->lang->load('support', $this->session->userdata('ws-language')),
                        'blogBox' => 1,
                        'blogList' => $this->ModelContents->getRows(" WHERE type = 'Blog' AND id_status = '1' ", " LIMIT 6", " ORDER BY id DESC")
                    );

                    if ($this->uri->segment(4)!=''&&$this->uri->segment(5)!='') {
                        $this->data['op'] = $this->uri->segment(4);
                        $this->data['plan'] = $this->Service->get_name($this->uri->segment(5));
                    }
                break;

                case '17': //content list
                    $this->data = array(
                        'contents_list' => $this->ModelContents->getRows(" WHERE is_view = '0' AND type = 'Blog'", null, 'ORDER BY id DESC'),
                        'type_list' => $this->type_list
                    );
                break;

                case '18': //my profile
                    $this->load->model('user');
                    $this->data = array(
                        'user' => $this->user->getRow()
                    );
                break;

                case '30': // news
                    $this->load->library('pagination');

                    $this->pagination->initialize(paginationSetting([
                        'base_url' => base_url().'content/body/news',
                        'total_rows' => $this->ModelContents->record_count('Blog'),
                        'per_page' => 10,
                        'uri_segment' => 4
                    ]));

                    $page = ($this->uri->segment(4) && trim($this->uri->segment(4))!='')? $this->uri->segment(4) : 0;

                    $this->data['blogList'] = $this->ModelContents->fetch_contents('Blog', 10, $page); //type, limit, start

                    $this->data['links'] = $this->pagination->create_links();

                break;

                default:
                    $this->data = array(
                        'content' => $body,
                        'blogBox' => 1,
                        'blogList' => $this->ModelContents->getRows(" WHERE type = 'Blog' AND id_status = '1' ", " LIMIT 6", " ORDER BY id DESC")
                    );
                break;
            }

            $this->data['is_post'] = false;
        }

        $this->data['content'] = $body;

        if (trim($body->language)!='') {
            $this->data['language'] = $this->lang->load($body->language, $this->session->userdata('ws-language'));
        }


        if ($body->is_view==1) {
            if (isset($this->data['wadmin'])&&$this->data['wadmin']!='') {
                redirect($this->data['wadmin']);
            } else {
                $this->load->layout($body->body, $this->data, explode('-', $body->jsLibraries));
            }
        } else {
            $this->load->layout('content', $this->data, explode('-', $body->jsLibraries));
        }
    }

    //manage form to edit a exists content
    public function manage($content)
    {
        if (!$this->admin) {
            redirect(base_url().'wpanel');
            return;
        }
        $body = $this->ModelContents->getRow('contents');
        $this->data = array(
            'content' => $body,

            'type_list' => $this->type_list
        );

        if ($content!="") {
            $this->data['info'] = $this->ModelContents->getRow($content);
        }

        $this->load->layout($body->body, $this->data, explode('-', $body->jsLibraries));
    }

    //manage form to add new content
    public function add()
    {
        if (!$this->admin) {
            redirect(base_url().'wpanel');
            return;
        }
        $this->data = array(
            'new' => 1,
            'content' => $this->ModelContents->getRow('contents'),

            'type_list' => $this->type_list
        );

        $this->load->layout('wpanel/contents', $this->data, array('ckeditor/ckeditor.js', 'wpanel/contents.js'));
    }

    //update content in DB
    public function update()
    {
        if (!$this->admin) {
            return;
        }
        $path = 'img/contents/';
        $tmp_error = '';
        $error = '';

        new_directory($path);

        if ($_FILES['icon']['error']==0) { //icon validation
            if (!upload_file($path, 'icon', $tmp_error, $photo)) {
                $error = 'Error icon upload:'.$tmp_error;
                $tmp_error = '';
            } else {
                @unlink($this->input->post('old_icon'));
                $update['icon'] = $path.$photo['file_name'];
                resize_image($update['icon'], 45, 45);
            }
        }

        if ($_FILES['image']['error']==0) { //image validation
            if (!upload_file($path, 'image', $tmp_error, $photo)) {
                $error .= trim($tmp_error)!='' ? ',  Error image upload: '.$tmp_error : 'Error image upload: '.$tmp_error;
                $tmp_error = '';
            } else {
                @unlink($this->input->post('old_image'));
                $update['image'] = $path.$photo['file_name'];
                resize_image($update['image'], 450);
            }
        }

        if ($error!='') { // if the image didn't upload
            echo json_encode(array(
                'out' => 'notOk',
                'title' => 'Error',
                'message' => 'Hubo un error al momento de subir una de las imagenes: '.$error
            ));
        } else { // if everything is ok
            $update['id_status'] = $this->input->post('cboStatus');
            $update['type'] = $this->input->post('cboType');
            $update['title'] = $this->input->post('txtTitulo');
            $update['text_small'] = $this->input->post('txtSmallText');
            $update['summary'] = $this->input->post('summary');
            $update['body'] = $this->input->post('body');
            $update['author'] = $this->input->post('txtAuthor');
            $update['date'] = date('Y-m-d h:m:s');

            $this->ModelContents->update($update, $this->input->post('id')); //query update

            echo json_encode(array(
                'out' => 'ok',
                'title' => 'Exito!',
                'message' => 'El contenido ha sido actualizado exitosamente.',
                'id' => $this->input->post('id'),
                //'url' => base_url().'content/body/sections'
            ));
        }
    }


    //insert new content in DB
    public function insert($in='')
    {
        $path      = 'img/contents/';
        $tmp_error = '';
        $error     = '';

        if (!$this->admin && $in=='') {
            return;
        }
        if (is_array($in)) {
            $insert = $in;

            $insert['image']=uploadImgFromUrl($path, $insert['image']);

        } else {
            $insert = array(
            'type' => $this->input->post('cboType'),
            'id_status' => $this->input->post('cboStatus'),
            'title' => $this->input->post('txtTitulo'),
            'text_small' => $this->input->post('txtSmallText'),
            //'summary' => $this->input->post('summary'),
            'body' => $this->input->post('body'),
            'author' => $this->input->post('txtAuthor'),
            'date' => date('Y-m-d h:m:s')
            );
        }


        if ($this->ModelContents->insert($insert)) {
            $id = $this->db->insert_id();

            if (!is_array($in)) {
                if ($_FILES['icon']['error']==0) { //icon validation
                    if (!upload_file($path, 'icon', $tmp_error, $photo)) {
                        $error = '* Icon: '.$tmp_error.'<br><br>';
                        $tmp_error = '';
                    } else {
                        $update['icon'] = $path.$photo['file_name'];
                        resize_image($update['icon'], 45, 45);
                        $tmp_error = '';
                    }
                }

                if ($_FILES['image']['error']==0) { //image validation
                    if (!upload_file($path, 'image', $tmp_error, $photo)) {
                        $error .= '* Image: '.$tmp_error.'<br><br>';
                        $tmp_error = '';
                    } else {
                        $update['image'] = $path.$photo['file_name'];
                        resize_image($update['image'], 1024);
                    }
                }
            }

            if (isset($update)) {
                $this->ModelContents->update($update, $id); //query update
            }

            if ($error!='') {
                $this->data = array(
                    'out' => 'notOk',
                    'title' => 'Error en upload de im&aacute;genes',
                    'message' => $error.'<br>Puedes solucionar este error desde la secci&oacute;n editar contenidos.'
                );
            } else {

                if ($insert['type']=='Blog') {
                    $connection = $this->twitteroauth->create($this->config->config['twitter_consumer_token'],
                                                              $this->config->config['twitter_consumer_secret'],
                                                              $this->config->config['twitter_access_token'],
                                                              $this->config->config['twitter_access_secret']);
                    $content = $connection->get('account/verify_credentials');
                    $s = substr(html_entity_decode($insert['title'],ENT_QUOTES, 'UTF-8'), 0, 114).'... ';
                    $parameters = array(
                        'status' => $s.base_url().'content/body/'.$id,
                        // 'in_reply_to_status_id' => $in_reply_to
                    );
                   $result = $connection->post('statuses/update', $parameters);
                   if (is_array($in)) {
                        return;
                   }
                }


                $this->data = array(
                    'out' => 'ok',
                    'title' => 'Exito!',
                    'message' => 'El contenido ha sido insertado exitosamente.',
                    'id' => $id,
                    //'url' => base_url().'content/body/sections',
                   // 'twitter' => $result,

                );
            }//error
        } else {
            $this->data = array(
                'out' => 'notOk',
                'title' => 'Error',
                'message' => 'Hubo un error al momento de insertar el registro, favor intente nuevamente.<br><br>Si el problema persiste comuniquese con el administrador'
            );
        } //query insert

        echo json_encode($this->data);
    }

    public function robot()
    {
        $principals=$this->Autopost->getPrincipals();
        foreach ($principals as $principal) {
            $urls=$this->Autopost->getUrls($principal['url'], $principal['patterns']);

            $this->Autopost->urlsInsert($principal['id'], $urls, $principal['ids_in'], $principal['ids_out']);
        }

        $toPost =  $this->Autopost->getRandom();

        echo '<pre>';

        foreach ($toPost as $value) {


               $post   =  $this->Autopost->getPost($value['url'],
                                            $this->Autopost->getIdsInOut($value['ids_in']),
                                            $this->Autopost->getIdsInOut($value['ids_out']));

               if ( trim($post['content'])=='') {
                    echo $value['id'].'<br>';
                   $this->Autopost->update(['status' => 'Posted'], $value['id']);
                   return $this->robot();
               }


            $this->lang->load('general');
            $post['content'].='<br><br><span class="label radius success">'.$this->lang->line('general_add_content_author_label');
            $post['content'].=': '.$post['author'];
            $post['content'].='</span> <a target="_blank" href="'.$value['url'].'" ><span class="label radius">'.$this->lang->line('general_source').'</span></a>';

            $insert = array(
                            'type'       => 'Blog',
                            'id_status'  => 1,
                            'image'      => $post['picture'],
                            'title'      => $post['title'],
                            'text_small' => $post['description'],
                            'body'       => $post['content'],
                            'author'     => $this->config->config['head']['company'],
                            'date'       => date('Y-m-d h:m:s')
                           );

            $this->insert($insert);

            $this->Autopost->update(['status' => 'Posted'], $value['id']);


            print_r($post);
        }
    }

    //delete contents from content list view
    public function delete($id)
    {
        if (!$this->admin) {
            return;
        }
        $content = $this->ModelContents->getRow($id);

        unlink($content->icon);
        unlink($content->image);

        $this->ModelContents->delete($id);

        echo json_encode(array(
            'out' => 'ok'
        ));
    }

    public function status($id, $status)
    {
        if (!$this->admin) {
            return;
        }
        $update['id_status'] = $status==1?2:1;
        $update['date'] = date('Y-m-d h:m:s');
        $this->ModelContents->update($update, $id);

        die(json_encode(['sta' => $update['id_status']]));

        $type=$this->ModelContents->getField('type', $id);
        $content=$this->ModelContents->getRow(17);
        $this->data = array(
                        'contents_list' => $this->ModelContents->getRows(" WHERE is_view = '0' AND type='$type' "),
                        'content' => $content,
                        'list_type' => ['Who_we_are','Why_Us','Blog','Our_Products'],

                        'type'=>$type
                    );

        $this->load->layout('wpanel/contents_list', $this->data, ['wpanel/contents_list.js']);
    }

    //this method is called when the combo box is changed (content list view, option 17 in body method)
    public function ajax_grid($id)
    {
        $ci = get_instance();

        $ci->session->set_userdata('ws-language', get_language());
        $ci->lang->load('general', $ci->session->userdata('ws-language'));

        $this->data = array(
            'contents_list' => $this->ModelContents->getRows(" WHERE type = '".$id."'", ' LIMIT 20', $order=' ORDER BY id DESC'),

            'language' => $ci->lang
        );

        $this->load->view("wpanel/ajax/contents_list", $this->data);
    }

/*
    Developed by Gustavo Ocanto
    gustavoocanto@gmail.com
    Version 1.0
    May 2014
    Valencia, Venezuela
*/

}
