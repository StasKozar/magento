<?php

/**
 * Created by PhpStorm.
 * User: StasKozar
 * Date: 28/10/2016
 * Time: 13:15
 */
class Kozar_Actions_Model_Source_Boolean extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    const UNAVAILABLE_ACTION = 1;
    const OPEN_ACTION = 2;
    const CLOSED_ACTION = 3;

    public function getAllOptions()
    {
        if (is_null($this->_options)) {
            $this->_options = array(
                array(
                    'label' => Mage::helper('kozar_actions')->__('Час дії ще не наступив'),
                    'value' => self::UNAVAILABLE_ACTION
                ),
                array(
                    'label' => Mage::helper('kozar_actions')->__('Акція діє'),
                    'value' => self::OPEN_ACTION
                ),
                array(
                    'label' => Mage::helper('kozar_actions')->__('Акція закрита'),
                    'value' => self::CLOSED_ACTION
                ),
            );
        }
        return $this->_options;
    }

    public function getOptionArray()
    {
        $_options = array();
        foreach ($this->getAllOptions() as $option) {
            $_options[$option['value']] = $option['label'];
        }
        return $_options;
    }

}