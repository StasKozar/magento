<?php

class Tsg_Request_Model_Relative extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        parent::_construct();
        $this->_init('tsg_request/relative');
    }
}