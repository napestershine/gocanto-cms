</div>
<aside class="large-2 columns" id="middle">
<h5 class="color_grey01"><?=$language->line('header_admin_Area')?></h5>
<?php if (isset($wp_user) && $wp_user['id']!='') {?>
<ul class="side-nav">
	<?php foreach ($wpanelMenu as $menu) {
	?>
	<li>
		<a href="<?=base_url().(is_null($menu['url'])?'content/body/'.$menu['id']:$menu['url'])?>">
			<img src="<?=base_url().$menu['icon']?>" alt="" width="24" height="24">&nbsp;<?=formatString($menu['title'])?>
		</a>
	</li>
	<?php
	}
	?>
	<li>
		<a href="<?=base_url().'wpanel/logout'?>">
			<img src="<?=base_url().'img/exit.png'?>" alt="" width="24" height="24">&nbsp;<?=$language->line('header_logOut')?>
		</a>
	</li>
</ul>
<?php
}else{?>
<ul class="side-nav">
	<li>
		<a href="<?=base_url().'wpanel'?>">
			<img src="<?=base_url().'img/icons_sidebar/attendence.png'?>" alt="" width="24" height="24">&nbsp;<?=$language->line('header_signIn')?>
		</a>
	</li>
</ul>

<?php } ?>
<!-- we Offer -->
<h5 class="color_grey01" ><?=$language->line('sideBar_we_offer')?></h5>
<ul class="side-nav" >
	<?php foreach ($weOfferMenu as $menu) {
	?>
	<li>
		<a href="<?=base_url().(is_null($menu['url'])?'content/body/'.$menu['id']:$menu['url'])?>">
			<img src="<?=base_url().$menu['icon']?>" alt="<?=$menu['title']?>" width="20" height="20">&nbsp;<?= str_replace('ECommerce', '<small>eCommerce</small>', formatString($menu['title'])) ?></a>
	</li>
	<?php
	} ?>
</ul>
<!-- Newsletter -->
<!-- <hr> -->
<h5 class="color_grey01"><?=$language->line('sideBar_newsletters')?></h5>
<small><?=$language->line('newsletters_titleForm')?>.</small>
<form data-abide name="frmNewsletters" id="frmNewsletters" action="<?=base_url()?>newsletters/sent" method="POST">
	<div class="row">&nbsp;</div>
	<div class="row">
		<div class="large-12 columns">
			<label>
				<input type="email" id="txtNewslettersName" name="txtNewslettersName" placeholder="<?=$language->line('newsletters_label01')?>" pattern="alpha" required />
			</label>
			<small class="error radius"><?=$language->line('newsletters_errorLabel01')?>.</small>
		</div>
	</div>
	<div class="row">
		<div class="large-12 columns">
			<label>
				<input type="text" id="txtNewslettersEmail" name="txtNewslettersEmail" placeholder="<?=$language->line('newsletters_label02')?>" pattern="email" required />
			</label>
			<small class="error radius"><?=$language->line('newsletters_errorLabel02')?>.</small>
		</div>
	</div>
	<div class="row">
		<div class="large-12 columns">
			<a id="btnSaveNewsletters" name="btnSaveNewsletters" class="button radius tiny"><?=$language->line('newsletters_btnSuscri')?></a>
		</div>
		<div id="newsletters-reveal" class="reveal-modal small" data-reveal>
			<h2></h2>
			<h5></h5>
			<a class="close-reveal-modal">&#215;</a>
		</div>
	</div>
</form>
<!-- Facebook -->
<hr>
<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fwwsimple&amp;width=180&amp;height=300&amp;colorscheme=light&amp;show_faces=true&amp;header=false&amp;stream=false&amp;show_border=false&amp;appId=<?=$config['fb_app_id']?>" scrolling="no" frameborder="0" style="border:1px solid #FFF; border-radius:3px; background-color:#FFF; overflow:hidden; width:180px; height:258px;" allowTransparency="true"></iframe>
<!-- Twitter -->
<hr>
<!-- <h5><?=$language->line('sideBar_tweets')?></h5> -->
<a class="twitter-timeline" height="400" href="https://twitter.com/wwsimple" data-widget-id="614531952301871104">Tweets by @wwsimple</a>
<script>
	!function(d,s,id){
		var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';
		if(!d.getElementById(id)){
			js=d.createElement(s);
			js.id=id;js.src=p+"://platform.twitter.com/widgets.js";
			fjs.parentNode.insertBefore(js,fjs);
		}
}(document,"script","twitter-wjs");</script>

</aside>
</div>