<?php

/**
 * Basepolygonne
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $unique_name
 * @property Doctrine_Collection $Points
 * @property Doctrine_Collection $programmePolygonne
 * @property Doctrine_Collection $Programmes
 * 
 * @method integer             getId()                 Returns the current record's "id" value
 * @method string              getUniqueName()         Returns the current record's "unique_name" value
 * @method Doctrine_Collection getPoints()             Returns the current record's "Points" collection
 * @method Doctrine_Collection getProgrammePolygonne() Returns the current record's "programmePolygonne" collection
 * @method Doctrine_Collection getProgrammes()         Returns the current record's "Programmes" collection
 * @method polygonne           setId()                 Sets the current record's "id" value
 * @method polygonne           setUniqueName()         Sets the current record's "unique_name" value
 * @method polygonne           setPoints()             Sets the current record's "Points" collection
 * @method polygonne           setProgrammePolygonne() Sets the current record's "programmePolygonne" collection
 * @method polygonne           setProgrammes()         Sets the current record's "Programmes" collection
 * 
 * @package    up2green
 * @subpackage model
 * @author     Clément Gautier
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Basepolygonne extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('polygonne');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('unique_name', 'string', 30, array(
             'type' => 'string',
             'unique' => true,
             'notnull' => true,
             'length' => 30,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('polygonnePoint as Points', array(
             'local' => 'id',
             'foreign' => 'polygonne_id'));

        $this->hasMany('programmePolygonne', array(
             'local' => 'id',
             'foreign' => 'polygonne_id'));

        $this->hasMany('programme as Programmes', array(
             'refClass' => 'programmePolygonne',
             'local' => 'polygonne_id',
             'foreign' => 'programme_id'));
    }
}