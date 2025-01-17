<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Addcategory extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createTable('category', array(
             'id' => 
             array(
              'type' => 'integer',
              'primary' => true,
              'autoincrement' => true,
              'length' => 4,
             ),
             'unique_name' => 
             array(
              'type' => 'string',
              'unique' => true,
              'length' => 30,
             ),
             'rank' => 
             array(
              'type' => 'integer',
              'notnull' => true,
              'default' => 1,
              'length' => 4,
             ),
             'is_active' => 
             array(
              'type' => 'boolean',
              'default' => 1,
              'length' => 25,
             ),
             'root_id' => 
             array(
              'type' => 'integer',
              'length' => 8,
             ),
             'lft' => 
             array(
              'type' => 'integer',
              'length' => 4,
             ),
             'rgt' => 
             array(
              'type' => 'integer',
              'length' => 4,
             ),
             'level' => 
             array(
              'type' => 'integer',
              'length' => 2,
             ),
             ), array(
             'indexes' => 
             array(
             ),
             'primary' => 
             array(
              0 => 'id',
             ),
             'charset' => 'UTF8',
             ));
    }

    public function down()
    {
        $this->dropTable('category');
    }
}