<?php
/**
 * @author Manuele Menozzi <mmenozzi@webgriffe.com>
 */

class Webgriffe_IndexQueue_Test_Model_IndexWorker extends EcomDev_PHPUnit_Test_Case
{
    public function testRunShouldIndexEntityAndMarkTaskAsSuccessful()
    {
        $entityData = array('my' => 'data');
        $entity = new Webgriffe_IndexQueue_Model_EntityObject($entityData);
        $entityType = 'dummy-entity';
        $eventType = 'dummy-event';
        $taskData = array(
            'entity' => $entityData,
            'entityType' => $entityType,
            'eventType' => $eventType,
            'allowTableChanges' => true,
            'isObjectNew' => false,
        );
        $entity->setIsNew($taskData['isObjectNew']);

        $indexerMock = $this->getMock('Webgriffe_IndexQueue_Model_Indexer');
        $indexerMock
            ->expects($this->once())
            ->method('processEntityActionByWorker')
            ->with($entity, $entityType, $eventType)
            ->will($this->returnSelf());
        $indexerMock
            ->expects($this->once())
            ->method('allowTableChanges')
            ->will($this->returnSelf());
        $this->replaceByMock('model', 'index/indexer', $indexerMock);

        $taskMock = $this->getMock('Lilmuckers_Queue_Model_Queue_Task');
        $taskMock
            ->expects($this->once())
            ->method('getData')
            ->will($this->returnValue($taskData));
        $taskMock
            ->expects($this->once())
            ->method('success');

        $indexWorker = new Webgriffe_IndexQueue_Model_IndexWorker();
        $indexWorker->run($taskMock);
    }
} 