<?php
/**
 * Created by PhpStorm.
 * User: home
 * Date: 2/2/2018
 * Time: 10:44 AM
 */

class Tlvdecoder
{
    private $_data	= array();
    private $_valid	= array();
    function getMapping($tlv)
    {
        $tmp            = 0;
        $tagValue       = $this->getTagValue($tlv, $tmp);
        $tagValueLength = $this->getValueLength($tlv, 2);
        $response       = $this->getTlvData($tlv, $tagValueLength);
        $nextTlv        = $this->nextTlvData($tlv, $tagValueLength);
        if (!empty($nextTlv)) {
            $this->getMapping($nextTlv);
        }
        $this->_data[$tagValue] = $response;
        return $this->_data;

    }
    private function nextTlvData($tlv, $length)
    {
        $response = substr($tlv, 4);
        return substr($response, $length);
    }
    private function getTlvData($tlvCode, $length)
    {
        $response = substr($tlvCode, 4);
        $result = substr($response, 0, $length);
        return $result;
    }
    private function getTagValue($str, $tmp)
    {
        $array = substr($str, $tmp, '2');
        return sprintf('%02s', $array);
    }

    private function getValueLength($str, $tmp)
    {
        return substr($str, $tmp, 2);
    }

}