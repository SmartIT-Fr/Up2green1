<?php

/**
 * organisme filter form.
 *
 * @package    up2green
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class organismeFormFilter extends BaseorganismeFormFilter {
    public function configure() {
        $this->widgetSchema['created_at'] = new sfWidgetFormDateRange(array(
                        'from_date' =>  new sfWidgetFormJQueryDate(array(
                                'image'=>'/images/calendar.png',
                        )),
                        'to_date'   =>  new sfWidgetFormJQueryDate(array(
                                'image'=>'/images/calendar.png',
                        )),
                        'template'  => 'From %from_date%<br />To %to_date%',
        ));
        $this->widgetSchema['updated_at'] = new sfWidgetFormDateRange(array(
                        'from_date' =>  new sfWidgetFormJQueryDate(array(
                                'image'=>'/images/calendar.png',
                        )),
                        'to_date'   =>  new sfWidgetFormJQueryDate(array(
                                'image'=>'/images/calendar.png',
                        )),
                        'template'  => 'From %from_date%<br />To %to_date%',
        ));
    }
}
