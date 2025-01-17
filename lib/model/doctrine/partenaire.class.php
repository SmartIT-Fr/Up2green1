<?php

/**
 * partenaire
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    up2green
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class partenaire extends Basepartenaire
{

  public function generateCoupons($nb, couponGen $couponGen, $prefix = '')
  {
    $tab = array();
    for ($i = 0; $i < $nb; $i++) {
      $num    = libCoupon::getCodeUnused($prefix);
      $coupon = new coupon();
      $coupon->setCouponGen($couponGen);
      $coupon->setCode($num);
      $coupon->save();

      $jointure = new couponPartenaire();
      $jointure->setPartenaire($this);
      $jointure->setCoupon($coupon);

      $jointure->save();

      $tab[] = $num;
    }
    return $tab;
  }

}
