<?php

/**
 * Created by PhpStorm.
 * User: StasKozar
 * Date: 12/10/2016
 * Time: 15:39
 */
class Tsg_Request_Block_Get_View extends Mage_Core_Block_Template
{
    public function getRequestGet()
    {
        return Mage::registry('tsg_request_get');
    }

    public function getRelativeRequest()
    {
        return Mage::registry('tsg_request_get_relative');
    }
}