<?php

/**
 * Created by PhpStorm.
 * User: StasKozar
 * Date: 17/10/2016
 * Time: 8:47
 */
class Kozar_Actions_Block_Adminhtml_Action_Edit_Tab_General extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _prepareForm()
    {
        $helper = Mage::helper('kozar_actions');
        $model = Mage::registry('current_action');
        $actionSource = Mage::getModel('kozar_actions/source_status');
        $entitySource = Mage::getModel('eav/entity_attribute_source_boolean');
        $dateFormatIso = Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT);

        $form = new Varien_Data_Form();
        $fieldset = $form->addFieldset('general_form', array(
            'legend' => $helper->__('General information')
        ));

        $fieldset->addField('name', 'text', array(
            'label' => $helper->__('Name'),
            'required' => true,
            'name' => 'name',
        ));

        $fieldset->addField('description', 'textarea', array(
            'label' => $helper->__('Description'),
            'required' => true,
            'name' => 'description',
        ));

        $fieldset->addField('short_description', 'textarea', array(
            'label' => $helper->__('Short Description'),
            'required' => true,
            'name' => 'short_description',
        ));

        $fieldset->addField('image', 'image', array(
            'label' => $helper->__('Image'),
            'name' => 'image',
        ));

        $fieldset->addField('start_datetime', 'datetime', array(
            'format' => $dateFormatIso,
            'input_format' => $dateFormatIso,
            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'label' => $helper->__("Start Datetime"),
            'required' => true,
            'time' => true,
            'name' => 'start_datetime',
        ));

        $fieldset->addField('end_datetime', 'datetime', array(
            'format' => $dateFormatIso,
            'input_format' => $dateFormatIso,
            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'label' => $helper->__("End Datetime"),
            'time' => true,
            'name' => 'end_datetime'
        ));

        $fieldset->addField('is_active', 'select', array(
            'label' => $helper->__('Is Active'),
            'required' => true,
            'name' => 'is_active',
            'options' => $entitySource->getOptionArray(),
        ));

        if($model->getId() !== 0){
            $fieldset->addField('status', 'select', array(
                'label' => $helper->__('Status'),
                'name' => 'status',
                'options' => $actionSource->getOptionArray(),
                'value' => $model->getStatus(),
                'disabled' => true,
            ));
        }

        $formData = array_merge($model->getData(), array('image' => $model->getImageUrl()));
        $form->setValues($formData);
        $this->setForm($form);

        return parent::_prepareForm();
    }

}