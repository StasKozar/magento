<?php

/**
 * Created by PhpStorm.
 * User: StasKozar
 * Date: 17/10/2016
 * Time: 10:48
 */
class Kozar_Actions_Model_Observer extends Mage_Core_Model_Abstract
{



    public function addToTopmenu(Varien_Event_Observer $observer)
    {
        $menu = $observer->getMenu();
        $tree = $menu->getTree();

        $node = new Varien_Data_Tree_Node(array(
            'name'   => 'Акції',
            'id'     => 'actions',
            'url'    => Mage::getUrl() . 'actions',
        ), 'id', $tree, $menu);

        $menu->addChild($node);

        return $this;
    }

    public function generateStatus()
    {
        $collection = Mage::getModel('kozar_actions/action')->getCollection();
        $model = Mage::getModel('kozar_actions/action');
        $gmtDate = Mage::getModel('core/date')->gmtDate();

        foreach ($collection as $item){
            if (strtotime($item->getEndDatetime()) < strtotime($gmtDate)) {
                $model->load($item->getId())->setStatus($model::CLOSED_ACTION)->save();
            } elseif (strtotime($item->getStartDatetime()) < strtotime($gmtDate)) {

                $model->load($item->getId())->setStatus($model::OPEN_ACTION)->save();

            } elseif (strtotime($item->getStartDatetime()) > strtotime($gmtDate)) {

                $model->load($item->getId())->setStatus($model::UNAVAILABLE_ACTION)->save();
            }
        }

        return $this;
    }
}