<?php

class Tsg_Request_Model_Resource_Get extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('tsg_request/get', 'entity_id');
        return $this;
    }

    public function getRelativeCollection($model)
    {
        $collection = Mage::getModel('tsg_request/relative')->getCollection()
            ->addFilter('url_id', $model->getId());

        return $collection;
    }
}