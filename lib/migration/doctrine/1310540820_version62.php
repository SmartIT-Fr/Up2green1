<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version62 extends Doctrine_Migration_Base
{
    public function up()
	{
		$this->dropForeignKey('partenaire_programme', 'partenaire_programme_partenaire_id_partenaire_id');
		$this->dropForeignKey('partenaire_programme', 'partenaire_programme_programme_id_programme_id');
		
		// Remove primary constraint
		$this->dropConstraint('partenaire_programme', null, true);
	}

    public function down()
	{
		$this->createForeignKey('partenaire_programme', 'partenaire_programme_partenaire_id_partenaire_id', array(
             'name' => 'partenaire_programme_partenaire_id_partenaire_id',
             'local' => 'partenaire_id',
             'foreign' => 'id',
             'foreignTable' => 'partenaire',
             'onUpdate' => '',
             'onDelete' => 'CASCADE',
             ));
        $this->createForeignKey('partenaire_programme', 'partenaire_programme_programme_id_programme_id', array(
             'name' => 'partenaire_programme_programme_id_programme_id',
             'local' => 'programme_id',
             'foreign' => 'id',
             'foreignTable' => 'programme',
             'onUpdate' => '',
             'onDelete' => 'CASCADE',
		));
    }
}
