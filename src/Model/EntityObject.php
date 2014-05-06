<?php
/**
 * @author Manuele Menozzi <mmenozzi@webgriffe.com>
 */

class Webgriffe_IndexQueue_Model_EntityObject extends Varien_Object
{
    protected $_isNew = true;

    /**
     * @param boolean $isNew
     */
    public function setIsNew($isNew)
    {
        $this->_isNew = $isNew;
    }

    /**
     * @return boolean
     */
    public function isObjectNew()
    {
        return $this->_isNew;
    }
} 