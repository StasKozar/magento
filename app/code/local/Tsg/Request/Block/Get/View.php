<?php

/**
 * Created by PhpStorm.
 * User: StasKozar
 * Date: 12/10/2016
 * Time: 15:39
 */
class Tsg_Request_Block_Get_View extends Mage_Core_Block_Template
{
    protected $_step = null;

    public function getRequestGet()
    {
        return Mage::registry('tsg_request_get');
    }

    public function getRelativeRequest()
    {
        return Mage::registry('tsg_request_get_relative');
    }

    public function groupRequestsByDate($collection)
    {
        $groupByDate = array();
        foreach($collection as $value){
            $groupByDate[Mage::getModel('core/date')->date('Y-m-d', strtotime($value->getRequestDatetime()))] = array();
        }
        foreach ($groupByDate as $date => $value){
            foreach($collection as $request){
                if($date == Mage::getModel('core/date')->date('Y-m-d', strtotime($request->getRequestDatetime()))){
                    array_push($groupByDate[$date], $request);

                }
            }
        }

        return $groupByDate;
    }

    public function generateSteps()
    {
        $day = 24*60;
        $steps = array();
        for($j = 0; $j < $day/$this->_step; $j++){
            $steps[] = $this->_step * $j;
        }
        return $steps;
    }

    public function generateAvgAgePerStep($collection, $steps)
    {
        foreach ($collection as $date => $request){
            $arrayOfAges[$date] = array();
            $tmpArrayOfAges = array();
            $tmpArrayOfDates = array();
            foreach ($request as $value){
                $a = strtotime($date);
                $b = strtotime($value->getRequestDatetime());
                $diff = floor($b / 60) - floor($a / 60);
                foreach ($steps as $key => $step){
                    if(isset($steps[$key + 1])){
                        if($step <= $diff && $steps[$key + 1] > $diff){
                            if(!isset($tmpArrayOfAges[$step])){
                                $tmpArrayOfAges[$step] = array();
                                $tmpArrayOfDates[$step] = array();
                            }
                            array_push($tmpArrayOfAges[$step], (int)$value->getAge());
                            array_push($tmpArrayOfDates[$step], strtotime($value->getRequestDatetime()));
                        }
                    }elseif($step <= $diff){
                        array_push($tmpArrayOfAges[$step], (int)$value->getAge());
                        array_push($tmpArrayOfDates[$step], strtotime($value->getRequestDatetime()));
                    }

                }

            }
            foreach ($tmpArrayOfAges as $key => $item){
                $avgAge = round(array_sum($item) / count($item));
                $arrayOfAges[$date][$key]['age'] = (int)$avgAge;
            }
            foreach ($tmpArrayOfDates as $key => $item){
                $avgDate = round(array_sum($item) / count($item));
                $arrayOfAges[$date][$key]['date'] = date('d.m.Y H:i', $avgDate);
            }

        }
        return $arrayOfAges;
    }

    public function getMaxAge($arrayOfAges)
    {
        $maxValue = array();
        foreach ($arrayOfAges as $item){
            foreach ($item as $value){
                array_push($maxValue, $value['age']);
            }
        }
        $maxValue = max($maxValue);
        return $maxValue;
    }

    public function generatePeriodSelect()
    {
        $selectArray = array(5, 10, 15, 30, 45, 60);

        if(Mage::app()->getRequest()->getParam('step', 0)){
            $this->_step = (int)Mage::app()->getRequest()->getParam('step', 0);
        }else{
            $this->_step = $selectArray[0];
        }

        foreach ($selectArray as $value){
            if($this->_step == $value){
                echo "<option value=$value selected>" . $this->_step . $this->__('хв') . "</option>";
            }else{
                echo "<option value=$value>" . $value . $this->__('хв') . "</option>";
            }
        }
    }
}