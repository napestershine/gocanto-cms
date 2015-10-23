<!DOCTYPE html>
<html class="no-js" lang="es">
    <head>
        <title><?=isset($content->title)?ucfirst($content->title):$config['title']?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="google-site-verification" content="<?=$config['google-site-verification']?>" />
        <meta name="description" content="<?=isset($content->title)?ucfirst($content->text_small):$config['description']?>">
        <meta name="author" content="<?=$config['author']?>">
        <meta name="copyright" content="<?=$config['copyright']?>">
        <meta name="keywords" lang="en" content="<?=$config['keywords']?>" />
        <meta name="reply-to" content="<?=$config['contact'][1]?>">
        <link href='http://fonts.googleapis.com/css?family=Lato:400' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="<?=base_url()?>css/foundation.min.css" />
        <link rel="stylesheet" href="<?=base_url()?>css/style.min.css">
        <script src="<?=base_url()?>js/vendor/modernizr.min.js"></script>
        <link rel="apple-touch-icon" sizes="57x57" href="<?=base_url()?>img/favicons/apple-touch-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="<?=base_url()?>img/favicons/apple-touch-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="<?=base_url()?>img/favicons/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="<?=base_url()?>img/favicons/apple-touch-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="<?=base_url()?>img/favicons/apple-touch-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="<?=base_url()?>img/favicons/apple-touch-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="<?=base_url()?>img/favicons/apple-touch-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="<?=base_url()?>img/favicons/apple-touch-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="<?=base_url()?>img/favicons/apple-touch-icon-180x180.png">
        <link rel="icon" type="image/png" href="<?=base_url()?>img/favicons/favicon-32x32.png" sizes="32x32">
        <link rel="icon" type="image/png" href="<?=base_url()?>img/favicons/android-chrome-192x192.png" sizes="192x192">
        <link rel="icon" type="image/png" href="<?=base_url()?>img/favicons/favicon-96x96.png" sizes="96x96">
        <link rel="icon" type="image/png" href="<?=base_url()?>img/favicons/favicon-16x16.png" sizes="16x16">
        <link rel="manifest" href="<?=base_url()?>img/favicons/manifest.json">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="msapplication-TileImage" content="<?=base_url()?>img/favicons/mstile-144x144.png">
        <meta name="theme-color" content="#ffffff">

        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="@<?=$config['twitter_user']?>">
        <meta name="twitter:image" content="<?=isset($content->image)?base_url().$content->image:base_url().'img/favicons/android-chrome-192x192.png'?>">
        <meta name="twitter:title" content="<?=isset($content->title)?ucfirst($content->title):$config['title']?>">
        <meta name="twitter:description" content="<?=substr(isset($content->title)?ucfirst($content->text_small):$config['description'], 0, 197).'...'?>">

        <meta property="og:title" content="<?=isset($content->title)?ucfirst($content->title):$config['title']?>" />
        <meta property="og:type" content="article" />
        <meta property="og:description" content="<?=isset($content->title)?ucfirst($content->text_small):$config['description']?>" />
        <meta property="og:image" content="<?=isset($content->image)?base_url().$content->image:base_url().'img/favicons/android-chrome-192x192.png'?>" >
       
        <meta property="fb:app_id" content="<?=$config['fb_app_id']?>" />
        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-65300677-1', 'auto');
          ga('send', 'pageview');

        </script>
    </head>
    <body>
        <div class="fixed">
            <nav class="top-bar fixed" data-topbar data-options="is_hover: true">
                <ul class="title-area">
                    <li class="name">
                        <h1>
                        <a href="<?=base_url()?>">
                        <img src="<?=base_url().$config['logo']?>" class="logo" alt="<?=$config['company']?>" title="<?=$language->line('header_altLogo')?>" >
                        </a>
                        <!-- <small><?=$companyInfo->slogan?></small> -->
                        </h1>
                    </li>
                    <li class="toggle-topbar menu-icon"><a href=""><span>Menu</span></a></li>
                </ul>
                <ul>
                    <section class="top-bar-section">
                        
                        <ul class="right">
                            <!--   <li>
                                <a href="<?=base_url()?>"><img src="<?=base_url()?>img/top_icons/home.png" alt="<?=$language->line('header_home')?>" width="25" height="25" >&nbsp;<?=$language->line('header_home')?></a>
                            </li>
                            <li class="divider"></li> -->
                            <?php if (empty($wp_user)&&false) { ?>
                            <li>
                                <a href="<?=base_url().'wpanel/access/login'?>"><img src="<?=base_url()?>img/lock_w.png" alt="<?=$language->line('header_signIn')?>" width="25" height="25" >&nbsp;<?=$language->line('header_signIn')?></a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="<?=base_url().'wpanel/access/signup'?>"><img src="<?=base_url()?>img/user_w.png" alt="<?=$language->line('header_signUp')?>" width="25" height="25" >&nbsp;<?=$language->line('header_signUp')?></a>
                            </li>
                            <?php } ?>
                            <li class="has-dropdown">
                                <a href="#"><img  src="<?=base_url()?>img/top_icons/who_we_are.png" width="25" height="25" alt="<?=$language->line('sideBar_category')?>" >&nbsp;&nbsp;<?=$language->line('sideBar_category')?></a>
                                <ul class="dropdown">
                                    <?php foreach ($firstMenuSideBar as $array) { ?>
                                    <li>
                                        <a href="<?=base_url().'content/body/'.str_replace(' ', '-', formatString(convert_accented_characters($array['title']), 3))?>">
                                            <?=formatString($array['title'])?>
                                        </a>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <li class="divider"></li>
                            <li class="has-dropdown">
                                <a href="#"><img  src="<?=base_url()?>img/top_icons/why_us.png" width="25" height="25" alt="<?=$language->line('sideBar_why_us')?>" >&nbsp;&nbsp;<?=$language->line('sideBar_why_us')?>&nbsp;&nbsp;</a>
                                <ul class="dropdown">
                                    <?php foreach ($secondMenuSideBar as $array) {?>
                                    <li>
                                        <a href="<?=base_url().'content/body/'.str_replace(' ', '-', formatString(convert_accented_characters($array['title']), 3))?>">
                                            <?=formatString($array['title'])?>
                                        </a>
                                    </li>
                                    <?php }
                                    foreach ($weOfferMenu as $menu) {
                                        ?>
                                    <li>
                                        <a href="<?=base_url().(is_null($menu['url'])?'content/body/'.$menu['id']:$menu['url'])?>"><?= formatString($menu['title']) ?></a>
                                    </li>
                                    <?php 
                                    } ?>
                                </ul>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="<?=base_url()?>content/body/news"><img  src="<?=base_url()?>img/top_icons/news.png" alt="<?=$language->line('header_news')?>" width="25" height="25" >&nbsp;<?=$language->line('header_news')?></a>
                            </li>
                            <li class="divider"></li>
                            <li>

                                <a href="<?=base_url()?>sales"><img src="<?=base_url()?>img/top_icons/cloud.png" alt="<?=$language->line('header_cloud')?>" width="25" height="25" >&nbsp;<?=$language->line('header_cloud')?></a>
                            </li>

                            <li class="divider"></li>
                            <li>
                                <a href="<?=base_url()?>content/body/contact-us"><img  src="<?=base_url()?>img/top_icons/contact_us.png" alt="<?=$language->line('header_support')?>" width="25" height="25" >&nbsp;<?=$language->line('header_support')?></a>
                            </li>
                        </ul>
                    </section>
                </ul>
            </nav>
        </div>
        <div class="row">
            <div class="large-12 columns">
                &nbsp;
            </div>
        </div>

        <?php
            $success = flash_message(['successful_message']);
            $error = flash_message(['fail_message']);
            $wsimpleFlashMsg = [];
            $openFlashMsg = '';

            if (trim($success)!='') {
                $wsimpleFlashMsg = [
                    'title' => $language->line('services_process_success_title'),
                    'message' => $success,
                    'alertClass' => 'success',
                    'bodyClass' => 'success-box-body'
                ];
            } elseif (trim($error)!='') {
                $wsimpleFlashMsg = [
                    'title' =>  $language->line('services_process_error_title'),
                    'message' => $error,
                    'alertClass' => 'alert',
                    'bodyClass' => 'alert-box-body'
                ];
            }

            if (isset($wsimpleFlashMsg) && count($wsimpleFlashMsg) > 0) {
                $contactLink = '<a href="'.base_url().'content/body/contact-us" style="text-decoration: underline; color:#FFF">Contact Us</a>';
                $myServices = '<a href="'.base_url().'content/body/contact-us" style="text-decoration: underline; color:#FFF">Contact Us</a>';
                $wsimpleFlashMsg['message'] = str_replace('[contactlink]', $contactLink, $wsimpleFlashMsg['message']);
                $wsimpleFlashMsg['message'] = str_replace('[track]', $myServices, $wsimpleFlashMsg['message']);
                ?>
        <div class="row">
            <div class="large-10 columns">
                <div class="row">
                    <div data-alert class="alert-box <?=$wsimpleFlashMsg['alertClass']?> radius">
                        <h6><?=$wsimpleFlashMsg['title']?></h6>
                        <p class="<?=$wsimpleFlashMsg['bodyClass']?>"><?=$wsimpleFlashMsg['message']?></p>
                        <a href="#" class="close">&times;</a>
                    </div>
                </div>
            </div>
            <div class="large-2 columns">
                &nbsp;
            </div>
        </div>
        <?php 
            } ?>

        <div class="row">
            <div class="large-10 columns" role="content" id="middle">