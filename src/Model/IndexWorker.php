<?php
/**
 * @author Manuele Menozzi <mmenozzi@webgriffe.com>
 */

class Webgriffe_IndexQueue_Model_IndexWorker extends Lilmuckers_Queue_Model_Worker_Abstract
{
    public function run(Lilmuckers_Queue_Model_Queue_Task $task)
    {
        try {
            /** @var Webgriffe_IndexQueue_Model_Indexer $indexer */
            $indexer = Mage::getModel('index/indexer');

            $taskData = $task->getData();
            $entityClass = $taskData['entityClass'];
            $entityData = $taskData['entityData'];
            $entityOrigData = $taskData['entityOrigData'];

            /** @var Varien_Object $entity */
            $entity = new $entityClass($entityData);
            if ($entity->getId() && method_exists($entity, 'load')) {
                $id = $entity->getId();
                $entity = new $entityClass();
                $entity->load($id);
            } else {
                $entity->setData($entityData);
            }
            if ($entityOrigData && is_array($entityOrigData)) {
                foreach ($entityOrigData as $key => $data) {
                    $entity->setOrigData($key, $data);
                }
            }
            $entityType = $taskData['entityType'];
            $eventType = $taskData['eventType'];

            if ($taskData['allowTableChanges']) {
                $indexer->allowTableChanges();
            } else {
                $indexer->disallowTableChanges();
            }

            if ($entity->getId()) {
                $this->log('Starting reindex for object '.get_class($entity).' with id '.$entity->getId());
            } else {
                $this->log('Starting reindex for object '.get_class($entity).' without id');
            }

            $indexer->processEntityActionByWorker($entity, $entityType, $eventType);

            $this->log('Indexing Done');

            $task->success();
        } catch (Exception $e) {
            $this->log('Index Worker exception: ' . $e->getMessage(), Zend_Log::CRIT);
            $this->log($e->getTraceAsString(), Zend_Log::CRIT);
            $task->hold();
        }
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
