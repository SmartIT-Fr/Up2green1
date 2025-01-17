<?php

/**
 * profil
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    up2green
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class profil extends Baseprofil
{

	public function addCredit($value) {
		$this->setCredit($this->getCredit() + (float)$value);
		$this->save();
		
		// test s'il a un parrain
		$parrain = $this->getUser()->getParrain();
		if(!$parrain->isNew()) {
			$parrain->getParrain()->getProfile()->addCredit(((float)$value)*sfConfig::get('app_gain_parrain'));
			$parrain->getParrain()->getProfile()->save();
		}
	}
	
}