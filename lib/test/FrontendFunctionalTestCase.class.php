<?php

/**
 * Project class for Functional tests in the frontend application
 *
 * @category Lib
 * @package  Test
 * @author   Clément Gautier <clement.gautier@smartit.fr>
 * @license  http://creativecommons.org/licenses/by-nc-nd/3.0/ CC BY-NC-ND 3.0
 */
class FrontendFunctionalTestCase extends FunctionalTestCase
{
  /**
   * @see FunctionalTestCase
   * @return string 
   */
  public function getApplication()
  {
    return 'frontend';
  }
}
