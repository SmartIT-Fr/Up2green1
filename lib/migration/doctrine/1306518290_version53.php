<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version53 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addIndex('engine', 'engine_currency_id', array(
             'fields' => 
             array(
              0 => 'currency_id',
             ),
             ));
//				@TODO: la remettre dans une prochaine migration, pb d'insertion avec FK
//        $this->createForeignKey('engine', 'engine_currency_id_currencies_id', array(
//             'name' => 'engine_currency_id_currencies_id',
//             'local' => 'currency_id',
//             'foreign' => 'id',
//             'foreignTable' => 'currencies',
//             ));
    }

    public function down()
    {
//        $this->dropForeignKey('engine', 'engine_currency_id_currencies_id');
        $this->removeIndex('engine', 'engine_currency_id', array(
             'fields' => 
             array(
              0 => 'currency_id',
             ),
             ));
    }
}