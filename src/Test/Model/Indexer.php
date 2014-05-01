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

} 