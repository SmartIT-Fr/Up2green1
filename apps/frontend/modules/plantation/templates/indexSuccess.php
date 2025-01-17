<div id="body">
	<div id="center">
		<!-- module -->
		<div id="gmapWrapper" class="module" style="position:relative;" >
			<img class="title corner left" src="/images/module/green/icon/program.png" alt="" />
			<p class="title"><?php echo __("Les programmes de reforestation que nous soutenons") ?></p>
			<div class="content">
				<?php include_partial('formGMap', array(
						'canPlant' => ($nbArbresToPlant > 0),
						'partenaire' => $partenaire
				)); ?>
				<div class="clear"></div>
			</div>
			<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
		</div>
	</div>
	
	<div id="left">
	<?php if(!isset($coupon) && is_null($partenaire)) {include_partial('logo');} ?>
	
	<?php 
	if(isset($coupon) or $sf_user->isAuthenticated()) {
		include_partial('formPlant', array(
			'fromUrl' => $fromUrl, 
			'redirectUrl' => $redirectUrl,
			'coupon' => isset($coupon) ? $coupon : NULL, 
			'nbArbresToPlant' => $nbArbresToPlant, 
			'programmes' => $programmes
		));
	}
	
	if(!isset($coupon)) {
		include_partial('formCoupon');
	}

	if(!is_null($partenaire)) {
		include_partial('partenaire/module', array(
			'moduleClass'	=> 'purple',
			'displayIcon'	=> true,
			'displayTitle'	=> true,
			'partenaire'	=> $partenaire
		));
	}
	elseif(!$sf_user->isAuthenticated()) {
	    include_partial('formInscription', array());
	}
	
	?>
    </div>
</div>
