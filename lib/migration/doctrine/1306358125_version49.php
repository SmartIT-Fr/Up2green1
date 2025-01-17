<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version49 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createTable('currencies', array(
             'id' => 
             array(
              'type' => 'integer',
              'primary' => '1',
              'autoincrement' => '1',
              'unsigned' => '1',
              'length' => '11',
             ),
             'code' => 
             array(
              'type' => 'string',
              'notnull' => '1',
              'unique' => '1',
              'length' => '3',
             ),
             'rate' => 
             array(
              'type' => 'decimal',
              'scale' => '7',
              'comment' => 'This rate is relative to the euro; basically it says what amount 1 EUR equals in this currency.',
              'length' => '18',
             ),
             'updated_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             'version' => 
             array(
              'type' => 'integer',
              'length' => '8',
             ),
             ), array(
             'type' => 'InnoDB',
             'primary' => 
             array(
              0 => 'id',
             ),
             'collate' => 'utf8_unicode_ci',
             'charset' => 'utf8',
             ));
        $this->createTable('financial_transactions', array(
             'id' => 
             array(
              'type' => 'integer',
              'primary' => '1',
              'autoincrement' => '1',
              'unsigned' => '1',
              'length' => '11',
             ),
             'type' => 
             array(
              'type' => 'string',
              'notnull' => '1',
              'length' => '25',
             ),
             'payment_id' => 
             array(
              'type' => 'integer',
              'unsigned' => '1',
              'notnull' => '1',
              'length' => '11',
             ),
             'currency' => 
             array(
              'type' => 'enum',
              'values' => 
              array(
              0 => 'EUR',
              1 => 'USD',
              2 => 'JPY',
              3 => 'BGN',
              4 => 'CZK',
              5 => 'DKK',
              6 => 'EEK',
              7 => 'GBP',
              8 => 'HUF',
              9 => 'LTL',
              10 => 'LVL',
              11 => 'PLN',
              12 => 'RON',
              13 => 'SEK',
              14 => 'CHF',
              15 => 'NOK',
              16 => 'HRK',
              17 => 'RUB',
              18 => 'TRY',
              19 => 'AUD',
              20 => 'BRL',
              21 => 'CAD',
              22 => 'CNY',
              23 => 'HKD',
              24 => 'IDR',
              25 => 'INR',
              26 => 'KRW',
              27 => 'MXN',
              28 => 'MYR',
              29 => 'NZD',
              30 => 'PHP',
              31 => 'SGD',
              32 => 'THB',
              33 => 'ZAR',
              ),
              'default' => 'EUR',
              'comment' => 'This might be different from the currency of the payment; by default, both are equal.',
              'length' => '',
             ),
             'requested_amount' => 
             array(
              'type' => 'decimal',
              'scale' => '5',
              'length' => '18',
             ),
             'processed_amount' => 
             array(
              'type' => 'decimal',
              'scale' => '5',
              'length' => '18',
             ),
             'state' => 
             array(
              'type' => 'integer',
              'notnull' => '1',
              'unsigned' => '1',
              'default' => '1',
              'length' => '1',
             ),
             'response_code' => 
             array(
              'type' => 'string',
              'notnull' => '',
              'comment' => 'Primary error code that is used to determine whether a transaction was successful or not.',
              'length' => '255',
             ),
             'reason_code' => 
             array(
              'type' => 'string',
              'notnull' => '',
              'comment' => 'Secondary error code that is used to determine what exactly went wrong if anything.',
              'length' => '255',
             ),
             'created_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             'updated_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             ), array(
             'type' => 'InnoDB',
             'indexes' => 
             array(
              'financial_transactions_type' => 
              array(
              'fields' => 
              array(
               0 => 'type',
              ),
              ),
             ),
             'primary' => 
             array(
              0 => 'id',
             ),
             'collate' => 'utf8_unicode_ci',
             'charset' => 'utf8',
             ));
        $this->createTable('payment_data', array(
             'payment_id' => 
             array(
              'primary' => '1',
              'type' => 'integer',
              'unsigned' => '1',
              'notnull' => '',
              'length' => '11',
             ),
             'method_class_name' => 
             array(
              'type' => 'string',
              'notnull' => '1',
              'comment' => 'The class name of the payment method that this data represents.',
              'length' => '100',
             ),
             'subject' => 
             array(
              'type' => 'string',
              'notnull' => '1',
              'comment' => 'The subject that is displayed to the client in the given locale.',
              'length' => '255',
             ),
             'internal_reference_number' => 
             array(
              'type' => 'string',
              'notnull' => '',
              'comment' => 'This is purely optional, and can be used by the payment method class internally (e.g. PayPalPaymentMethod).',
              'length' => '255',
             ),
             'external_reference_number' => 
             array(
              'type' => 'string',
              'notnull' => '',
              'comment' => 'This is a reference number generated by the actual payment method provider (e.g. PayPal itself).',
              'length' => '255',
             ),
             'bank_country' => 
             array(
              'type' => 'string',
              'notnull' => '1',
              'length' => '2',
             ),
             'bank_code' => 
             array(
              'type' => 'string',
              'notnull' => '1',
              'length' => '255',
             ),
             'account_holder' => 
             array(
              'type' => 'string',
              'notnull' => '1',
              'length' => '255',
             ),
             'account_number' => 
             array(
              'type' => 'string',
              'notnull' => '1',
              'length' => '255',
             ),
             'project' => 
             array(
              'type' => 'string',
              'notnull' => '',
              'length' => '255',
             ),
             'project_campaign' => 
             array(
              'type' => 'string',
              'notnull' => '',
              'length' => '255',
             ),
             'payment_text' => 
             array(
              'type' => 'string',
              'notnull' => '',
              'length' => '255',
             ),
             'ip' => 
             array(
              'type' => 'string',
              'notnull' => '',
              'length' => '15',
             ),
             'express_token' => 
             array(
              'type' => 'string',
              'notnull' => '',
              'length' => '30',
             ),
             'express_url' => 
             array(
              'type' => 'string',
              'notnull' => '',
              'length' => '2048',
             ),
             'cancel_url' => 
             array(
              'type' => 'string',
              'notnull' => '1',
              'length' => '2048',
             ),
             'return_url' => 
             array(
              'type' => 'string',
              'notnull' => '1',
              'length' => '2048',
             ),
             'payer_id' => 
             array(
              'type' => 'string',
              'notnull' => '',
              'length' => '255',
             ),
             'created_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             'updated_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             ), array(
             'type' => 'InnoDB',
             'primary' => 
             array(
              0 => 'payment_id',
             ),
             'collate' => 'utf8_unicode_ci',
             'charset' => 'utf8',
             ));
        $this->createTable('payments', array(
             'id' => 
             array(
              'type' => 'integer',
              'primary' => '1',
              'autoincrement' => '1',
              'unsigned' => '1',
              'length' => '11',
             ),
             'target_amount' => 
             array(
              'comment' => 'The requested target amount for this Payment.',
              'type' => 'decimal',
              'scale' => '5',
              'notnull' => '1',
              'length' => '18',
             ),
             'approved_amount' => 
             array(
              'type' => 'decimal',
              'scale' => '5',
              'notnull' => '1',
              'length' => '18',
             ),
             'approving_amount' => 
             array(
              'type' => 'decimal',
              'scale' => '5',
              'notnull' => '1',
              'length' => '18',
             ),
             'deposited_amount' => 
             array(
              'type' => 'decimal',
              'scale' => '5',
              'notnull' => '1',
              'length' => '18',
             ),
             'depositing_amount' => 
             array(
              'type' => 'decimal',
              'scale' => '5',
              'notnull' => '1',
              'length' => '18',
             ),
             'currency' => 
             array(
              'type' => 'enum',
              'values' => 
              array(
              0 => 'EUR',
              1 => 'USD',
              2 => 'JPY',
              3 => 'BGN',
              4 => 'CZK',
              5 => 'DKK',
              6 => 'EEK',
              7 => 'GBP',
              8 => 'HUF',
              9 => 'LTL',
              10 => 'LVL',
              11 => 'PLN',
              12 => 'RON',
              13 => 'SEK',
              14 => 'CHF',
              15 => 'NOK',
              16 => 'HRK',
              17 => 'RUB',
              18 => 'TRY',
              19 => 'AUD',
              20 => 'BRL',
              21 => 'CAD',
              22 => 'CNY',
              23 => 'HKD',
              24 => 'IDR',
              25 => 'INR',
              26 => 'KRW',
              27 => 'MXN',
              28 => 'MYR',
              29 => 'NZD',
              30 => 'PHP',
              31 => 'SGD',
              32 => 'THB',
              33 => 'ZAR',
              ),
              'default' => 'EUR',
              'notnull' => '1',
              'length' => '',
             ),
             'state' => 
             array(
              'type' => 'integer',
              'unsigned' => '1',
              'default' => '1',
              'notnull' => '1',
              'length' => '1',
             ),
             'created_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             'updated_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             ), array(
             'type' => 'InnoDB',
             'primary' => 
             array(
              0 => 'id',
             ),
             'collate' => 'utf8_unicode_ci',
             'charset' => 'utf8',
             ));
        $this->createTable('payment_listeners', array(
             'payment_id' => 
             array(
              'type' => 'integer',
              'unsigned' => '1',
              'primary' => '1',
              'autoincrement' => '',
              'length' => '11',
             ),
             'listener_id' => 
             array(
              'type' => 'string',
              'primary' => '1',
              'length' => '115',
             ),
             'listener_type' => 
             array(
              'type' => 'string',
              'primary' => '1',
              'length' => '115',
             ),
             ), array(
             'type' => 'InnoDB',
             'primary' => 
             array(
              0 => 'payment_id',
              1 => 'listener_id',
              2 => 'listener_type',
             ),
             'collate' => 'utf8_unicode_ci',
             'charset' => 'utf8',
             ));
        $this->createTable('currency_version', array(
             'id' => 
             array(
              'type' => 'integer',
              'primary' => '1',
              'unsigned' => '1',
              'length' => '11',
             ),
             'code' => 
             array(
              'type' => 'string',
              'notnull' => '1',
              'length' => '3',
             ),
             'rate' => 
             array(
              'type' => 'decimal',
              'scale' => '7',
              'comment' => 'This rate is relative to the euro; basically it says what amount 1 EUR equals in this currency.',
              'length' => '18',
             ),
             'updated_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             'version' => 
             array(
              'primary' => '1',
              'type' => 'integer',
              'length' => '8',
             ),
             ), array(
             'type' => 'InnoDB',
             'primary' => 
             array(
              0 => 'id',
              1 => 'version',
             ),
             'collate' => 'utf8_unicode_ci',
             'charset' => 'utf8',
             ));
    }

    public function down()
    {
        $this->dropTable('currencies');
        $this->dropTable('financial_transactions');
        $this->dropTable('payment_data');
        $this->dropTable('payments');
        $this->dropTable('payment_listeners');
        $this->dropTable('currency_version');
    }
}