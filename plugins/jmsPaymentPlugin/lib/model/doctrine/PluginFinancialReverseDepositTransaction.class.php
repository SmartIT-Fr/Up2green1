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
 * PluginFinancialReverseDepositTransaction
 * 
 * @package    jmsPaymentPlugin
 * @subpackage model
 * @author     Johannes M. Schmitt <schmittjoh@gmail.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class PluginFinancialReverseDepositTransaction extends BaseFinancialReverseDepositTransaction
{
  protected final function doExecute()
  {
    $data = $this->getPaymentMethodData();
    $method = $this->getPaymentMethodInstance();
    
    $method->reverseDeposit($data);
    
    $this->Payment->deposited_amount -= $data->getProcessedAmount();
    $this->Payment->state = Payment::STATE_CANCELED;
    
    return $data;
  }
  
  public final function setRequestedAmount($amount)
  {
    $max = Doctrine_Core::getTable('Currency')->convertAmount(
      $this->Payment->deposited_amount, $this->Payment->currency, $this->currency
    );
    
    if (jmsPaymentNumberUtil::compareFloats($amount, $max) !== 0)
      throw new InvalidArgumentException(
        '$amount must be equal to '.$max.', given: '.$amount.'.');

    parent::setRequestedAmount($amount);
  }
  
  protected final function canBePerformedOn(Payment $payment)
  {
    return $payment->state === Payment::STATE_COMPLETE
           ||
           (
             $payment->state === Payment::STATE_DEPOSITING
             && $payment->getFilteredTransactions(
               FinancialTransaction::STATE_PENDING,
               FinancialTransaction::TYPE_DEPOSIT
             )->count() === 0
           )
    ;
  }
}