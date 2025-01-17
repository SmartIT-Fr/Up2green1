<?php

/**
 * article form.
 *
 * @category Lib
 * @package  Form
 * @author   Clément Gautier <clement.gautier@smartit.fr>
 * @license  http://creativecommons.org/licenses/by-nc-nd/3.0/ CC BY-NC-ND 3.0
 */
class articleForm extends BasearticleForm
{

  public function configure()
  {
    unset(
      $this['created_at'], $this['updated_at']
    );

    $this->widgetSchema['logo'] = new sfWidgetFormInputFileEditable(array(
        'label'     => 'Logo',
        'file_src'  => '/uploads/article/' . $this->getObject()->getLogo(),
        'is_image'  => true,
        'edit_mode' => !$this->isNew(),
        'template'  => '<div>%file%<br />%input%<br />%delete% %delete_label%</div>',
      ));

    $this->validatorSchema['logo'] = new sfValidatorFile(array(
        'required'   => false,
        'path'       => sfConfig::get('sf_upload_dir') . '/article',
        'mime_types' => 'web_images',
      ));

    $this->widgetSchema['category_id'] = new sfWidgetFormDoctrineChoice(array(
        'model'     => 'category',
        'add_empty' => '~ (object is at root level)',
        'order_by'  => array('root_id, lft', ''),
        'method' => 'getIndentedName'
      ));

    $this->validatorSchema['category_id'] = new sfValidatorDoctrineChoice(array(
        'required' => false,
        'model'    => 'category'
      ));

    $this->languages = sfConfig::get('app_cultures_enabled');
    $langs = array_keys($this->languages);

    $this->embedI18n($langs);
    foreach ($this->languages as $lang => $label) {
      $this->widgetSchema[$lang]->setLabel($label);
    }
  }
}
