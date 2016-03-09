<?php
/**
 * @author Manuele Menozzi <mmenozzi@webgriffe.com>
 */

class Webgriffe_IndexQueue_Test_Model_Indexer extends EcomDev_PHPUnit_Test_Case
{
    protected function setUp()
    {
        $this->setCurrentStore('default');
        parent::setUp();
    }

    public function testThatClassExists()
    {
        $this->assertTrue(class_exists('Webgriffe_IndexQueue_Model_Indexer'));
    }

    public function testThatClassIsInstantiatable()
    {
        $this->assertInstanceOf('Webgriffe_IndexQueue_Model_Indexer', new Webgriffe_IndexQueue_Model_Indexer());
    }

    public function testThatClassExtendsMagentoIndexer()
    {
        $this->assertInstanceOf('Mage_Index_Model_Indexer', new Webgriffe_IndexQueue_Model_Indexer());
    }

    public function testThatProcessEntityActionMethodExists()
    {
        $this->assertTrue(method_exists(new Webgriffe_IndexQueue_Model_Indexer(), 'processEntityAction'));
    }

    public function testThatProcessEntityActionDoesNotQueueIndexingWhenDisabledWhichIsTheDefault()
    {
        $lilqueueMock = $this->getMock('Lilmuckers_Queue_Helper_Data');
        $lilqueueMock
            ->expects($this->never())
            ->method('getQueue');

        $entity = new Varien_Object(array('my' => 'data'));
        $entityType = 'dummy-entity';
        $eventType = Mage_Index_Model_Event::TYPE_SAVE;

        $indexEventMock = $this->getMock('Mage_Index_Model_Event', array('setDataObject'));
        $indexEventMock
            ->expects($this->once())
            ->method('setDataObject')
            ->with($entity)
            ->will($this->returnSelf());
        $this->replaceByMock('model', 'index/event', $indexEventMock);

        $indexer = new Webgriffe_IndexQueue_Model_Indexer();
        $indexer->processEntityAction($entity, $entityType, $eventType);
    }

    /**
     * @loadFixture indexQueueEnabled.yaml
     */
    public function testThatProcessEntityActionQueuesIndexing()
    {
        $queueMock = $this->getMock('Lilmuckers_Queue_Model_Queue_Abstract');

        $lilqueueMock = $this->getMock('Lilmuckers_Queue_Helper_Data');
        $lilqueueMock
            ->expects($this->once())
            ->method('getQueue')
            ->with(Webgriffe_IndexQueue_Model_Indexer::QUEUE_NAME)
            ->will($this->returnValue($queueMock));

        $entity = new Varien_Object(array('my' => 'data'));
        $entityType = 'dummy-entity';
        $eventType = Mage_Index_Model_Event::TYPE_SAVE;

        $taskMock = $this->getMock('Lilmuckers_Queue_Model_Queue_Task');
        $lilqueueMock
            ->expects($this->once())
            ->method('createTask')
            ->with(
                Webgriffe_IndexQueue_Model_Indexer::TASK_NAME,
                array(
                    'entity' => $entity->getData(),
                    'entityType' => $entityType,
                    'eventType' => $eventType,
                    'allowTableChanges' => true,
                    'isObjectNew' => false,
                )
            )
            ->will($this->returnValue($taskMock));

        $queueMock
            ->expects($this->once())
            ->method('addTask')
            ->with($taskMock);

        $this->replaceByMock('helper', 'lilqueue', $lilqueueMock);

        $indexer = new Webgriffe_IndexQueue_Model_Indexer();
        $indexer->processEntityAction($entity, $entityType, $eventType);
    }

    /**
     * @loadFixture indexQueueEnabled.yaml
     */
    public function testThatProcessEntityActionByWorkerDoesNotQueueIndexing()
    {
        $lilqueueMock = $this->getMock('Lilmuckers_Queue_Helper_Data');
        $lilqueueMock
            ->expects($this->never())
            ->method('getQueue');

        $entity = new Varien_Object(array('my' => 'data'));
        $entityType = 'dummy-entity';
        $eventType = Mage_Index_Model_Event::TYPE_SAVE;

        $indexEventMock = $this->getMock('Mage_Index_Model_Event', array('setDataObject'));
        $indexEventMock
            ->expects($this->once())
            ->method('setDataObject')
            ->with($entity)
            ->will($this->returnSelf());
        $this->replaceByMock('model', 'index/event', $indexEventMock);

        $indexer = new Webgriffe_IndexQueue_Model_Indexer();
        $indexer->processEntityActionByWorker($entity, $entityType, $eventType);
    }
} 
