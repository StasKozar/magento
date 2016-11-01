<?php

/* @var $installer Mage_Core_Model_Resource_Setup*/
$installer = $this;
$installer->startSetup();

$tableName = $installer->getTable('kozar_actions/action');

$installer->getConnection()->dropTable($tableName);
$table = $installer->getConnection()->newTable($tableName);

$table->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
    'identity' => true,
    'unsigned' => true,
    'nullable' => false,
    'primary' => true,
), 'ID')
    ->addColumn('name', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => false,
    ), 'Name')
    ->addColumn('description', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable' => false,
    ), 'Description')
    ->addColumn('short_description', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable' => false,
    ), 'Short Description')
    ->addColumn('image', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => false,
    ), 'Image')
    ->addColumn('create_datetime', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'default' => Varien_Db_Ddl_Table::TIMESTAMP_INIT,
    ), 'Create Date')
    ->addColumn('start_datetime', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'default' => Varien_Db_Ddl_Table::TIMESTAMP_INIT,
        'nullable' => false,
    ), 'Start Datetime')
    ->addColumn('end_datetime', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'nullable' => true,
    ), 'End Datetime')
    ->addColumn('is_active', Varien_Db_Ddl_Table::TYPE_BOOLEAN, null, array(
        'nullable' => false,
        'default' => 0,
    ), 'Is Active');

$installer->getConnection()->createTable($table);

$installer->endSetup();