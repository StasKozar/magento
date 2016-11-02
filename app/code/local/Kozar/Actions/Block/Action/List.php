<?php

/**
 * Created by PhpStorm.
 * User: StasKozar
 * Date: 17/10/2016
 * Time: 11:11
 */
class Kozar_Actions_Block_Action_List extends Mage_Core_Block_Template
{
    public function __construct(array $args)
    {
        parent::__construct();
        $collection = Mage::getModel('kozar_actions/action')->getCollection();

        $collection->addFieldToFilter('is_active', true)
            ->addFieldToFilter('status', Kozar_Actions_Model_Source_Status::OPEN_ACTION)
            ->setOrder('start_datetime', 'DESC');

        $this->setCollection($collection);

        return $this;
    }

    public function getShortedDescription(Kozar_Actions_Model_Action $action)
    {
        /* @var $helper Mage_Core_Helper_String*/
        $helper = Mage::helper('core/string');

        return $helper->truncate($action->getDescription(), 130, '...');
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        $pager = $this->getLayout()->createBlock('page/html_pager', 'list.pager');
        $pager->setAvailableLimit(array(2=>2, 5=>5, 10=>10, 20=>20, 'all' => 'all'));
        $pager->setCollection($this->getCollection());
        $this->setChild('pager', $pager);
        $this->getCollection();
        return $this;
    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }
}