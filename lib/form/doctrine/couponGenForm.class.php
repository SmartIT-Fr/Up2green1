<?php

/**
 * couponGen form.
 *
 * @package    up2green
 * @subpackage form
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class couponGenForm extends BasecouponGenForm
{
  public function configure()
  {
      unset($this['created_at'], $this['updated_at']);
  }
}