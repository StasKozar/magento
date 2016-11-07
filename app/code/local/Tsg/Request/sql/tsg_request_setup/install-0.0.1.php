<?php

/* @var $installer Mage_Core_Model_Resource_Setup*/
$installer = $this;
$installer->startSetup();

$tableName = $installer->getTable('tsg_request/get');

$installer->getConnection()->dropTable($tableName);
$table = $installer->getConnection()
    ->newTable($tableName)
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity' => true,
        'unsigned' => true,
        'nullable' => false,
        'primary' => true,
    ), 'ID')
    ->addColumn('url', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => false,
    ), 'URL')
    ->addColumn('is_active', Varien_Db_Ddl_Table::TYPE_BOOLEAN, null, array(
        'nullable' => false,
        'default' => 0,
    ), 'Is Active');

$installer->getConnection()->createTable($table);

$installer->endSetup();