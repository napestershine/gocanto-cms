<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class autopost extends CI_Model
{
    private $last_id;
    private $table;
    private $admin;
    private $current_user;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->last_id = '';
        $this->table='autopost';
        $this->current_user=false;
        if ($this->session->userdata('wp-user')) {
            $this->current_user = $this->session->userdata('wp-user');
            $this->admin = $this->current_user['id_profile']==1?true:false;
        }
    }


    public function get($id='')
    {
        $query = $this->db->query("SELECT * FROM $this->table WHERE id = '".$id."' LIMIT 1 ");
        return $query->row();
    }

    public function getPrincipals()
    {
        $query = $this->db->query("SELECT id, url, patterns, ids_in, ids_out FROM $this->table WHERE  type = 'Principal' AND status is NULL ");
        return $query->result_array();
    }

    public function getRandom($num_rows=1)
    {
        $query = $this->db->query("SELECT id, url, ids_in, ids_out
                                    FROM $this->table
                                    WHERE STATUS =  'Waiting'
                                    AND   TYPE   =  'Post'
                                    ORDER BY RAND( ) 
                                    LIMIT 1");
        return $query->result_array();
    }

    public function getIdsInOut($idsString)
    {
        $ids=explode('/', $idsString);

        $exit=[];
        foreach ($ids as $id) {
            $values=explode(',', $id);

            if (count($values)==1 && $values[0]!='') {
                $values[2] = $values[0];
                $values[0] = 'div';
                $values[1] = 'class';
                
            } elseif (count($values)==3) {
                $values[0] = $values[0]!=''?$values[0]:'div';
                $values[1] = $values[1]!=''?$values[1]:'class';
                $values[2] = $values[2]!=''?$values[2]:'';
            } else {
                $values[0] = '';
                $values[1] = '';
                $values[2] = '';
            }

            $exit[]=['tag' => $values[0], 'attribute' => $values[1], 'value' => $values[2]];
        }
        return $exit;
    }

    public function exists($url)
    {
        $query = $this->db->query("SELECT id
                        			FROM $this->table
                        		 	WHERE md5 = md5('$url')
                        		  ");

        return $query->num_rows() ? true : false ;
    }

    
    public function insert($array)
    {
        $this->db->insert($this->table, $array);
        return $this->last_id = $this->db->insert_id();
    }

    public function urlsInsert($id, $urls, $ids_in, $ids_out)
    {
        foreach ($urls as $url) {
            if (!$this->exists($url)) {
                $insert=[
                        'url'          => $url,
                        'md5'          => md5($url),
                        'id_principal' => $id,
                        'type'         => 'Post',
                        'status'       => 'Waiting',
                        'ids_in'       => $ids_in,
                        'ids_out'      => $ids_out
                        ];
                $this->insert($insert);
            }
        }
    }

    public function removeTag($dom, $tags='script')
    {
        if (is_string($tags)) {
            $tags=[['tag'=>$tags]];
        }
        
        foreach ($tags as $tag) {

            if($tag['tag']!=''){ 

                $script = $dom->getElementsByTagName($tag['tag']);

                $remove = [];
                foreach ($script as $item) {
                    if (isset($tag['attribute'])) {
                        foreach ($item->attributes as $value) {
                            if ($tag['attribute']==$value->name && $tag['value']==$value->value) {
                                $remove[] = $item;
                            }
                        }
                    } else {
                        $remove[] = $item;
                    }
                }

                
                foreach ($remove as $item) {
                    $item->parentNode->removeChild($item);
                }
            } 
        }
    }


    public function getContent($dom, $content)
    {
        $contentDefault = ['tag' => 'div', 'attribute' => 'class', 'value' =>''];

        $content = $content + $contentDefault;

        $tags = $dom->getElementsByTagName($content['tag']);

        $innerHTML = '';
        foreach ($tags as $tag) {


            if ($content['attribute']=='') {
                return $tag->nodeValue;
            }
            
            $classes=explode(' ', $tag->getAttribute($content['attribute']));
            $contentNode=false;

            foreach ($classes as $value) {
                if ($value == $content['value']) {
                    $contentNode = true;
                    break;
                }
            }

            if ($contentNode) {
                $children = $tag->childNodes;
                foreach ($children as $child) {
                    $exitAux=$child->ownerDocument->saveHTML($child);
                    if (trim(strip_tags($exitAux))!='') {

                        $exitAux = trim($exitAux);

                        $exitAux = preg_replace('/^\s+|\n|\r|\s+$/m', '', $exitAux);

                        $exitAux = str_replace('<a', '<a target="_blank"', $exitAux); 

                        $exitAux = strip_tags($exitAux,'<p><a>');
                        
                        $innerHTML .=  $exitAux;
                    }
                }
            }
        }

        return $innerHTML!='' ? $innerHTML : false;
    }


    public function getPost($url = '', $post = [], $toRemove = [])
    {
        $file    = $this->getWebHtml($url);
        $infoUrl = $this->getUrlData($file);
        $dom     = new DOMDocument();
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        @$dom->loadHTML(mb_convert_encoding($file, 'HTML-ENTITIES', 'UTF-8'));

        //eliminamos <script></script>/////
        $this->removeTag($dom);

        $this->removeTag($dom, $toRemove);

        $content='';
        foreach ($post as $value) {
            $content .= $this->getContent($dom, $value, $toRemove);
        }
        
        

        return ['title'   => $this->getTitle($infoUrl),
                'picture' => $this->getPicture($infoUrl),
                'author'  => $this->getAuthor($infoUrl),
                'description' => $this->getDescription($infoUrl),
                'content' => $content ];
    }

    public function getWebHtml($url)
    {
        // $opts = array(
        //   'http'=>array(
        //     'header'=>"Accept-language: en\r\n"
        //   )
        // );

        // $context = stream_context_create($opts);

        // // Optenemos la web, el html
        // return file_get_contents($url, false, $context);

        // Optenemos la web, simulando navegador
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.81 Safari/537.36');
        $html = curl_exec($ch);
        curl_close($ch);

        return $html;
    }

    public function getTitle($info)
    {
        if (isset($info['metaTags']['twitter:title']['value'])) {
            return $info['metaTags']['twitter:title']['value'];
        } elseif (isset($info['metaProperties']['og:title']['value'])) {
            return $info['metaProperties']['og:title']['value'];
        } else {
            return $info['title'];
        }

        return false;
    }

    public function getDescription($info)
    {
        if (isset($info['metaTags']['twitter:description']['value'])) {
            return $info['metaTags']['twitter:description']['value'];
        } elseif (isset($info['metaProperties']['og:description']['value'])) {
            return $info['metaProperties']['og:description']['value'];
        } else {
            return $info['title']['description']['value'];
        }

        return false;
    }

    public function getPicture($info=[])
    {
        if (isset($info['metaTags']['twitter:image:src']['value'])) {
            return $info['metaTags']['twitter:image:src']['value'];
        } elseif (isset($info['metaProperties']['og:image']['value'])) {
            return $info['metaProperties']['og:image']['value'];
        }

        return false;
    }

    public function getAuthor($info=[])
    {
        if (isset($info['metaTags']['author']['value'])) {
            return $info['metaTags']['author']['value'];
        }

        return false;
    }

    public function getUrls($web, $keys=array())
    {
        // $web='http://www.el-nacional.com/'; // web a escanear
       // $keys= [ '.html']; //patrones a buscar en url de publicaciones
       // Patrones de fecha:
       //                    {{Y}} = Ejemplos: 1999 o 2003
       //                    {{y}} = Ejemplos: 99 o 03
       //                    {{m}} = 01 hasta 12
       //                    {{n}} = 1 hasta 12
        
        list($keysAnd, $keysOr)  = explode('|', $keys);

        $keysAnd = explode(',', $keysAnd);
        $keysOr  = explode(',', $keysOr);

        $keysAux  = [];
        //reemplazo de patrones
        foreach ($keysAnd as $key) {
            $key = str_replace('{{Y}}', date('Y'), $key);
            $key = str_replace('{{y}}', date('y'), $key);
            $key = str_replace('{{m}}', date('m'), $key);
            $key = str_replace('{{n}}', date('n'), $key);
            $keysAux[]=$key;
        }

        $keysAnd = $keysAux;

        

       //print_r($keys);die();

       $principal = explode('//', $web);
        $http = $principal[0];

        if (stripos($principal[1], '/')) {
            $principal = explode('/', $principal[1]);
            $principal = $http.'//'.$principal[0];
        } else {
            $principal = $principal[1];
            $principal = $http.'//'.$principal;
        }

        // Optenemos la web, el html
        $file =  $this->getWebHtml($web);



        $regex = '/https?\:\/\/[^\" ]+/i';

        //se extraen todos las urls en el html
        preg_match_all($regex, $file, $matches);
        $matches=$matches[0];

        $dom = new DOMDocument();
        @$dom->loadHTML($file);

        //segunda  extraccion de las urls en el html
        $tags = $dom->getElementsByTagName('a');
        foreach ($tags as $tag) {
            $matches[] =  $tag->getAttribute('href');
        }

        $urls=[];
        foreach ($matches as $url) {
            $save=true;

            foreach ($keysOr as $key) {
                //etiquetas requeriadas, al menos una
                if (stripos(' '.$url, $key)) {
                    $save=true;
                    break;
                }

                $save=false;
            }

            foreach ($keysAnd as $key) {
                //etiquetas obligatorias
                if (!stripos(' '.$url, $key)) {
                    $save=false;
                    break;
                }
            }

            
            //se eliminan # del la url
            if (stripos($url, '#')) {
                $url = explode('#', $url);
                $url = $url[0];
            }

            //se comprueba que no sea la raiz
            if (stripos(' '.$url, '//')) {
                $urlAux = explode('//', $url);
                if (!stripos(' '.$urlAux[1], '/')) {
                    $save=false;
                }
            }

            if (!stripos(' '.$url, 'http://')) {
                //no contiene link principal
                    
                    $url=$principal.'/'.ltrim($url, '/');
            } elseif (!stripos(' '.$url, $principal)) { //eliminando link externos
                $save=false;
            }

            if (!in_array($url, $urls) && $save) { //evitando repeticiones

                
                $urls[]=$url;
            }
        }

        return $urls;
    }

    public function getUrlData($contents, $raw=false) // $raw - enable for raw display
    {
        $result = false;
       
        $contents = $this->getUrlContents($contents);

        if (isset($contents) && is_string($contents)) {
            $title = null;
            $metaTags = null;
            $metaProperties = null;
           
            preg_match('/<title>([^>]*)<\/title>/si', $contents, $match);

            if (isset($match) && is_array($match) && count($match) > 0) {
                $title = strip_tags($match[1]);
            }
           
            preg_match_all('/<[\s]*meta[\s]*(name|property)="?' . '([^>"]*)"?[\s]*' . 'content="?([^>"]*)"?[\s]*[\/]?[\s]*>/si', $contents, $match);
           
            if (isset($match) && is_array($match) && count($match) == 4) {
                $originals = $match[0];
                $names = $match[2];
                $values = $match[3];
               
                if (count($originals) == count($names) && count($names) == count($values)) {
                    $metaTags = array();
                    $metaProperties = $metaTags;
                    if ($raw) {
                        if (version_compare(PHP_VERSION, '5.4.0') == -1) {
                            $flags = ENT_COMPAT;
                        } else {
                            $flags = ENT_COMPAT | ENT_HTML401;
                        }
                    }
                   
                    for ($i=0, $limiti=count($names); $i < $limiti; $i++) {
                        if ($match[1][$i] == 'name') {
                            $meta_type = 'metaTags';
                        } else {
                            $meta_type = 'metaProperties';
                        }
                        if ($raw) {
                            ${$meta_type}[$names[$i]] = array(
                                'html' => htmlentities($originals[$i], $flags, 'UTF-8'),
                                'value' => $values[$i]
                            );
                        } else {
                            ${$meta_type}[$names[$i]] = array(
                                'html' => $originals[$i],
                                'value' => $values[$i]
                            );
                        }
                    }
                }
            }
           
            $result = array(
                'title' => $title,
                'metaTags' => $metaTags,
                'metaProperties' => $metaProperties,
            );
        }
       
        return $result;
    }

    public function getUrlContents($contents, $maximumRedirections = null, $currentRedirection = 0)
    {
        $result = false;
       
        //$contents = @file_get_contents($url);
       
        // Check if we need to go somewhere else
       
        if (isset($contents) && is_string($contents)) {
            preg_match_all('/<[\s]*meta[\s]*http-equiv="?REFRESH"?' . '[\s]*content="?[0-9]*;[\s]*URL[\s]*=[\s]*([^>"]*)"?' . '[\s]*[\/]?[\s]*>/si', $contents, $match);
           
            if (isset($match) && is_array($match) && count($match) == 2 && count($match[1]) == 1) {
                if (!isset($maximumRedirections) || $currentRedirection < $maximumRedirections) {
                    return $this->getUrlContents($match[1][0], $maximumRedirections, ++$currentRedirection);
                }
               
                $result = false;
            } else {
                $result = $contents;
            }
        }
       
        return $contents;
    }

    public function update($array, $id='')
    {
        $this->db->where('id', $id);
        $this->db->update($this->table, $array);
    }

    public function get_last_id()
    {
        return $this->last_id;
    }

    public function get_field($field, $where)
    {
        $query = $this->db->query("SELECT $field
                                   FROM $this->table $where
                                   LIMIT 1 ");
        $array = $query->row();
        return $array->$field;
    }
}
