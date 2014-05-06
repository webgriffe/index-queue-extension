<?php
/**
 * @author Manuele Menozzi <mmenozzi@webgriffe.com>
 */

class Webgriffe_IndexQueue_Model_Indexer extends Mage_Index_Model_Indexer
{
    const QUEUE_NAME = 'indexQueue';
    const TASK_NAME = 'indexTask';

    public function processEntityAction(Varien_Object $entity, $entityType, $eventType)
    {
        if(!Mage::getStoreConfig('system/index_queue/enabled')) {
            return parent::processEntityAction($entity, $entityType, $eventType);
        }

        /** @var Lilmuckers_Queue_Helper_Data $lilqueueHelper */
        $lilqueueHelper = Mage::helper('lilqueue');
        /** @var Lilmuckers_Queue_Model_Queue_Abstract $indexQueue */
        $indexQueue = $lilqueueHelper->getQueue(self::QUEUE_NAME);
        $indexTask = $lilqueueHelper->createTask(
            self::TASK_NAME,
            array(
                'entity' => $entity->getData(),
                'entityType' => $entityType,
                'eventType' => $eventType,
                'allowTableChanges' => $this->_allowTableChanges,
                'isObjectNew' => method_exists ($entity, 'isObjectNew') ? $entity->isObjectNew() : false,
            )
        );
        $indexQueue->addTask($indexTask);
        return $this;
    }

    public function processEntityActionByWorker(Varien_Object $entity, $entityType, $eventType)
    {
        return parent::processEntityAction($entity, $entityType, $eventType);
    }
}