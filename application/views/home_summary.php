<div class="panel row radius">
	<h4 class="color_green"><?=$language->line('general_web_title_sumary')?>
	<small>&nbsp;
	<?=$language->line('general_web_small_summary')?>.
	</small>
	</h4>
	
	<hr>

	<div class="row">
		<div class="large-12 columns">
			<?php $this->load->view('services/index', ['services' => $services]); ?>
		</div>
		
		<div class="row">&nbsp;</div>

		<div class="large-12 columns">
			<h4 class="orange_color"><?=str_replace('[prod]', $language->line('general_our_products_label'), $language->line('services_what_they_offer'))?></h4>
			<?php $this->load->view('services/partial/offerLabels', ['details' => $details]); ?>
		</div>
	</div>
</div>

<div class="row">&nbsp;</div>

<!-- godady -->
<div class="panel row radius">
	<div class="row">
		<div class="large-12 columns">
			<h4 class="color_green">Already own a domain name?
			<small>
			Great! We have a number of options available for hosting, emails, transferring, redirecting or even transferring the registration of your existing domain name to w-simple.com, so do not wait too long
			<a href="<?=base_url()?>sales?product=domains/activate.aspx&ci=48767&pl_id=511915">Transfer it now</a>.
			</small>
			</h4>
			
			<hr>
		</div>
	</div>
	
	<div class="row">
		<div class="large-12 columns">
	
			<style type="text/css">
			.product-pod-image{background-image:url('http://img1.wsimg.com/fos/icn/0/83440_icn_product_offer_sprite.png');background-repeat:no-repeat;}
			.product-pod-details p{font-size: 70%;}
			</style>
			<a  class="small-12 medium-4 large-4 columns" href="<?=base_url()?>sales?product=ecommerce/shopping-cart.aspx&ci=48752&pl_id=511915">
				<div class="product-pod-image" style="background-position:-14px -96px;height:45px;"></div>
				<div class="product-pod-details">
					
					
					<h5 class="color_green">E-commerce Solutions</h5>
					<h6>From only $9.99/mo!</h6>
					<p>Get everything you need to build, manage, and market your own successful online store! </p>
				</div>
			</a>
			<a  class="small-12 medium-4 large-4 columns" href="<?=base_url()?>sales?product=domains/search.aspx&ci=48748&pl_id=511915">
				<div class="product-pod-image" style="background-position:-14px 0px;height:50px;"></div>
				<div class="product-pod-details">
					
					
					<h5 class="color_green">Domain Names</h5>
					<h6>From only $8.99/yr!</h6>
					<p>Get your domain name today!   All of our domains are loaded with free extras!</p>
				</div>
			</a>
			<a  class="small-12 medium-4 large-4 columns" href="<?=base_url()?>sales?product=search-engine/seo-services.aspx&ci=48754&pl_id=511915">
				<div class="product-pod-image" style="background-position:-14px -511px;height:46px;"></div>
				<div class="product-pod-details">
					<h5 class="color_green">Web Marketing</h5>
					<p> Attract visitors and increase sales by improving your rank on Google® and more! <br> <strong>Express Email Marketing</strong> - Keep customers coming back for more with eye-catching emails and social media promotions.</p>
				</div>
			</a>
			<a  class="small-12 medium-4 large-4 columns" href="<?=base_url()?>sales?product=hosting/website-builder.aspx&ci=48750&pl_id=511915">
				<div class="product-pod-image" style="background-position:-14px -557px;height:38px;"></div>
				<div class="product-pod-details">
					
					
					<h5 class="color_green">Website Builder</h5>
					<h6>From only $4.05/mo!</h6>
					<p>Grow your business with a beautiful website. Our Design Wizard makes it as easy as drag and drop! Includes all you need to get online.</p>
				</div>
			</a>
			<a  class="small-12 medium-4 large-4 columns" href="<?=base_url()?>sales?product=hosting/web-hosting.aspx&ci=48749&pl_id=511915">
				<div class="product-pod-image" style="background-position:-14px -173px;height:48px;"></div>
				<div class="product-pod-details">
					
					
					<h5 class="color_green">Web Hosting</h5>
					<h6>From only $3.99/mo!</h6>
					<p>Everything you need to give your website the reliable, high-performance home it deserves.</p>
				</div>
			</a>
			<a  class="small-12 medium-4 large-4 columns" href="<?=base_url()?>sales?product=ssl/ssl-certificates.aspx&ci=48761&pl_id=511915">
				<div class="product-pod-image" style="background-position:-14px -460px;height:52px;"></div>
				<div class="product-pod-details">
					
					<h5 class="color_green">Secure SSL Certificates</h5>
					<h6>From only $28.99/yr!</h6>
					<p>Secure your site.  Boost response and customer confidence with an affordable High Assurance SSL Certificate.</p>
				</div>
			</a>
			<a  class="small-12 medium-4 large-4 columns" href="<?=base_url()?>sales?product=hosting/wordpress-hosting.aspx&ci=48755&pl_id=511915">
				<div class="product-pod-image" style="background-position:-14px -595px;height:50px;"></div>
				<div class="product-pod-details">
					<h5 class="color_green">WordPress Hosting</h5>
					<h6>From only $3.99/mo!</h6>
					<p>Harness the combined power of WordPress® and our Web Hosting to create your own personal, state-of-the-art blog.</p>
				</div>
			</a>
			<a  class="small-12 medium-4 large-4 columns" href="<?=base_url()?>sales?product=email/online-storage.aspx&ci=58430&pl_id=511915">
				<div class="product-pod-image" style="background-position:-14px -1044px;height:50px;"></div>
				<div class="product-pod-details">
					
					
					<h5 class="color_green">Online Storage</h5>
					<h6>From only $2.49/mo!</h6>
					<p>Keep your files safe and accessible with our secure cloud storage. Perfect for backing up and sharing important files.</p>
				</div>
			</a>
			<a  class="small-12 medium-4 large-4 columns" href="<?=base_url()?>sales?product=domainaddon/private-registration.aspx&ci=48756&pl_id=511915">
				<div class="product-pod-image" style="background-position:-14px -363px;height:47px;"></div>
				<div class="product-pod-details">
					
					
					<h5 class="color_green">Privacy and Protection</h5>
					<h6>From only $7.95/yr!</h6>
					<p>Make your domain registration private - protect yourself from spam, scams, prying eyes and worse!</p>
				</div>
			</a>

		</div>
	</div>
</div>
<!-- News -->
<div class="row">
	&nbsp;
</div>
<?php $this->load->view('partial/blogList.php'); ?>