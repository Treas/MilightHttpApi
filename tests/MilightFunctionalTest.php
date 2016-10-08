<?php

namespace Tests\Functional;

//this is a temporary work around to get phpunit to run properly from command line
include_once(__DIR__ . '/BaseTestCase.php');

class MilightFunctionalTests extends BaseTestCase
{
	/**
	 * Checks response and passes test if response returned 0
	 */
	 Function checkResponse($response)
	 {
		$this->assertEquals(200, $response->getStatusCode());
		//$this->assertContains('"Status":1', (string)$response->getBody());
		//$this->assertNotContains('"Status":0', (string)$response->getBody());
		$this->assertRegExp('/{"Status":0,"Message":".*"}/', (string)$response->getBody());
	 }
	 
		/**
	 * Checks response and passes test if response returned 1
	 */
	 Function checkResponseError($response)
	 {
		$this->assertEquals(200, $response->getStatusCode());
		//$this->assertContains('"Status":0', (string)$response->getBody());
		//$this->assertNotContains('"Status":1', (string)$response->getBody());
		$this->assertRegExp('/{"Status":1,"Message":".*"}/', (string)$response->getBody());
	 }
	 
    /**
     * Test that GroupColor route return a status of 0
     */
    public function testSetGroupColor()
    {
        $response = $this->runApp('GET', '/rgbw/color/r/255/g/255/b/255/3/');
		$this->checkResponse($response);

    }
	
	/**
     * Test GroupColor, by generating an error intentionally, return status 1
     */
    public function testSetGroupColorError()
    {
        $response = $this->runApp('GET', '/rgbw/color/r/255/g/255/b/255/5/');
		$this->checkResponseError($response);
    }
	
	
	/**
     * Test that On route return a status of 0
     */
    public function testSetGroupOn()
    {
        $response = $this->runApp('GET', '/rgbw/on/3/');
		$this->checkResponse($response);

    }
	
	/**
     * Test On, by generating an error intentionally, return status 1
     */
    public function testSetGroupOnError()
    {
        $response = $this->runApp('GET', '/rgbw/on/5/');
		$this->checkResponseError($response);
    }
	
	
	
	/**
     * Test that Off route return a status of 0
     */
    public function testSetGroupOff()
    {
        $response = $this->runApp('GET', '/rgbw/off/3/');
		$this->checkResponse($response);

    }
	
	/**
     * Test Off, by generating an error intentionally, return status 1
     */
    public function testSetGroupOffError()
    {
        $response = $this->runApp('GET', '/rgbw/off/5/');
		$this->checkResponseError($response);
    }

		
	/**
     * Test that SetGroupBrightness route return a status of 0
     */
    public function testSetGroupBrightness()
    {
        $response = $this->runApp('GET', '/rgbw/brightness/100/3/');
		$this->checkResponse($response);

    }
	
	/**
     * Test SetGroupBrightness, by generating an error intentionally, return status 1
     */
    public function testSetGroupBrightnessError()
    {
        $response = $this->runApp('GET', '/rgbw/brightness/100/5/');
		$this->checkResponseError($response);
    }


}