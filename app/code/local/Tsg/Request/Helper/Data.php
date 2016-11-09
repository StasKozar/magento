<?php

/**
 * Created by PhpStorm.
 * User: StasKozar
 * Date: 07/11/2016
 * Time: 10:59
 */
class Tsg_Request_Helper_Data extends Mage_Core_Helper_Abstract
{
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

    public function generateSteps($step)
    {
        $day = 24*60;
        $steps = array();
        for($j = 0; $j < $day/$step; $j++){
            $steps[] = $step * $j;
        }
        return $steps;
    }

    public function generateAvgAgePerStep($collection, $steps)
    {
        foreach ($collection as $date => $request){
            $arrayOfAges[$date] = array();
            $array = array();
            foreach ($request as $value){
                $a = strtotime($date);
                $b = strtotime($value->getRequestDatetime());
                $diff = floor($b / 60) - floor($a / 60);
                foreach ($steps as $key => $step){
                    if(isset($steps[$key + 1])){
                        if($step <= $diff && $steps[$key + 1] > $diff){
                            if(!isset($array[$step])){
                                $array[$step] = array();
                            }
                            array_push($array[$step], (int)$value->getAge());
                        }
                    }elseif($step <= $diff){
                        array_push($array[$step], (int)$value->getAge());
                    }

                }

            }
            foreach ($array as $key => $item){
                $avgAge = round(array_sum($item) / count($item));
                $arrayOfAges[$date][$key] = (int)$avgAge;
            }

        }
        return $arrayOfAges;
    }

    public function getMaxAge($arrayOfAges)
    {
        $maxValue = array();
        foreach ($arrayOfAges as $item){
            foreach ($item as $value){
                array_push($maxValue, $value);
            }
        }
        $maxValue = (max($maxValue));
        return $maxValue;
    }
}