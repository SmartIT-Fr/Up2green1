<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version52 extends Doctrine_Migration_Base
{
    public function up()
    {
				$this->dropForeignKey('engine', 'engine_id_devise_devise_id');
        $this->dropTable('devise');
        $this->removeColumn('engine', 'id_devise');
        $this->addColumn('engine', 'currency_id', 'integer', '11', array(
             'notnull' => '1',
             'default' => '34',
             'unsigned' => '1',
             ));
    }

    public function down()
    {
        $this->createTable('devise', array(
             'id' => 
             array(
              'type' => 'integer',
              'primary' => '1',
              'autoincrement' => '1',
              'length' => '4',
             ),
             'unique_name' => 
             array(
              'type' => 'string',
              'unique' => '1',
              'length' => '30',
             ),
             'conversion' => 
             array(
              'type' => 'double',
              'notnull' => '1',
              'length' => '18',
              'scale' => '10',
             ),
             'created_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             'updated_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             ), array(
             'type' => '',
             'indexes' => 
             array(
             ),
             'primary' => 
             array(
              0 => 'id',
             ),
             'collate' => '',
             'charset' => '',
             ));
        $this->addColumn('engine', 'id_devise', 'integer', '11', array(
             'notnull' => '1',
             ));
        $this->removeColumn('engine', 'currency_id');
				$this->createForeignKey('engine', 'engine_id_devise_devise_id', array(
             'name' => 'engine_id_devise_devise_id',
             'local' => 'id_devise',
             'foreign' => 'id',
             'foreignTable' => 'devise',
             ));
    }
}