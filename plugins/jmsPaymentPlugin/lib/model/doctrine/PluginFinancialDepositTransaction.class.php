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
 * PluginFinancialDepositTransaction
 * 
 * @package    jmsPaymentPlugin
 * @subpackage model
 * @author     Johannes M. Schmitt <schmittjoh@gmail.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class PluginFinancialDepositTransaction extends BaseFinancialDepositTransaction
{
  protected final function doExecute()
  {
    $data = $this->getPaymentMethodData();
    $method = $this->getPaymentMethodInstance();
    $payment = $this->Payment;
    $currencyTable = Doctrine_Core::getTable('Currency');
    
    $payment->state = Payment::STATE_DEPOSITING;
    $depositingAmount = $currencyTable->convertAmount(
      $data->getAmount(), $data->getCurrency(), $payment->currency
    );
    
    if ($this->isFirstExecution())
      $payment->depositing_amount += $depositingAmount;
    
    try 
    {
      $method->deposit($data);
      
      $payment->depositing_amount -= $depositingAmount;
      
      $depositedAmount = $currencyTable->convertAmount(
        $data->getProcessedAmount(), $data->getCurrency(), $payment->currency
      );
      $payment->deposited_amount += $depositedAmount;
      
      if (jmsPaymentNumberUtil::compareFloats(
            $payment->deposited_amount, $payment->target_amount) >= 0)
        $payment->state = Payment::STATE_COMPLETE;
      
      return $data;
    }
    catch (jmsPaymentException $e)
    {
      if (!$e instanceof jmsPaymentUserActionRequiredException)
        $payment->depositing_amount -= $depositingAmount;
        
      if ($e instanceof jmsPaymentApprovalExpiredException)
        $payment->state = Payment::STATE_EXPIRED;
        
      throw $e;
    }
  }
  
  public final function setRequestedAmount($amount)
  {
    $max = Doctrine_Core::getTable('Currency')->convertAmount(
               $this->Payment->getPendingAmount(), 
               $this->Payment->currency, 
               $this->currency
           );
    
    if (jmsPaymentNumberUtil::compareFloats($amount, $max) > 0)
      throw new InvalidArgumentException(
        '$amount cannot be greater than '.$max.', given: '.$amount.'.');
      
    parent::setRequestedAmount($amount);
  }
  
  protected final function canBePerformedOn(Payment $payment)
  {
    return $payment->state === Payment::STATE_APPROVED
           ||
           (
             $payment->state === Payment::STATE_DEPOSITING
             && jmsPaymentNumberUtil::compareFloats(
                  $payment->deposited_amount, $payment->target_amount) < 0
           )
    ;
  }
}