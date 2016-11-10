<?php

/**
 * Created by PhpStorm.
 * User: StasKozar
 * Date: 07/11/2016
 * Time: 15:41
 */
class Tsg_Request_Model_Resource_Relative_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        parent::_construct();
        $this->_init('tsg_request/relative');
        return $this;
    }
}