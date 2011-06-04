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
 * PluginFinancialApproveTransaction
 * 
 * @package    jmsPaymentPlugin
 * @subpackage model
 * @author     Johannes M. Schmitt <schmittjoh@gmail.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class PluginFinancialApproveTransaction extends BaseFinancialApproveTransaction
{
  protected final function doExecute()
  {
    $data = $this->getPaymentMethodData();
    $method = $this->getPaymentMethodInstance();
    $payment = $this->Payment;
    $currencyTable = Doctrine_Core::getTable('Currency');

    $payment->state = Payment::STATE_APPROVING;
    $approvingAmount = $currencyTable->convertAmount(
      $data->getAmount(), $data->getCurrency(), $payment->currency
    );
    
    if ($this->isFirstExecution())
      $payment->approving_amount += $approvingAmount;
    
    try 
    {
      // execute the transaction
      $method->approve($data);
      
      $payment->approving_amount -= $approvingAmount;
      
      $approvedAmount = $currencyTable->convertAmount(
        $data->getProcessedAmount(), $data->getCurrency(), $payment->currency
      );
      $payment->approved_amount += $approvedAmount;
      
      // set the payment to APPROVED if the approved amount is greater or equal
      // to the target amount of the payment
      if (jmsPaymentNumberUtil::compareFloats(
            $payment->approved_amount, $payment->target_amount) >= 0)
        $payment->state = Payment::STATE_APPROVED;
      
      return $data;
    }
    catch (jmsPaymentException $e)
    {
      if (!$e instanceof jmsPaymentUserActionRequiredException)
        $payment->approving_amount -= $approvingAmount;
      
      // if the approve function is not supported, this is considered 
      // to be a successful approval (this is the best guess we can make)
      if ($e instanceof jmsPaymentFunctionNotSupportedException)
      {
        $payment->approved_amount += $approvingAmount;
        
        if (jmsPaymentNumberUtil::compareFloats(
              $payment->approved_amount, $payment->target_amount) >= 0)
          $payment->state = Payment::STATE_APPROVED;
        
        return $data;
      }
      
      // re-throw exception
      throw $e;
    }
  }
  
  public final function setRequestedAmount($amount)
  {
    $max = Doctrine_Core::getTable('Currency')->convertAmount(
             $this->Payment->getPendingAmount(), $this->Payment->currency, $this->currency
           );
    if (jmsPaymentNumberUtil::compareFloats($amount, $max) > 0) 
      throw new InvalidArgumentException(
        '$amount cannot be greater than '.$max.', given: '.$amount.'.');

    parent::setRequestedAmount($amount);
  }
  
  protected final function canBePerformedOn(Payment $payment)
  {
    return $payment->state === Payment::STATE_NEW
           || 
           (
             $payment->state === Payment::STATE_APPROVING 
             && jmsPaymentNumberUtil::compareFloats(
                  $payment->approved_amount, $payment->target_amount) < 0
           )
    ;
  }
}