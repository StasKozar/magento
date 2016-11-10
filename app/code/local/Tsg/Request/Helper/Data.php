<?php

/**
 * Created by PhpStorm.
 * User: StasKozar
 * Date: 07/11/2016
 * Time: 10:59
 */
class Tsg_Request_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function convertToLocal($data)
    {
        if($data->getRequestDatetime() !== null){
            $data->setRequestDatetime(Mage::getSingleton('core/date')->date(null, $data->getRequestDatetime()));
        }

        return $this;
    }
}