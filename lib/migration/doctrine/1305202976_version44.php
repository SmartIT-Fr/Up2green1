<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version44 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createForeignKey('organisme', 'organisme_point_id_point_id', array(
             'name' => 'organisme_point_id_point_id',
             'local' => 'point_id',
             'foreign' => 'id',
             'foreignTable' => 'point',
             ));
        $this->createForeignKey('polygonne_point', 'polygonne_point_polygonne_id_polygonne_id', array(
             'name' => 'polygonne_point_polygonne_id_polygonne_id',
             'local' => 'polygonne_id',
             'foreign' => 'id',
             'foreignTable' => 'polygonne',
             'onUpdate' => '',
             'onDelete' => 'CASCADE',
             ));
        $this->createForeignKey('polygonne_point', 'polygonne_point_point_id_point_id', array(
             'name' => 'polygonne_point_point_id_point_id',
             'local' => 'point_id',
             'foreign' => 'id',
             'foreignTable' => 'point',
             'onUpdate' => '',
             'onDelete' => 'CASCADE',
             ));
        $this->createForeignKey('programme', 'programme_point_id_point_id', array(
             'name' => 'programme_point_id_point_id',
             'local' => 'point_id',
             'foreign' => 'id',
             'foreignTable' => 'point',
             ));
        $this->createForeignKey('programme_polygonne', 'programme_polygonne_programme_id_programme_id', array(
             'name' => 'programme_polygonne_programme_id_programme_id',
             'local' => 'programme_id',
             'foreign' => 'id',
             'foreignTable' => 'programme',
             'onUpdate' => '',
             'onDelete' => 'CASCADE',
             ));
        $this->addIndex('organisme', 'organisme_point_id', array(
             'fields' => 
             array(
              0 => 'point_id',
             ),
             ));
        $this->addIndex('polygonne_point', 'polygonne_point_polygonne_id', array(
             'fields' => 
             array(
              0 => 'polygonne_id',
             ),
             ));
        $this->addIndex('polygonne_point', 'polygonne_point_point_id', array(
             'fields' => 
             array(
              0 => 'point_id',
             ),
             ));
        $this->addIndex('programme', 'programme_point_id', array(
             'fields' => 
             array(
              0 => 'point_id',
             ),
             ));
        $this->addIndex('programme_polygonne', 'programme_polygonne_programme_id', array(
             'fields' => 
             array(
              0 => 'programme_id',
             ),
             ));
    }

    public function down()
    {
        $this->dropForeignKey('organisme', 'organisme_point_id_point_id');
        $this->dropForeignKey('polygonne_point', 'polygonne_point_polygonne_id_polygonne_id');
        $this->dropForeignKey('polygonne_point', 'polygonne_point_point_id_point_id');
        $this->dropForeignKey('programme', 'programme_point_id_point_id');
        $this->dropForeignKey('programme_polygonne', 'programme_polygonne_programme_id_programme_id');
        $this->removeIndex('organisme', 'organisme_point_id', array(
             'fields' => 
             array(
              0 => 'point_id',
             ),
             ));
        $this->removeIndex('polygonne_point', 'polygonne_point_polygonne_id', array(
             'fields' => 
             array(
              0 => 'polygonne_id',
             ),
             ));
        $this->removeIndex('polygonne_point', 'polygonne_point_point_id', array(
             'fields' => 
             array(
              0 => 'point_id',
             ),
             ));
        $this->removeIndex('programme', 'programme_point_id', array(
             'fields' => 
             array(
              0 => 'point_id',
             ),
             ));
        $this->removeIndex('programme_polygonne', 'programme_polygonne_programme_id', array(
             'fields' => 
             array(
              0 => 'programme_id',
             ),
             ));
    }
}