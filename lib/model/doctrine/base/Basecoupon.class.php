<?php

/**
 * Basecoupon
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $code
 * @property integer $credit
 * @property boolean $is_active
 * @property boolean $is_used
 * @property timestamp $used_at
 * @property integer $used_by
 * @property Doctrine_Collection $CouponUser
 * 
 * @method integer             getId()         Returns the current record's "id" value
 * @method string              getCode()       Returns the current record's "code" value
 * @method integer             getCredit()     Returns the current record's "credit" value
 * @method boolean             getIsActive()   Returns the current record's "is_active" value
 * @method boolean             getIsUsed()     Returns the current record's "is_used" value
 * @method timestamp           getUsedAt()     Returns the current record's "used_at" value
 * @method integer             getUsedBy()     Returns the current record's "used_by" value
 * @method Doctrine_Collection getCouponUser() Returns the current record's "CouponUser" collection
 * @method coupon              setId()         Sets the current record's "id" value
 * @method coupon              setCode()       Sets the current record's "code" value
 * @method coupon              setCredit()     Sets the current record's "credit" value
 * @method coupon              setIsActive()   Sets the current record's "is_active" value
 * @method coupon              setIsUsed()     Sets the current record's "is_used" value
 * @method coupon              setUsedAt()     Sets the current record's "used_at" value
 * @method coupon              setUsedBy()     Sets the current record's "used_by" value
 * @method coupon              setCouponUser() Sets the current record's "CouponUser" collection
 * 
 * @package    up2green
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Basecoupon extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('coupon');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('code', 'string', 128, array(
             'type' => 'string',
             'unique' => true,
             'notnull' => true,
             'length' => 128,
             ));
        $this->hasColumn('credit', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => 1,
             'length' => 4,
             ));
        $this->hasColumn('is_active', 'boolean', null, array(
             'type' => 'boolean',
             'default' => 1,
             ));
        $this->hasColumn('is_used', 'boolean', null, array(
             'type' => 'boolean',
             'default' => 0,
             ));
        $this->hasColumn('used_at', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('used_by', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('user_coupon as CouponUser', array(
             'local' => 'id',
             'foreign' => 'coupon_id'));

        $timestampable0 = new Doctrine_Template_Timestampable(array(
             ));
        $this->actAs($timestampable0);
    }
}