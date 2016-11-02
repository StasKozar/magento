<?php

/**
 * Created by PhpStorm.
 * User: StasKozar
 * Date: 12/10/2016
 * Time: 17:17
 */
class Kozar_Actions_Block_Adminhtml_Action_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    protected function _construct()
    {
        parent::_construct();
        $this->setId('actionsGrid');
        $this->setVarNameFilter('selected_actions_filters');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('kozar_actions/action')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $dateFormatIso = Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
        $helper = Mage::helper('kozar_actions');
        $actionSource = Mage::getModel('kozar_actions/source_status');
        $entitySource = Mage::getModel('eav/entity_attribute_source_boolean');

        $this->addColumn('id', array(
            'header' => $helper->__('ID'),
            'index' => 'id',
            'type' => 'range',
            'width' => '50',
        ));

        $this->addColumn('name', array(
            'header' => $helper->__('Name'),
            'index' => 'name',
            'type' => 'text',
        ));

        $this->addColumn('short_description', array(
            'header' => $helper->__('Short Description'),
            'index' => 'short_description',
            'type' => 'text',
        ));

        $this->addColumn('create_datetime', array(
            'header' => $helper->__('Create Datetime'),
            'index' => 'create_datetime',
            'type' => 'datetime',
            'format' => $dateFormatIso,
        ));

        $this->addColumn('start_datetime', array(
            'header' => $helper->__('Start Datetime'),
            'index' => 'start_datetime',
            'type' => 'datetime',
            'format' => $dateFormatIso,
        ));

        $this->addColumn('end_datetime', array(
            'header' => $helper->__('End Datetime'),
            'index' => 'end_datetime',
            'type' => 'datetime',
            'format' => $dateFormatIso,
        ));

        $this->addColumn('image', array(
            'header' => $helper->__('Image'),
            'index' => 'image',
            'width' => '70',
            'renderer' => 'Kozar_Actions_Block_Adminhtml_Template_Grid_Renderer_Image',
        ));

        $this->addColumn('is_active', array(
            'header' => $helper->__('Is Active'),
            'name' => 'is_active',
            'type' => 'options',
            'index' => 'is_active',
            'options' => $entitySource->getOptionArray(),
        ));

        $this->addColumn('status', array(
            'header' => $helper->__('Status'),
            'name' => 'status',
            'type' => 'options',
            'index' => 'status',
            'options' => $actionSource->getOptionArray(),
        ));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('action');

        $this->getMassactionBlock()->addItem('delete', array(
            'label' => $this->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
        ));

        return $this;
    }

    public function getRowUrl($model)
    {
        return $this->getUrl('*/*/edit', array(
            'id' => $model->getId(),
        ));
    }
}