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
} 