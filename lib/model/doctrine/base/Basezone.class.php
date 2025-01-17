<?php

/**
 * Basezone
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property string $unique_name
 * @property Doctrine_Collection $zoneContents
 * 
 * @method integer             getId()           Returns the current record's "id" value
 * @method string              getName()         Returns the current record's "name" value
 * @method string              getUniqueName()   Returns the current record's "unique_name" value
 * @method Doctrine_Collection getZoneContents() Returns the current record's "zoneContents" collection
 * @method zone                setId()           Sets the current record's "id" value
 * @method zone                setName()         Sets the current record's "name" value
 * @method zone                setUniqueName()   Sets the current record's "unique_name" value
 * @method zone                setZoneContents() Sets the current record's "zoneContents" collection
 * 
 * @package    up2green
 * @subpackage model
 * @author     Clément Gautier
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Basezone extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('zone');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('name', 'string', 128, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 128,
             ));
        $this->hasColumn('unique_name', 'string', 128, array(
             'type' => 'string',
             'notnull' => true,
             'unique' => true,
             'length' => 128,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('content as zoneContents', array(
             'local' => 'id',
             'foreign' => 'zone_id'));

        $timestampable0 = new Doctrine_Template_Timestampable(array(
             ));
        $this->actAs($timestampable0);
    }
}