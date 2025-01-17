<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Addlogcoupon extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createTable('log_coupon', array(
             'id' => 
             array(
              'type' => 'integer',
              'primary' => true,
              'autoincrement' => true,
              'length' => 4,
             ),
             'ip' => 
             array(
              'type' => 'string',
              'notnull' => true,
              'length' => 15,
             ),
             'email' => 
             array(
              'type' => 'string',
              'length' => 50,
             ),
             'coupon_id' => 
             array(
              'type' => 'integer',
              'notnull' => true,
              'unique' => true,
              'length' => 4,
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
        $this->dropTable('log_coupon');
    }
}