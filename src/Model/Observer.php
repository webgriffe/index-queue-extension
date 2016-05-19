<?php

/**
 * Created by PhpStorm.
 * User: andrea
 * Date: 19/05/16
 * Time: 10.55
 */
class Webgriffe_IndexQueue_Model_Observer
{
    public function closeDbConnection()
    {
        $_db = Mage::getSingleton('core/resource')->getConnection('core_write');
        $_db->closeConnection();
    }

    public function reopenDbConnection()
    {
        $_db = Mage::getSingleton('core/resource')->getConnection('core_write');
        $_db->getConnection();
    }
}