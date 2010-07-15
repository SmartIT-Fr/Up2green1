<?php

/**
 * newsletter filter form base class.
 *
 * @package    up2green
 * @subpackage filter
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BasenewsletterFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'unique_name' => new sfWidgetFormFilterInput(),
      'reply_to'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'email_from'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'is_forced'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'sent_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'created_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'unique_name' => new sfValidatorPass(array('required' => false)),
      'reply_to'    => new sfValidatorPass(array('required' => false)),
      'email_from'  => new sfValidatorPass(array('required' => false)),
      'is_forced'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'sent_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'created_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('newsletter_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'newsletter';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'unique_name' => 'Text',
      'reply_to'    => 'Text',
      'email_from'  => 'Text',
      'is_forced'   => 'Number',
      'sent_at'     => 'Date',
      'created_at'  => 'Date',
      'updated_at'  => 'Date',
    );
  }
}
