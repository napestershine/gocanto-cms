<div id="fb-root"></div>
<script>(function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) return;
js = d.createElement(s); js.id = id;
js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3&appId=<?=$config['fb_app_id']?>";
fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div class="row">
  
  <div class="large-6 columns">
    <small>
    <?php
    if ($content->type=='Blog') {
    if (isset($content->author) && trim($content->author)!='') {
    echo '<strong>'.$language->line('general_published_by').'</strong> <a href="'.$config['not_click'].'">'.formatString($content->author).'</a> ';
    }
    if (isset($content->date) && trim($content->date)!='') {
    echo 'on '.formatDate($content->date);
    }
    } else {
    echo formatString($language->line('general_lets_get_started'), 2).'&nbsp;<strong class="color_green">'.$companyInfo->tlf.'</strong>';
    }
    ?>
    </small>
  </div>
  <div class="large-6 columns">
    <div class="right">
      <a href="https://twitter.com/share" class="twitter-share-button" data-via="wwsimple">Tweet</a>
      <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
    </div>
    <div class="right" style="margin-right: 5px;">
      <div class="fb-like" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
    </div>
  </div>
</div>