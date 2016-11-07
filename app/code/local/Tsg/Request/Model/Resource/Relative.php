<?php

class Tsg_Request_Model_Resource_Relative extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('tsg_request/relative', 'id');
        return $this;
    }
}