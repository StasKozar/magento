<?php

/**
 * Created by PhpStorm.
 * User: StasKozar
 * Date: 17/10/2016
 * Time: 11:11
 */
class Tsg_Request_Block_Get_List extends Mage_Core_Block_Template
{
    public function __construct(array $args)
    {
        parent::__construct();
        $collection = Mage::getModel('tsg_request/get')->getCollection();

        $collection->addFieldToFilter('is_active', true);

        $this->setCollection($collection);

        return $this;
    }
}