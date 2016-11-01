<?php

/* @var $installer Mage_Core_Model_Resource_Setup*/
$installer = $this;
$installer->startSetup();

$tableName = $installer->getTable('kozar_actions/action');

$installer->getConnection()->addColumn($tableName, 'status', 'integer NOT NULL default "1"');

$installer->endSetup();