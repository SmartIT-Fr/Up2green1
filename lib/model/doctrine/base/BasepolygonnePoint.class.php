<?php

/**
 * BasepolygonnePoint
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $polygonne_id
 * @property polygonne $Polygonne
 * 
 * @method integer        getPolygonneId()  Returns the current record's "polygonne_id" value
 * @method polygonne      getPolygonne()    Returns the current record's "Polygonne" value
 * @method polygonnePoint setPolygonneId()  Sets the current record's "polygonne_id" value
 * @method polygonnePoint setPolygonne()    Sets the current record's "Polygonne" value
 * 
 * @package    up2green
 * @subpackage model
 * @author     Clément Gautier
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasepolygonnePoint extends point
{
    public function setTableDefinition()
    {
        parent::setTableDefinition();
        $this->setTableName('polygonne_point');
        $this->hasColumn('polygonne_id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => 4,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('polygonne as Polygonne', array(
             'local' => 'polygonne_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}