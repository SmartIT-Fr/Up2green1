<?php
/*
 * Copyright 2010 Johannes M. Schmitt
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */


/**
 * PluginCurrencyTable
 * 
 * @package jmsPaymentPlugin
 * @subpackage model
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
class PluginCurrencyTable extends Doctrine_Table
{
  /**
   * Local cache for currencies
   * @var array
   */
  private $_currencies;

  /**
   * Returns an array of currency instances where the keys are the
   * respective currency codes.
   * 
   * @return array
   */
  public final function getCurrencies()
  {
    if ($this->_currencies === null)
    {
      // TODO: This can be cached
      $this->_currencies = Doctrine_Query::create()
                            ->from('Currency c INDEXBY c.code')
                            ->execute()
                            ->getData();
    }
    
    return $this->_currencies;
  }
  
  /**
   * Returns the currency for the given code
   * 
   * @param string $code a currency code, e.g. EUR
   * @return Currency
   */
  public final function getCurrency($code)
  {
    $currencies = $this->getCurrencies();
    if (!isset($currencies[$code]))
      throw new InvalidArgumentException(sprintf(
        'The currency "%s" does not exist. Valids: %s', $code, 
        implode(', ', array_keys($currencies))));
    
    return $currencies[$code];
  }
  
  /**
   * Converts the amount from one currency to another using the current rate.
   * 
   * @param mixed $amount any value that can correctly be converted a float
   * @param string $from The currency code to convert from
   * @param string $to The target currency code
   * @return float
   */
  public final function convertAmount($amount, $from, $to)
  {
    $amount = floatval($amount);
    
    if ($from === $to)
      return $amount;
    
    $from = $this->getCurrency($from);
    $to = $this->getCurrency($to);
    
    return $amount / $from->rate * $to->rate;
  }

  /**
   * Returns an instance of this class.
   *
   * @return object PluginCurrencyTable
   */
  public static function getInstance()
  {
    return Doctrine_Core::getTable('PluginCurrency');
  }
}