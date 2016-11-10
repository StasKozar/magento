<?php

/**
 * Created by PhpStorm.
 * User: StasKozar
 * Date: 17/10/2016
 * Time: 11:11
 */
class Tsg_Request_Block_Get_List extends Mage_Core_Block_Template
{
    protected $_getCollection = null;

    public function getGetCollection()
    {
        if (is_null($this->_getCollection)) {
            $this->_getCollection = Mage::getModel('tsg_request/get')
                ->getCollection()
                ->addFieldToFilter('is_active', true);
        }

        return $this->_getCollection;
    }
}