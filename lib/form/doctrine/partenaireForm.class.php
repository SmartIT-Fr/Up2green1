<?php

/**
 * partenaire form.
 *
 * @category Lib
 * @package  Form
 * @author   Clément Gautier <clement.gautier@smartit.fr>
 * @license  http://creativecommons.org/licenses/by-nc-nd/3.0/ CC BY-NC-ND 3.0
 */
class partenaireForm extends BasepartenaireForm
{
  protected $canEmbedProgramme      = true;
  protected $canEmbedLogo           = true;
  public static $defaultAttestationPath = '/images/pdf/attestation-02.png';

  public function configure()
  {
    $attestationPath = $this->getObject()->getAttestation();

    $this->widgetSchema['attestation'] = new sfWidgetFormInputFileEditable(array(
        'file_src'    => empty($attestationPath) ? self::$defaultAttestationPath : '/uploads/partenaire/' . $attestationPath,
        'is_image'    => true,
        'edit_mode'   => !$this->isNew(),
        'with_delete' => !empty($attestationPath),
        'template'    => '<div class="attestation-wrapper">%file%</div>%input%<br />%delete% %delete_label%',
      ));

    $this->widgetSchema['description'] = new sfWidgetFormCKEditor();
    $this->widgetSchema['page'] = new sfWidgetFormCKEditor();

    $this->validatorSchema['attestation'] = new up2gValidatorImage(array(
        'max_size'   => 1048576,
        'required'   => false,
        'path'       => sfConfig::get('sf_upload_dir') . '/partenaire',
        'mime_types' => 'web_images',
        'minx'       => 842,
        'miny'       => 595,
        'maxx'       => 842,
        'maxy'       => 595,
      ));

    if (!empty($attestationPath))
    {
      $this->validatorSchema['attestation_delete'] = new sfValidatorPass();
    }

    $this->widgetSchema['accroche'] = new sfWidgetFormCKEditor(array('jsoptions' => array(
          'height'  => '75px',
          'toolbar' => 'Basic'
        )));

    if ($this->canEmbedProgramme || $this->canEmbedLogo)
    {
      $embed = array();
      if ($this->canEmbedProgramme)
      {
        $embed['Programmes'] = array(
          'considerNewFormEmptyFields' => array('programme_id'),
          'newFormLabel'         => 'Nouvelle participation à un programme',
          'multipleNewForms'     => true,
          'newFormsInitialCount' => 1,
        );
      }

      if ($this->canEmbedLogo)
      {
        $embed['Logos'] = array(
          'considerNewFormEmptyFields' => array('src', 'href'),
          'newFormLabel'        => 'Ajouter un logo',
          'multipleNewForms'    => true,
          'newFormInitialCount' => 0
        );
      }
      $this->embedRelations($embed);
    }

    $this->removeFields();
  }

  protected function removeFields()
  {
    unset($this['created_at'], $this['updated_at']);
  }

}
