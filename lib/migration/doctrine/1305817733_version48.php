<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version48 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createForeignKey('programme_polygonne', 'programme_polygonne_polygonne_id_polygonne_id', array(
             'name' => 'programme_polygonne_polygonne_id_polygonne_id',
             'local' => 'polygonne_id',
             'foreign' => 'id',
             'foreignTable' => 'polygonne',
             'onUpdate' => '',
             'onDelete' => 'CASCADE',
             ));
        $this->addIndex('programme_polygonne', 'programme_polygonne_polygonne_id', array(
             'fields' => 
             array(
              0 => 'polygonne_id',
             ),
             ));
    }

    public function down()
    {
        $this->dropForeignKey('programme_polygonne', 'programme_polygonne_polygonne_id_polygonne_id');
        $this->removeIndex('programme_polygonne', 'programme_polygonne_polygonne_id', array(
             'fields' => 
             array(
              0 => 'polygonne_id',
             ),
             ));
    }
}