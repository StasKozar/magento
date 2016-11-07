<?php

class Tsg_Request_Model_Observer extends Mage_Core_Model_Abstract
{
    /*public function generateStatus()
    {
        $collection = Mage::getModel('kozar_actions/action')->getCollection();
        $model = Mage::getModel('kozar_actions/action');
        $actionStatus = Mage::getModel('kozar_actions/source_status');
        $gmtDate = Mage::getModel('core/date')->gmtDate();

        foreach ($collection as $item){
            if (strtotime($item->getEndDatetime()) < strtotime($gmtDate)) {
                $model->load($item->getId())->setStatus($actionStatus::CLOSED_ACTION)->save();
            } elseif (strtotime($item->getStartDatetime()) < strtotime($gmtDate)) {

                $model->load($item->getId())->setStatus($actionStatus::OPEN_ACTION)->save();

            } elseif (strtotime($item->getStartDatetime()) > strtotime($gmtDate)) {

                $model->load($item->getId())->setStatus($actionStatus::UNAVAILABLE_ACTION)->save();
            }
        }

        return $this;
    }*/

    public function sendRequest()
    {
        $collection = Mage::getModel('tsg_request/get')->getCollection()->addFieldToFilter('is_active', true);
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
            $data = array(
                'url_id' => $item->getEntityId(),
                'age' => $age,
                'request_datetime' => Mage::getModel('core/date')->date(),
            );
            $modelRelative->setData($data);
            var_dump($age);
        }

        /*echo '<pre>';
        print_r($data);
        echo '</pre>';*/

        if($data === false){
            return false;
        }
        $data = preg_split('/^r&$/m', $data, 2);

        $data = trim($data[0]);


        $curl->close();

        die();

        try{
            $xml = new SimpleXMLElement($data);
        }catch (Exception $e){
            echo $e->getMessage();
        }
    }
}