<?php

/**
 * BasepartenaireUser
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $partenaire_id
 * @property integer $user_id
 * @property sfGuardUser $sfGuardUser
 * @property partenaire $partenaire
 * 
 * @method integer        getPartenaireId()  Returns the current record's "partenaire_id" value
 * @method integer        getUserId()        Returns the current record's "user_id" value
 * @method sfGuardUser    getSfGuardUser()   Returns the current record's "sfGuardUser" value
 * @method partenaire     getPartenaire()    Returns the current record's "partenaire" value
 * @method partenaireUser setPartenaireId()  Sets the current record's "partenaire_id" value
 * @method partenaireUser setUserId()        Sets the current record's "user_id" value
 * @method partenaireUser setSfGuardUser()   Sets the current record's "sfGuardUser" value
 * @method partenaireUser setPartenaire()    Sets the current record's "partenaire" value
 * 
 * @package    up2green
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasepartenaireUser extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('partenaire_user');
        $this->hasColumn('partenaire_id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => 4,
             ));
        $this->hasColumn('user_id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => 4,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('sfGuardUser', array(
             'local' => 'user_id',
             'foreign' => 'id'));

        $this->hasOne('partenaire', array(
             'local' => 'partenaire_id',
             'foreign' => 'id'));
    }
}