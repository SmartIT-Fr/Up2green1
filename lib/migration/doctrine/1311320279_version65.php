<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version65 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->changeColumn('organisme_translation', 'accroche', 'clob', '65535', array(
             ));
    }

    public function down()
    {

    }
}