<?php

/**
 * PaymentDataTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class PaymentDataTable extends PluginPaymentDataTable
{
    /**
     * Returns an instance of this class.
     *
     * @return object PaymentDataTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('PaymentData');
    }
}