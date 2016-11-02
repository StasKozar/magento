<?php

/**
 * Created by PhpStorm.
 * User: StasKozar
 * Date: 18/10/2016
 * Time: 8:10
 */
class Kozar_Actions_Block_Adminhtml_Action_Edit_Tab_Product extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setDefaultFilter(array('ajax_grid_in_action' => 1));
        $this->setId('actionProductGrid');
        $this->setSaveParametersInSession(false);
        $this->setUseAjax(true);

        return $this;
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToSelect('id')
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('type')
            ->addAttributeToSelect('status')
            ->addAttributeToSelect('visibility')
            ->addAttributeToSelect('sku');

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $helper = Mage::helper('kozar_actions');

        $this->addColumn('ajax_grid_in_action', array(
            'align' => 'center',
            'header_css_class' => 'a-center',
            'index' => 'entity_id',
            'type' => 'checkbox',
            'values' => $this->getSelectedProducts(),
        ));

        $this->addColumn('ajax_grid_product_id', array(
            'header' => $helper->__('Product ID'),
            'index' => 'entity_id',
            'width' => '100',
            'type' => 'range',
        ));

        $this->addColumn('ajax_grid_name', array(
            'header' => $helper->__('Name'),
            'index' => 'name',
            'type' => 'text',
        ));

        $this->addColumn('ajax_grid_type', array(
            'header' => $helper->__('Type'),
            'index' => 'type_id',
        ));

        $this->addColumn('ajax_grid_status', array(
            'header' => $helper->__('Status'),
            'index' => 'status',
            'type' => 'options',
            'options' => Mage_Catalog_Model_Product_Status::getOptionArray(),
        ));

        $this->addColumn('ajax_grid_visibility', array(
            'header' => $helper->__('Visibility'),
            'index' => 'visibility',
            'type' => 'options',
            'options' => Mage_Catalog_Model_Product_Visibility::getOptionArray(),
        ));

        $this->addColumn('ajax_grid_sku', array(
            'header' => $helper->__('SKU'),
            'index' => 'sku',
            'width' => '80',
        ));

        return parent::_prepareColumns();
    }

    protected function _addColumnFilterToCollection($column)
    {
        if ($column->getId() == 'ajax_grid_in_action') {
            $collection = $this->getCollection();
            $selectedProducts = $this->getSelectedProducts();
            if ($column->getFilter()->getValue()) {
                $collection->addFieldToFilter('entity_id', array('in' => $selectedProducts));
            } elseif (!empty($selectedProducts)) {
                $collection->addFieldToFilter('entity_id', array('nin' => $selectedProducts));
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/product', array('_current' => true, 'grid_only' => 1));
    }

    public function getSelectedProducts()
    {
        if (!isset($this->_data['selected_products'])) {
            $selectedProducts = Mage::app()->getRequest()->getParam('selected_products', null);
            if(is_null($selectedProducts) || !is_array($selectedProducts)){
                $action = Mage::registry('current_action');
                $selectedProducts = $action->getProducts()->getColumnValues('entity_id');
            }
            $this->_data['selected_products'] = $selectedProducts;
        }
        return $this->_data['selected_products'];
    }
}