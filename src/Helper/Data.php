<?php
/**
 * @author Manuele Menozzi <mmenozzi@webgriffe.com>
 */ 
class Webgriffe_IndexQueue_Helper_Data extends Mage_Core_Helper_Abstract
{
    const LOG_FILENAME = 'wg_indexqueue.log';

    public function log($message, $level = Zend_Log::DEBUG, $forceLog = false)
    {
        Mage::log($message, $level, self::LOG_FILENAME, $forceLog);
    }
}
