<?php

/**
 * Created by PhpStorm.
 * User: StasKozar
 * Date: 12/10/2016
 * Time: 13:06
 */
class Kozar_Actions_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getImagePath($image = null){
        $path = Mage::getBaseDir('media') . '/kozar_actions';
        if ($image) {
            return "{$path}/{$image}";
        } else {
            return $path;
        }
    }

    public function deleteImage($image)
    {
        $basePath = Mage::getBaseDir(Mage_Core_Model_Store::URL_TYPE_MEDIA) . DS . 'kozar_actions' . DS . $image;
        $path200x200 = Mage::getBaseDir(Mage_Core_Model_Store::URL_TYPE_MEDIA)
            . DS . 'kozar_actions' . DS . '200x200' . DS . $image;
        $path300x300 = Mage::getBaseDir(Mage_Core_Model_Store::URL_TYPE_MEDIA)
            . DS . 'kozar_actions' . DS . '300x300' . DS . $image;

        if (file_exists($path300x300)) {
            @unlink($path300x300);
        }
        if (file_exists($path200x200)) {
            @unlink($path200x200);
        }
        @unlink($basePath);

        return $this;
    }

    public function getImageUrl($image, $width, $height)
    {
        $folderUrl = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . 'kozar_actions/';
        $imageUrl = $folderUrl . $image;

        $basePath = Mage::getBaseDir(Mage_Core_Model_Store::URL_TYPE_MEDIA) . DS . 'kozar_actions' . DS . $image;
        $newPath = Mage::getBaseDir(Mage_Core_Model_Store::URL_TYPE_MEDIA)
            . DS . 'kozar_actions' . DS . $width . 'x' . $height . DS . $image;
        if ($width != '' && $height != '') {
            if (file_exists($basePath) && is_file($basePath) && !file_exists($newPath)) {
                $imageObj = new Varien_Image($basePath);
                $imageObj->constrainOnly(TRUE);
                $imageObj->keepAspectRatio(FALSE);
                $imageObj->keepFrame(FALSE);
                $imageObj->resize($width, $height);
                $imageObj->save($newPath);
            }
            $resizedURL = $folderUrl . $width . 'x' . $height . DS . $image;
        } else {
            $resizedURL = $imageUrl;
        }
        return $resizedURL;
    }

    public function convertToGmt($data)
    {
        if(!empty($data->getCreateDatetime()))
            $data->setCreateDatetime(Mage::getSingleton('core/date')->gmtDate(null, $data->getCreateDatetime()));
        if(!empty($data->getStartDatetime()))
            $data->setStartDatetime(Mage::getSingleton('core/date')->gmtDate(null, $data->getStartDatetime()));
        if(!empty($data->getEndDatetime()))
            $data->setEndDatetime(Mage::getSingleton('core/date')->gmtDate(null, $data->getEndDatetime()));

        return $this;
    }

    public function convertToLocal($data)
    {
        if($data->getCreateDatetime() !== null){
            $data->setCreateDatetime(Mage::getSingleton('core/date')->date(null, $data->getCreateDatetime()));
        }
        if($data->getStartDatetime() !== null){
            $data->setStartDatetime(Mage::getSingleton('core/date')->date(null, $data->getStartDatetime()));
        }
        if($data->getEndDatetime() !== null) {
            $data->setEndDatetime(Mage::getSingleton('core/date')->date(null, $data->getEndDatetime()));
        }

        return $this;
    }

    public function setStatus($data){
        $actionSource = new Kozar_Actions_Model_Source_Boolean();
        $gmtDate = Mage::getModel('core/date')->gmtDate();

        if (strtotime($data->getEndDatetime()) < strtotime($gmtDate)) {
            $data->setStatus($actionSource::CLOSED_ACTION);
        } elseif (strtotime($data->getStartDatetime()) < strtotime($gmtDate)) {
            $data->setStatus($actionSource::OPEN_ACTION);
        } elseif (strtotime($data->getStartDatetime()) > strtotime($gmtDate)) {
            $data->setStatus($actionSource::UNAVAILABLE_ACTION);
        }

        return $this;
    }

}