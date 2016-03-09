<?php
/**
 * @author Manuele Menozzi <mmenozzi@webgriffe.com>
 */

class Webgriffe_IndexQueue_Test_Config_General extends EcomDev_PHPUnit_Test_Case_Config
{
    public function testThatModuleIsActive()
    {
        $this->assertModuleIsActive();
    }

    public function testThatIndexerIsRewritten()
    {
        $this->assertModelAlias('index/indexer', 'Webgriffe_IndexQueue_Model_Indexer');
    }

    public function testThatEnabledConfigParameterIsDefinedAndIsSetToFalse()
    {
        $this->assertConfigNodeValue('default/system/index_queue/enabled', '0');
    }

    public function testThatQueueHandlerAndWorkerAreDefined()
    {
        $queueName = Webgriffe_IndexQueue_Model_Indexer::QUEUE_NAME;
        $taskName = Webgriffe_IndexQueue_Model_Indexer::TASK_NAME;
        $this->assertConfigNodeValue('queues/' . $queueName . '/label', 'Index Queue');
        $this->assertConfigNodeValue('queues/' . $queueName . '/class', 'lilqueue/queue');
        $this->assertConfigNodeValue(
            'queues/' . $queueName . '/workers/' . $taskName . '/class',
            'wg_indexqueue/indexWorker'
        );
        $this->assertConfigNodeValue(
            'queues/' . $queueName . '/workers/' . $taskName . '/method',
            'run'
        );
    }
} 
