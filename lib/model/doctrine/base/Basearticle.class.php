<?php

/**
 * Basearticle
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $category_id
 * @property string $title
 * @property clob $accroche
 * @property clob $description
 * @property string $logo
 * @property boolean $is_active
 * @property integer $rank
 * @property category $Category
 * 
 * @method integer  getId()          Returns the current record's "id" value
 * @method integer  getCategoryId()  Returns the current record's "category_id" value
 * @method string   getTitle()       Returns the current record's "title" value
 * @method clob     getAccroche()    Returns the current record's "accroche" value
 * @method clob     getDescription() Returns the current record's "description" value
 * @method string   getLogo()        Returns the current record's "logo" value
 * @method boolean  getIsActive()    Returns the current record's "is_active" value
 * @method integer  getRank()        Returns the current record's "rank" value
 * @method category getCategory()    Returns the current record's "Category" value
 * @method article  setId()          Sets the current record's "id" value
 * @method article  setCategoryId()  Sets the current record's "category_id" value
 * @method article  setTitle()       Sets the current record's "title" value
 * @method article  setAccroche()    Sets the current record's "accroche" value
 * @method article  setDescription() Sets the current record's "description" value
 * @method article  setLogo()        Sets the current record's "logo" value
 * @method article  setIsActive()    Sets the current record's "is_active" value
 * @method article  setRank()        Sets the current record's "rank" value
 * @method article  setCategory()    Sets the current record's "Category" value
 * 
 * @package    up2green
 * @subpackage model
 * @author     Clément Gautier
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Basearticle extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('article');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('category_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('title', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('accroche', 'clob', 65535, array(
             'type' => 'clob',
             'length' => 65535,
             ));
        $this->hasColumn('description', 'clob', 65535, array(
             'type' => 'clob',
             'length' => 65535,
             ));
        $this->hasColumn('logo', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('is_active', 'boolean', null, array(
             'type' => 'boolean',
             'default' => 0,
             ));
        $this->hasColumn('rank', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => 1,
             'length' => 4,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('category as Category', array(
             'local' => 'category_id',
             'foreign' => 'id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $i18n0 = new Doctrine_Template_I18n(array(
             'fields' => 
             array(
              0 => 'title',
              1 => 'accroche',
              2 => 'description',
             ),
             ));
        $sluggable1 = new Doctrine_Template_Sluggable(array(
             'fields' => 
             array(
              0 => 'title',
             ),
             'uniqueBy' => 
             array(
              0 => 'lang',
              1 => 'title',
             ),
             ));
        $i18n0->addChild($sluggable1);
        $this->actAs($timestampable0);
        $this->actAs($i18n0);
    }
}