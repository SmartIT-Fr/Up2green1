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
 * PluginFinancialReverseApprovalTransaction
 * 
 * @package    jmsPaymentPlugin
 * @subpackage model
 * @author     Johannes M. Schmitt <schmittjoh@gmail.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class PluginFinancialReverseApprovalTransaction extends BaseFinancialReverseApprovalTransaction
{
  /**
   * Executes the reverse approval transaction.
   * 
   * This method also verifies that the total amount of this transaction equals
   * the amount which has been approved so far, otherwise we directly throw an
   * exception here before passing any data to the actual payment method.
   * 
   * The reason behind allowing only full reversals is that there is no real use
   * case for allowing partial reversals, and it would only complicate things 
   * as additional states would be required. If you really need to perform a
   * reversal the payment is considered CANCELED, and therefore, it is of no
   * use to allow only partial reversals, as we have no use for any remaining
   * approved amount. 
   * 
   * @return jmsPaymentMethodData
   */
  protected final function doExecute()
  {
    $data = $this->getPaymentMethodData();
    $method = $this->getPaymentMethodInstance();
    
    $method->reverseApproval($data);
    
    $this->Payment->approved_amount -= $data->getProcessedAmount();
    
    // we set the payment state to canceled, regardless of whether the entire
    // amount has been processed in this transaction, as this is the best
    // we can do here. Developers will need to implement some custom logic
    // to handle cases where there is not the entire amount processed at their
    // own discretion using the payment event system.
    $this->Payment->state = Payment::STATE_CANCELED;
    
    return $data;
  }
  
  /**
   * Sets the requested amount
   * @param float $amount
   */
  public final function setRequestedAmount($amount)
  {
    $max = Doctrine_Core::getTable('Currency')->convertAmount(
      $this->Payment->approved_amount, $this->Payment->currency, $this->currency
    );
    
    if (jmsPaymentNumberUtil::compareFloats($amount, $max) !== 0)
      throw new InvalidArgumentException(
        '$amount must be equal to '.$max.', given: '.$amount.'.');
    
    parent::setRequestedAmount($amount);
  }
  
  /**
   * A reverse approval can be performed if the payment's state is approved, or
   * if it is being approved, and there are no pending approve transactions.
   * 
   * @param Payment $payment
   * @return boolean
   */
  protected final function canBePerformedOn(Payment $payment)
  {
    return $payment->state === Payment::STATE_APPROVED
           ||
           (
             $payment->state === Payment::STATE_APPROVING
             && $payment->getFilteredTransactions(
               FinancialTransaction::STATE_PENDING, 
               FinancialTransaction::TYPE_APPROVE
             )->count() === 0
           )
    ;
  }
}