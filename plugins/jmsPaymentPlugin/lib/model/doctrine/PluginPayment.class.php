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
 * PluginPayment
 * 
 * @package    jmsPaymentPlugin
 * @subpackage model
 * @author     Johannes M. Schmitt <schmittjoh@gmail.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class PluginPayment extends BasePayment
{
  const STATE_NEW = 1;
  const STATE_APPROVING = 2;
  const STATE_APPROVED = 3;
  const STATE_CANCELED = 4;
  const STATE_EXPIRED = 5;
  const STATE_DEPOSITING = 6;
  const STATE_COMPLETE = 7;
  const STATE_FAILED = 8;
  
  const EVENT_PRE_TRANSACTION = 'pre_transaction';
  const EVENT_POST_TRANSACTION = 'post_transaction';
  const EVENT_POST_STATE_CHANGE = 'post_state_change';
  
  /**
   * This variable is used to ensure that developers use the static 
   * constructors, and do not create payments themself as this can lead to huge
   * problems later on.
   * 
   * @var boolean
   */
  private $_iKnowWhatImDoing = false;
  
  /**
   * An array of allowed state transitions
   * @var array
   */
  private static $_allowedStateTransitions = array(
    self::STATE_NEW => array(
      self::STATE_APPROVING,
      self::STATE_CANCELED,
    ),
    self::STATE_APPROVING => array(
      self::STATE_APPROVED,
      self::STATE_CANCELED,
      self::STATE_FAILED,
    ),
    self::STATE_APPROVED => array(
      self::STATE_CANCELED,
      self::STATE_DEPOSITING,
    ),
    self::STATE_CANCELED => array(),
    self::STATE_EXPIRED => array(),
    self::STATE_DEPOSITING => array(
      self::STATE_FAILED,
      self::STATE_COMPLETE,
      self::STATE_CANCELED,
      self::STATE_EXPIRED,
    ),
    self::STATE_COMPLETE => array(
      // if there was a chargeback, or sth went wrong after the amount was deposited
      self::STATE_FAILED,
      // if there was a refund initiated from our end
      self::STATE_CANCELED
    ),
    self::STATE_FAILED => array(),
  );
  
  /**
   * An array of allowed currencies
   * @var array
   */
  private static $_allowedCurrencies = null;
  
  /**
   * Returns a map of allowed state transitions
   * @return array
   */
  public final static function getAllowedStateTransitions()
  {
    return self::$_allowedStateTransitions;
  }
  
  /**
   * Returns an array of allowed currencies. This should be considered immutable.
   * @return array
   */
  public final static function getAllowedCurrencies()
  {
    if (self::$_allowedCurrencies === null)
    {
      $def = Doctrine_Core::getTable('Payment')->getDefinitionOf('currency');
      self::$_allowedCurrencies = &$def['values'];
    }
    
    return self::$_allowedCurrencies;
  }
  
  /**
   * Creates, and immediately saves a payment.
   * 
   * @param mixed $amount An integer, or float value
   * @param string $currency See schema for allowed currencies
   * @param PaymentData $data the data container to use
   * @return Payment
   */
  public final static function create($amount, $currency, PaymentData $data)
  {
    if (is_float($amount) === false && is_int($amount) === false)
      throw new InvalidArgumentException(
        '$amount must be a float, or an integer.');
    $amount = floatval($amount);
      
    $currencies = self::getAllowedCurrencies();
    if (!in_array($currency, $currencies, true))
      throw new InvalidArgumentException(
        'Invalid $currency. Valids: '.var_export($currencies, true));
    
    if ($data->exists() === true)
      throw new LogicException('The payment data must be transient.');
      
    $payment = new Payment();
    $payment->_iKnowWhatImDoing = true;
    $payment->target_amount = $amount;
    $payment->currency = $currency;
    $payment->save();
    
    $payment->DataContainer = $data;
    $data->save();
    
    return $payment;
  }
  
  /**
   * Whether the payment's state is a final state. Final state means that the 
   * payment's state cannot be changed anymore.
   * 
   * @param integer $state
   * @return boolean
   */
  public final static function isFinalState($state)
  {
    if (!isset(self::$_allowedStateTransitions[$state]))
      throw new InvalidArgumentException('Invalid state: '.var_export($state, true));
    
    return count(self::$_allowedStateTransitions[$state]) === 0;
  }
  
  /**
   * Ensure payments are created in the correct fashion;
   * see above as to why this is necessary.
   */
  public final function preInsert($event)
  {
    if ($this->_iKnowWhatImDoing === false)
      throw new RuntimeException(
        'Please use the static constructor methods to create payments.');
  }
  
  /**
   * Sets a target state
   * @param integer $state
   * @throws InvalidArgumentException if state is not allowed
   */
  public final function setState($state)
  {
    // do nothing if the state is not changed
    if ($state === $this->state)
      return;
    
    if (!in_array($state, self::$_allowedStateTransitions[$this->state], true))
      throw new InvalidArgumentException(
        'This target state ('.var_export($state, true).') is not allowed '
       .'for current state ('.var_export($this->state, true).').'
      );
      
    $this->_set('state', $state);
    
    $this->dispatchEvent(self::EVENT_POST_STATE_CHANGE);
  }
  
  /**
   * Make sure state is an integer even if it is coming from the database
   * @return integer
   */
  public final function getState()
  {
    return intval($this->_get('state'));
  }
  
  /**
   * Resets the target amount
   * @param mixed $amount Anything that can be correctly converted to a float.
   */
  public final function setTargetAmount($amount)
  {
    if ($this->state !== self::STATE_NEW)
      throw new LogicException('You must not change the target amount if the '
        .'payment is not new.');
      
    $this->_set('target_amount', $amount);
  }
  
  /**
   * Registers a payment listener
   * @param Doctrine_Record $listener
   * TODO: Allow to register for a specific event
   */
  public final function registerListener(Doctrine_Record $listener)
  {
    if (!$listener instanceof jmsPaymentListenerInterface)
      throw new InvalidArgumentException(
        '$listener must implement the jmsPaymentListenerInterface, given: '.get_class($listener));

    if ($listener->exists() === false)
      throw new InvalidArgumentException(
        'Transient records cannot be registered as listeners.');
      
    if ($this->hasListener($listener))
      throw new InvalidArgumentException(
        'This listener has already been registered.');
      
    if ($this->exists() === false)
      throw new RuntimeException(
        'Listeners cannot be registered on transient payments.');
      
    $paymentListener = $this->Listeners->get(null);
    $paymentListener->listener_id = 
      PaymentListener::getSingleColumnListenerId($listener);
    $paymentListener->listener_type = $this->getListenerType($listener);
    $paymentListener->save();
    
    $paymentListener->setHandler($listener);
  }
  
  /**
   * Whether this payment has a given listener
   * @param Doctrine_Record $listener
   * @return boolean
   */
  public final function hasListener(Doctrine_Record $listener)
  {
    $listenerType = $this->getListenerType($listener);
    $listenerId = PaymentListener::getSingleColumnListenerId($listener);
    
    foreach ($this->Listeners as $paymentListener)
    {
      if ($listenerType === $paymentListener->listener_type
          && $listenerId === $paymentListener->listener_id)
          return true;
    }
    
    return false;
  }
  
  /**
   * Returns a type for the listener.
   * 
   * @return string
   */
  private function getListenerType(Doctrine_Record $listener)
  {
    return $listener->getTable()->getComponentName();
  }
  
  /**
   * Unregisters a listener
   * @param Doctrine_Record $listener
   */
  public final function unregisterListener(Doctrine_Record $listener)
  {
    if ($this->hasListener($listener) === false)
      throw new InvalidArgumentException('This listener is not registered.');
      
    $listenerType = $this->getListenerType($listener);
    $listenerId = PaymentListener::getSingleColumnListenerId($listener);
    foreach ($this->Listeners as $index => $paymentListener)
    {
      if ($listenerType === $paymentListener->listener_type
          && $listenerId === $paymentListener->listener_id)
      {
        $this->Listeners->remove($index);
        $paymentListener->delete();
        break;
      }
    }
  }
  
  /**
   * Returns the amount that is pending for the current phase to complete.
   * Basically, there are two phases: approval, and deposit.
   * 
   * Approval Phase:
   * open_amount = target_amount - (approved_amount + approving_amount)
   * 
   * Deposit Phase:
   * open_amount = target_amount - (deposited_amount + depositing_amount)
   * 
   * @return float
   */
  public final function getPendingAmount()
  {
    if ($this->isInApprovalPhase())
      return $this->target_amount 
              - $this->approved_amount 
              - $this->approving_amount;
              
    else if ($this->isInDepositPhase())
      return $this->target_amount
             - $this->depositing_amount
             - $this->deposited_amount;
    
    // this means final state, or COMPLETE
    else
      return 0.0;
  }
  
  /**
   * This method performs a financial transaction against this payment object.
   * 
   * @throws jmsPaymentApprovalExpiredException
   * @throws jmsPaymentCommunicationException
   * @throws jmsPaymentFinancialException
   * @throws jmsPaymentFunctionNotSupportedException
   * @throws jmsPaymentTimeoutException
   * @throws jmsPaymentUserActionRequiredException
   * @param mixed $transaction One of the FinancialTransaction::TYPE_* constants,
   *                           or an instance of FinancialTransaction
   * @return void
   */
  public final function performTransaction($transaction)
  {
    if (is_string($transaction))
    {
      $transaction = FinancialTransaction::create($transaction, $this);
    }
    
    if (!$transaction instanceof FinancialTransaction)
      throw new InvalidArgumentException(
        sprintf('"%s" must inherit from FinancialTransaction.', 
          get_class($transaction)));
    
    // for now, only transactions which are NEW or PENDING can be executed
    // against this payment
    if ($transaction->isInFinalState() === true)
      throw new LogicException(
        'The given transaction is already in a final state.');
          
    // check if this payment is in a final state. If so, no transactions can be
    // performed against it.
    if ($this->isInFinalState())
      throw new LogicException('This payment is in a final state; no transactions'
        .' can be performed against it.');
        
    // verify that the transaction belongs to this payment
    if ($transaction->Payment !== $this)
      throw new InvalidArgumentException(
        'The given transaction already belongs to another payment.');

    $event = $this->dispatchEvent(new jmsPaymentTransactionEvent(
      self::EVENT_PRE_TRANSACTION, $this, $transaction
    ));
    if ($event->isPreventDefault() === true)
    {
      $transaction->state = FinancialTransaction::STATE_CANCELED;
      $transaction->save();
      
      throw new jmsPaymentFinancialException(
        'The transaction was prevented by one of the listeners.');
    }

    $transaction->execute();
    
    // TODO: Consider dispatching an event for transactions which do not
    //       complete successfully. Maybe split into EVENT_POST_SUCCESSFUL_TRANSACTION
    //       and EVENT_POST_UNSUCCESSFUL_TRANSACTION?
    $this->dispatchEvent(new jmsPaymentTransactionEvent(
      self::EVENT_POST_TRANSACTION, $this, $transaction
    ));
  }
  
  /**
   * This is called before a transaction is executed against a payment. You can
   * overwrite this method if you want to implement some custom logic that 
   * applies to all payments. 
   * 
   * @param jmsPaymentTransactionEvent $event
   */
  protected function preTransactionEvent(jmsPaymentTransactionEvent $event) 
  {
  }
  
  /**
   * This is called after a transaction has been made. The transactions
   * state will already be persisted. This is designed to be overridden by
   * sub classes.
   * 
   * @param jmsPaymentTransactionEvent $event
   */
  protected function postTransactionEvent(jmsPaymentTransactionEvent $event) 
  {
  }
  
  /**
   * This is called after the state of the payment has changed. You can
   * override this method in sub classes.
   * 
   * @param jmsPaymentEvent $event
   */
  protected function postStateChangeEvent(jmsPaymentEvent $event)
  {
  }
  
  /**
   * A shortcut for performTransaction('approve')
   */
  public final function approve()
  {
    $this->performTransaction(FinancialTransaction::TYPE_APPROVE);
  }
  
  /**
   * A shortcut for performTransaction('deposit')
   */
  public final function deposit()
  {
    $this->performTransaction(FinancialTransaction::TYPE_DEPOSIT);
  }
  
  /**
   * A shortcut for performTransaction('reverseApproval')
   */
  public final function reverseApproval()
  {
    $this->performTransaction(FinancialTransaction::TYPE_REVERSE_APPROVAL);
  }
  
  /**
   * A shortcut for performTransaction('reverseDeposit')
   */
  public final function reverseDeposit()
  {
    $this->performTransaction(FinancialTransaction::TYPE_REVERSE_DEPOSIT);
  }
  
  /**
   * Dispatches an event to payment listeners
   * @param mixed $event Either a string, or an instance of jmsPaymentEvent
   * @return jmsPaymentEvent
   */
  public final function dispatchEvent($event)
  {
    if (is_string($event))
      $event = new jmsPaymentEvent($event, $this);
      
    if (!$event instanceof jmsPaymentEvent)
      throw new InvalidArgumentException('$event must be a string representing the '
        .'name of the event, or an instance of jmsPaymentEvent.');
    
    // check if this payment has global handlers in this class before we 
    // dispatch it to the registered listeners
    switch ($event->getName())
    {
      case self::EVENT_PRE_TRANSACTION:
        $this->preTransactionEvent($event);
        break;
        
      case self::EVENT_POST_TRANSACTION:
        $this->postTransactionEvent($event);
        break;
        
      case self::EVENT_POST_STATE_CHANGE:
        $this->postStateChangeEvent($event);
        break;
    }
    
    // now dispatch the event to registered listeners
    foreach ($this->Listeners as $listener)
    {
      if ($event->isStopPropagation() === true)
        break;
      
      try 
      {
        $listener->getHandler()->handlePaymentEvent($event);
      } 
      catch (jmsPaymentEventHandlerDeletedException $e) 
      {
        $this->unregisterListener($listener);
      }
    }
    
    return $event;
  }
  
  /**
   * Make sure we return a float and not a string. This important for the
   * I18nNumber Widget/Validator to work properly.
   * 
   * @return float
   */
  public final function getTargetAmount()
  {
    return floatval($this->_get('target_amount'));
  }

  /**
   * Make sure we return a float and not a string. This important for the
   * I18nNumber Widget/Validator to work properly.
   * 
   * @return float
   */
  public final function getApprovedAmount()
  {
    return floatval($this->_get('approved_amount'));
  }
  
  /**
   * Make sure we return a float and not a string. This important for the
   * I18nNumber Widget/Validator to work properly.
   * 
   * @return float
   */
  public final function getApprovingAmount()
  {
    return floatval($this->_get('approving_amount'));
  }
  
  /**
   * Make sure we return a float and not a string. This is important for the
   * I18nNumber Widget/Validator to work properly.
   * 
   * @return float
   */
  public final function getDepositingAmount()
  {
    return floatval($this->_get('depositing_amount'));
  }
  
  /**
   * Make sure we return a float and not a string. This is important for the
   * I18nNumber Widget/Validator to work properly.
   * 
   * @return float
   */
  public final function getDepositedAmount()
  {
    return floatval($this->_get('deposited_amount'));
  }
  
  /**
   * Whether this payment is in a final state.
   * 
   * @return boolean
   */
  public final function isInFinalState()
  {
    return self::isFinalState($this->state);
  }
  
  /**
   * Whether this payment is currently in the approval phase. This means that
   * the payment has not yet been approved completely. It might be that it has
   * been partially approved, or that it is new.
   * 
   * @return boolean
   */
  public final function isInApprovalPhase()
  {
    return $this->state === self::STATE_NEW 
           || $this->state === self::STATE_APPROVING; 
  }
  
  /**
   * Whether this payment is currently in the deposit phase. This means that
   * the payment has not yet been deposited completely. It might be that is has
   * been partially deposited, or that it just has been approved completely.
   * 
   * @return boolean
   */
  public final function isInDepositPhase()
  {
    return $this->state === self::STATE_APPROVED
           || $this->state === self::STATE_DEPOSITING;
  }
  
  /**
   * Returns all transactions which match the given state, and/or type, and
   * belong to this payment.
   * 
   * @param integer $state one of the FinancialTransaction::STATE_* constants
   * @param string $type one of the FinancialTransaction::TYPE_* constants
   * @return Doctrine_Collection
   */
  public final function getFilteredTransactions($state = null, $type = null)
  {
    $col = clone $this->Transactions;
    
    if ($state === null && $type === null)
      return $col;
    
    $col->setData(array_filter($col->getData(), 
      function($transaction) use ($state, $type)
      {
        if ($state !== null && $transaction->state !== $state)
          return false;
          
        if ($type !== null && $transaction->type !== $type)
          return false;
          
        return true;
      }
    ));
      
    return $col;
  }
  
  /**
   * Whether this payment has a transaction that is open. 
   * @return boolean
   */
  public final function hasOpenTransaction()
  {
    return $this->getOpenTransaction() !== null;
  }
  
  /**
   * The open transaction or null if there is none.
   * @return FinancialTransaction
   */
  public final function getOpenTransaction()
  {
    foreach ($this->Transactions as $transaction)
    {
      if ($transaction->isInFinalState() === false)
        return $transaction;
    }
    
    return null;
  }
}