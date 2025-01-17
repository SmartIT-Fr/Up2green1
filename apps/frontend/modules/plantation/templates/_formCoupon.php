<div id="form_programme_plantation" class="module">
	<img class="title corner left" src="/images/module/green/icon/coupon.png" alt="" />
	<p class="title"><?php echo __("Utiliser un coupon") ?></p>
	<div class="content">
		<p>
			<?php echo __("Choisissez où planter vos arbres sur la planète en saisissant votre code dès maintenant !") ?>
      <?php if (!isset ($withHelp) || $withHelp) : ?>
			<img tooltiped="true" title="<?php echo __("Si l'un de nos partenaires entreprises ou collectivités vous a offert un coupon reforestation saisissez le code ici. Les arbres correspondant s'incrémenteront automatiquement dans votre compte Up2green.") ?>" src="/images/icons/16x16/consulting.png" />
      <?php endif; ?>
		</p>
    
    <form action="<?php echo url_for('@plantation_confirmation') ?>" method="post">
      <p class="center"><input type="text" name="code" placeholder="<?php echo __("Numéro de coupon") ?>" /></p>
      <p class="center"><input type="submit" class="button white" value="<?php echo __("Utiliser") ?>" /></p>
      <?php if (isset ($fromUrl) && !empty ($fromUrl)) : ?>
      <input type="hidden" value="<?php echo $fromUrl; ?>" name="fromUrl" />
      <?php endif; ?>
      <?php if (isset ($redirectUrl) && !empty ($redirectUrl)) : ?>
      <input type="hidden" value="<?php echo $redirectUrl; ?>" name="redirectUrl" />
      <?php endif; ?>
		</form>

	</div>
	<?php include_partial('global/border_and_corner') ?>
</div>
