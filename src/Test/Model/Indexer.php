<?php
/**
 * @author Manuele Menozzi <mmenozzi@webgriffe.com>
 */

class Webgriffe_IndexQueue_Test_Model_Indexer extends EcomDev_PHPUnit_Test_Case
{
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

    public function testThatProcessEntityActionQueuesIndexing()
    {
        $queueMock = $this->getMock('Lilmuckers_Queue_Model_Queue_Abstract');

        $lilqueueMock = $this->getMock('Lilmuckers_Queue_Helper_Data');
        $lilqueueMock
            ->expects($this->once())
            ->method('getQueue')
            ->with('indexQueue')
            ->will($this->returnValue($queueMock));

        $entity = new Varien_Object(array('my' => 'data'));
        $entityType = Mage_Catalog_Model_Product::ENTITY;
        $eventType = Mage_Index_Model_Event::TYPE_SAVE;

        $taskMock = $this->getMock('Lilmuckers_Queue_Model_Queue_Task');
        $lilqueueMock
            ->expects($this->once())
            ->method('createTask')
            ->with(
                'indexTask',
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

} 