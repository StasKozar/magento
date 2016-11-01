<?php


/* @var $installer Mage_Core_Model_Resource_Setup*/
$installer = $this;
$installer->startSetup();

$table = $this->getConnection()
    ->newTable($this->getTable('kozar_actions/product'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Relation ID')
    ->addColumn('action_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
    ), 'Action ID')
    ->addColumn('product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
    ), 'Product ID')
    ->addIndex($this->getIdxName('kozar_actions/product', array('action_id', 'product_id'), Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE), array('action_id', 'product_id'), array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE))
    ->addForeignKey($this->getFkName('kozar_actions/product', 'action_id', 'kozar_actions/action', 'id'), 'action_id', $this->getTable('kozar_actions/action'), 'id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($this->getFkName('kozar_actions/product', 'product_id', 'catalog/product', 'entity_id'), 'product_id', $this->getTable('catalog/product'), 'entity_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Action to Product Linkage Table');
$this->getConnection()->createTable($table);

$installer->endSetup();