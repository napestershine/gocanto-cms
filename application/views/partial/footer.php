<footer>
  
    <div class="row">
      <div class="large-12 columns copyright">
        <p><?='<strong>'.$companyInfo->name.'</strong> '.$config['copyright']?></p>
        <p><strong><?=$language->line('footer_contact')?>:</strong>&nbsp;<a href="mailto:<?=$companyInfo->email?>"><?=$companyInfo->email?></a></p>
        <p>
          <strong><?=$language->line('footer_location')?>:</strong>&nbsp;
          <?=$companyInfo->country?>,&nbsp;
          <?=$companyInfo->city?>&nbsp;
          <?=$companyInfo->state?>
         <!--  &nbsp;-&nbsp;
          <?=$companyInfo->zip_code?>,&nbsp;
          <?=$companyInfo->address?> -->
        </p>
      </div>
      <hr>
      <div class="large-12 columns">
        <ul class="breadcrumbs">
          <?php foreach ($firstMenuSideBar as $array) {
    ?>
          <li>
            <a href="<?=base_url().'content/body/'.$array['id']?>">
              <?=formatString($array['title'])?>
            </a>
          </li>
          <?php 
}
          foreach ($secondMenuSideBar as $array) {
              ?>
          <li>
            <a href="<?=base_url().'content/body/'.$array['id']?>">
              <?=formatString($array['title'])?>
            </a>
          </li>
          <?php 
          }

          foreach ($weOfferMenu as $menu) {
              ?>
          <li>
            <a href="<?=base_url().(is_null($menu['url']) ? 'content/body/'.$menu['id'] : $menu['url'])?>">
              <?=formatString($menu['title'])?>
            </a>
          </li>
          <?php 
          } ?>
          
          
          
        </ul>
        <ul class="breadcrumbs">
        <?php foreach ($Terms as $menu) {
    ?>
          <li>
            <a href="<?=base_url().(is_null($menu['url']) ? 'content/body/'.$menu['id'] : $menu['url'])?>">
              <?=formatString($menu['title'])?>
            </a>
          </li>
          <?php 
} ?>
          <li>
            <a href="<?=base_url()?>content/body/contact-us">
              <?=formatString($language->line('header_support'))?>
            </a>
          </li>
        </ul>
      </div>
  </div>
</footer>
<script src="<?=base_url()?>js/vendor/jquery.min.js"></script>
<script src="<?=base_url()?>js/foundation.min.js"></script>
<script src="<?=base_url()?>js/jquery.form.min.js"></script>
<script src="<?=base_url()?>js/functions.min.js"></script>

<script>
  
  $(document).foundation();

  newsletters();

  //comments
  (function () {
  var s = document.createElement('script'); s.async = true;
  s.type = 'text/javascript';
  s.src = '//<?=$config['disqus_id']?>.disqus.com/count.js';
  (document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
  }());
  //end comments
  
</script>

<?php
  if (isset($jsLibraries) && count($jsLibraries) > 0) {
      foreach ($jsLibraries as $file) {
          if (trim($file) != '') {
              $src = base_url().'js/'.$file;

              if (strpos($file, 'checkout.stripe') !== false) {
                  $src = $file;
              }

              if (strpos($file, 'http://maps.google.com') !== false) {
                  $src = $file;
              }

              if (strpos($file, 'ckeditor') !== false) {
                  $src = base_url().$file;
              }

              echo '<script type="text/javascript" src="'.$src.'"></script>';
          }
      }
  }
?>
</body>
</html>