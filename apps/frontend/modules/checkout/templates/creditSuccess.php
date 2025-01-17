<?php include_component('user', 'menuProfil'); ?>
<?php include_partial('checkout/steps', array(
	'currentStep' => $step,
	'availableSteps' => array(
			'choice' => array(
					'title' => __("Votre choix"),
					'subtitle' => __("Choisissez votre nombre de crédits"),
			),
			'buy' => array(
					'title' => __("Paiement"),
					'subtitle' => __("Choix du mode de paiement"),
			),
			'complete' => array(
					'title' => __("Finalisation"),
					'subtitle' => __("Nous ajoutons vos crédits à votre compte"),
			)
		)
	)
); ?>

<div class="module grey" style="width:700px;float:right;">
	<div class="content center notitle">
		<?php include_partial('formCredit'.  ucfirst($step), $vars);	?>		
	</div>
	<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>
