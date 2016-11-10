<?php


/* @var $installer Mage_Core_Model_Resource_Setup*/
$installer = $this;
$installer->startSetup();

$table = $this->getConnection()
    ->newTable($this->getTable('tsg_request/relative'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Relation ID')
    ->addColumn('url_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
    ), 'Url ID')
    ->addColumn('age', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
    ), 'Age')
    ->addColumn('request_datetime', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'default' => Varien_Db_Ddl_Table::TIMESTAMP_INIT,
    ), 'Request Datetime')
    ->addForeignKey($this->getFkName('tsg_request/relative', 'url_id', 'tsg_request/get', 'entity_id'), 'url_id', $this->getTable('tsg_request/get'), 'entity_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Get to Relative Linkage Table');
$this->getConnection()->createTable($table);

$installer->endSetup();