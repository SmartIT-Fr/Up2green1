<?php

/**
 * lien actions.
 *
 * @package    up2green
 * @subpackage lien
 * @author     Clément Gautier
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class lienComponents extends sfComponents
{
  public function executeFooterPanel()
  {
/*
  	$this->footerCategories = Doctrine::getTable('categorie')
  		->createQuery('c')
  		->where('c.is_active = true')
  		->where('c.unique_name = "footer"')
  		->execute();
*/
  }
}
