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
        $collection = Mage::getModel('tsg_request/relative')
            ->getCollection()
            ->addFilter('url_id', $model->getId());

        if(Mage::app()->getRequest()->getParam('from', 0) != 0){
            $from = strtotime(Mage::app()->getRequest()->getParam('from', 0));
            if(Mage::app()->getRequest()->getParam('to', 0) != null){
                $to = strtotime(Mage::getModel('core/date')->date());
            }else{
                $to = strtotime(Mage::app()->getRequest()->getParam('to', 0) . ' 23:59:59');
            }
            $collection->addFieldToFilter('request_datetime', array('gteq' => date('Y-m-d H:i:s', $from)))
                ->addFieldToFilter('request_datetime', array('lteq' => date('Y-m-d H:i:s', $to)));

            return $collection;
        }

        return $collection;

    }
}