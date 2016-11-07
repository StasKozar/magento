<?php

class Tsg_Request_Model_Resource_Get_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        parent::_construct();
        $this->_init('tsg_request/get');
        return $this;
    }
}