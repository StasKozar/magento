<?php

class Tsg_Request_Model_Get extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        parent::_construct();
        $this->_init('tsg_request/get');
    }

    public function getRequestUrl()
    {
        return Mage::getUrl('request/index/view', array(
            'id' => $this->getId(),
        ));
    }

    public function getRelativeRequests()
    {
        return  Mage::getResourceModel('tsg_request/get')->getRelativeCollection($this);
    }
}