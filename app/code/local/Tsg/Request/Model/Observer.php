<?php

class Tsg_Request_Model_Observer extends Mage_Core_Model_Abstract
{
    public function sendRequest()
    {
        $collection = Mage::getModel('tsg_request/get')
            ->getCollection()
            ->addFieldToFilter('is_active', true);

        $curl = Mage::getModel('varien/http_adapter_curl');
        $curl->setConfig(array('timeout' => 15));

        foreach ($collection as $item){
            $modelRelative = Mage::getModel('tsg_request/relative');
            $feedUrl = $item->getUrl();
            $curl->write(Zend_Http_Client::GET, $feedUrl, '1.1');
            $data = $curl->read();
            $age = substr($data, strpos($data, 'Age'));
            $age = strstr($age, 'Via', true);
            $age = trim($age);
            $age = explode(': ', $age);
            $age = (int) $age[1];
            $data = array(
                'url_id' => $item->getEntityId(),
                'age' => $age,
                'request_datetime' => Mage::getModel('core/date')->gmtDate(),
            );
            $modelRelative->setData($data);
            $modelRelative->save();
        }
    }
}