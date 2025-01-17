<?php
use_stylesheet('marketing/vedif.css?v='.sfConfig::get('app_media_version'));
$nbArbres = str_pad(($nbArbres - 180), 5, "0", STR_PAD_LEFT);
?>

<div id="content">
  <h1 id="header">
    <?php echo image_tag('marketing/vedif/header.jpg', array(
      'alt' => "Pour une terre qui respire"
    ))?>
  </h1>
  <table id="content-inner">
    <tr>
      <td id="content-inner-left">
        <a target="_blank" href="<?php echo sfConfig::get('app_url_moteur') ?>">
          <img src="/images/logo/200x200/earth-hand.png" alt="Logo Up2green"/>
        </a>
        <div id="compteur">
          <div class="chiffre"><?php echo $nbArbres[0] ?></div>
          <div class="chiffre"><?php echo $nbArbres[1] ?></div>
          <div class="chiffre"><?php echo $nbArbres[2] ?></div>
          <div class="chiffre"><?php echo $nbArbres[3] ?></div>
          <div class="chiffre"><?php echo $nbArbres[4] ?></div>
        </div>
        <img src="/images/marketing/vedif/main.png" alt="Image main"/>
      </td>
      <td id="content-inner-center">
        <h2 class="accroche">
          Bienvenue sur la plateforme de reforestation<br /> du Service public de l'eau<br /> du Syndicat des Eaux d'Ile-de-France<br /> et de son délégataire<br /> Veolia Eau d'Ile-de-France
        </h2>
        
        <h3 class="accroche">
          <?php echo link_to("Découvrez les programmes de plantation soutenus.", '/landing/partenaire/vedif/decouverte'); ?>
        </h3>
        <!-- module content -->
        <div class="module">
          <div class="content">
            <h3>Si vous disposez d'un coupon,<br /> <span class="black">saisissez ici votre numéro de coupon</span><br /> et participez à la plantation des arbres,<br /> en choisissant un programme.</h3>

            <form action="<?php echo sfConfig::get('app_url_plantation'); ?>" method="post">
              <p>
                <input type="text" name="code" placeholder="Numéro de coupon" />
                <input type="submit" class="button green medium" name="numCouponToUse" value="Plantez" />
                <input type="hidden" name="fromUrl" value="<?php echo sfConfig::get('app_url_plantation'); ?>landing/plantation/vedif/special" />
                <input type="hidden" name="redirectUrl" value="<?php echo sfConfig::get('app_url_plantation'); ?>landing/map/vedif" />
              </p>
            </form>

          </div>
        </div>
        <p id="linkToMoreInfo"><?php echo link_to("Vers un service public de l'eau neutre en carbone : en savoir plus", '/landing/pagePartenaire/vedif'); ?></p>
      </td>
      <td id="content-inner-right">
        <?php echo link_to(image_tag('marketing/vedif/sedif.jpg', array('class' => 'logo', 'alt' => "Logo Sedif")), 'http://www.sedif.com/'); ?>
        <?php echo image_tag('marketing/vedif/veolia.jpg', array('class' => 'logo', 'alt' => "Logo Veolia")); ?>
        
        <div id="but">
          <p>Plantation de<br />142 000 arbres en 2011,<br /> année internationale<br /> des forêts.</p>
          <br />
          <p>Jusqu’à 500 000 arbres par an à partir de 2012.</p>
        </div>
      </td>
    </tr>
  </table>
  <div class="clear"></div>
</div>
