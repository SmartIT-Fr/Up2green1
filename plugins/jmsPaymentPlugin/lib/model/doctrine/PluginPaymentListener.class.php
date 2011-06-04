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
 * PluginPaymentListener
 * 
 * @package    jmsPaymentPlugin
 * @subpackage model
 * @author     Johannes M. Schmitt <schmittjoh@gmail.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class PluginPaymentListener extends BasePaymentListener
{
  /**
   * A map of cached handler instances which process the triggered events
   * @var array
   */
  private static $_handlers = array();
  
  /**
   * Sets the instance of the actual object that handles all events
   * @param Doctrine_Record $handler
   */
  public final function setHandler(Doctrine_Record $handler)
  {
    if (self::getSingleColumnListenerId($handler) !== $this->listener_id
        || $handler->getTable()->getComponentName() !== $this->listener_type)
        throw new InvalidArgumentException('This handler is invalid.');
        
    self::$_handlers[$this->getIdAsString()] = $handler;  
  }
  
  /**
   * Returns the object handling the payment event.
   * 
   * @throws jmsPaymentEventHandlerDeletedException If the corresponding 
   *          event handler has been deleted.
   * @return Doctrine_Record
   */
  public final function getHandler()
  {
    $id = $this->getIdAsString(); 
    if (!isset(self::$_handlers[$id]))
    {
      $table = Doctrine_Core::getTable($this->listener_type);
      
      // restore the listener id to it's original value
      if (count((array) $table->getIdenfifier()) > 1)
      {
        $listenerId = unserialize($this->listener_id);
      }
      else
      {
        $listenerId = array(reset($table->getIdentifier()) => $this->listener_id);
      }
      
      // check if the table implements the jmsPaymentListenerTableInterface
      if ($table instanceof jmsPaymentListenerTableInterface)
      {
        $handler = $table->findPaymentEventHandler($listenerId);
      }
      // if not, we just fetch the handler object without any relations
      else
      {
        $q = $table->createQuery('h');
        
        foreach ($listenerId as $column => $value)
          $q->andWhere(sprintf('h.%s = ?', $column), $value);
          
        $handler = $q->fetchOne();
      }
      
      // check if the handler exists (maybe it got deleted?)
      if (!$handler)
        throw new jmsPaymentEventHandlerDeletedException(
          'Could not find event handler.');
      
      self::$_handlers[$id] = $handler;
    }
    
    // This can be the case, if the record has been deleted after it was cached.
    // In these cases, the record will be transient again.
    if (self::$_handlers[$id]->exists() === false)
      throw new jmsPaymentEventHandlerDeletedException(
        'Event handler was deleted.');
    
    return self::$_handlers[$id];
  }
  
  /**
   * Gets the ID (primary key) of this listener as string
   * @return string
   */
  private function getIdAsString()
  {
    return implode('.', $this->identifier());
  }
  
  /**
   * If the listener is deleted, also delete the handler object
   * @param Doctrine_Event $event
   */
  public final function postDelete($event)
  {
    unset(self::$_handlers[$this->getIdAsString()]);
  }

  /**
   * Returns a unique ID for the given listener. So, we have no problems with 
   * composite primary keys.
   * 
   * @return string
   */  
  public final static function getSingleColumnListenerId(Doctrine_Record $listener)
  {
    $id = (array) $listener->identifier();
    if (count($id) > 1)
      return serialize($id);
    
    return strval(reset($id));    
  }
}