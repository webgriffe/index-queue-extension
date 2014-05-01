<?php
/**
 * @author Manuele Menozzi <mmenozzi@webgriffe.com>
 */

class Webgriffe_IndexQueue_Model_Indexer extends Mage_Index_Model_Indexer
{
    public function processEntityAction(Varien_Object $entity, $entityType, $eventType)
    {
        return parent::processEntityAction($entity, $entityType, $eventType);
    }
}