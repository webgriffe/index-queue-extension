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
        if (!Mage::getStoreConfigFlag('system/index_queue/enabled')) {
            return parent::processEntityAction($entity, $entityType, $eventType);
        }

        /** @var Lilmuckers_Queue_Helper_Data $lilqueueHelper */
        $lilqueueHelper = Mage::helper('lilqueue');
        /** @var Lilmuckers_Queue_Model_Queue_Abstract $indexQueue */
        $indexQueue = $lilqueueHelper->getQueue(self::QUEUE_NAME);
        $indexTask = $lilqueueHelper->createTask(
            self::TASK_NAME,
            array(
                'entityClass' => get_class($entity),
                'entityData' => $entity->getData(),
                'entityOrigData' => $entity->getOrigData(),
                'entityType' => $entityType,
                'eventType' => $eventType,
                'allowTableChanges' => $this->_allowTableChanges,
            )
        );

        if ($entity->getId()) {
            $this->log('Queuing reindex for entity ' . get_class($entity) . ' with id ' . $entity->getId());
        } else {
            $this->log('Queuing reindex for entity ' . get_class($entity) . ' without id');
        }

        $indexQueue->addTask($indexTask);

        $this->log('Queuing done');

        return $this;
    }

    public function processEntityActionByWorker(Varien_Object $entity, $entityType, $eventType)
    {
        return parent::processEntityAction($entity, $entityType, $eventType);
    }

    /**
     * @param string $message
     * @param int $level
     */
    protected function log($message, $level = Zend_Log::DEBUG)
    {
        Mage::helper('wg_indexqueue')->log($message, $level);
    }
}
