<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Addengine extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createTable('engine', array(
             'id' => 
             array(
              'type' => 'integer',
              'primary' => true,
              'autoincrement' => true,
              'length' => 4,
             ),
             'id_category' => 
             array(
              'type' => 'integer',
              'notnull' => true,
              'length' => 4,
             ),
             'id_plateforme' => 
             array(
              'type' => 'integer',
              'notnull' => true,
              'length' => 4,
             ),
             'id_devise' => 
             array(
              'type' => 'integer',
              'notnull' => true,
              'length' => 4,
             ),
             'site_display' => 
             array(
              'type' => 'string',
              'notnull' => true,
              'length' => 128,
             ),
             'site_url' => 
             array(
              'type' => 'string',
              'notnull' => true,
              'length' => 128,
             ),
             'html' => 
             array(
              'type' => 'clob',
              'length' => NULL,
             ),
             'logo' => 
             array(
              'type' => 'clob',
              'length' => NULL,
             ),
             'description' => 
             array(
              'type' => 'clob',
              'length' => NULL,
             ),
             'remun_type' => 
             array(
              'type' => 'enum',
              'values' => 
              array(
              0 => 'number',
              1 => 'pourcent',
              2 => 'price',
              ),
              'default' => 'number',
              'length' => NULL,
             ),
             'remun_min' => 
             array(
              'type' => 'float',
              'notnull' => true,
              'default' => 0,
              'length' => NULL,
             ),
             'remun_max' => 
             array(
              'type' => 'float',
              'notnull' => true,
              'length' => NULL,
             ),
             'safe_search_only' => 
             array(
              'type' => 'boolean',
              'default' => 0,
              'length' => 25,
             ),
             'is_active' => 
             array(
              'type' => 'boolean',
              'default' => 1,
              'length' => 25,
             ),
             'created_at' => 
             array(
              'notnull' => true,
              'type' => 'timestamp',
              'length' => 25,
             ),
             'updated_at' => 
             array(
              'notnull' => true,
              'type' => 'timestamp',
              'length' => 25,
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
        $this->dropTable('engine');
    }
}