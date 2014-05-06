<?php
/**
 * @author Manuele Menozzi <mmenozzi@webgriffe.com>
 */

class Webgriffe_IndexQueue_Model_IndexWorker extends Lilmuckers_Queue_Model_Worker_Abstract
{
    public function run(Lilmuckers_Queue_Model_Queue_Task $task)
    {
        /** @var Webgriffe_IndexQueue_Model_Indexer $indexer */
        $indexer = Mage::getModel('index/indexer');

        $taskData = $task->getData();

        $entity = new Varien_Object($taskData['entity']);
        $entityType = $taskData['entityType'];
        $eventType = $taskData['eventType'];

        if ($taskData['allowTableChanges']) {
            $indexer->allowTableChanges();
        } else {
            $indexer->disallowTableChanges();
        }

        $indexer->processEntityActionByWorker($entity, $entityType, $eventType);
        $task->success();
    }
}