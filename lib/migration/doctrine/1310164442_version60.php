<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version60 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('partenaire_programme', 'number', 'integer', '8', array(
             'default' => '0',
             'notnull' => '1',
		 ));
        $this->addColumn('partenaire_programme', 'hardcode', 'integer', '8', array(
             'default' => '0',
             'notnull' => '1',
		 ));

    }

    public function down()
    {
		$this->removeColumn('partenaire_programme', 'number');
		$this->removeColumn('partenaire_programme', 'hardcode');

    }
}
