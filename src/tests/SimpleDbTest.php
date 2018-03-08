<?php

namespace SimpleDb\Test;

use \PHPUnit\Framework\TestCase;
use SimpleDb\SimpleDb;

class SimpleDbTest extends TestCase
{
	/**
	 * @var SimpleDb
	 */
	protected $dbm;

	/**
	 * @var AdapterInterface
	 */
	protected $adapter;

	public function setUp()
	{
		/*Creates a mock object to inject*/
		$this->adapter = $this->getMockBuilder('SimpleDb\Adapter\AdapterInterface')
							->getMock(); 

		$this->dbm = new SimpleDb($this->adapter);
	}

	public function testIfFindAllMethodReturnsEmptyWhenNoRecordsExists()
	{
		$this->adapter->expects($this->once())
					->method('read')
					->will($this->returnValue(array()));

		$data = $this->dbm->findAll();

		$this->assertEquals(array(), $data);
	}

	public function testIfFindAllMethodReturnsDataCollectionFromSimpleDb()
	{
		$contentToReturn = array("table" => "name");

		$this->adapter->expects($this->once())
			->method('read')
			->will($this->returnValue($contentToReturn));		

		$expected = array("table" => "name");
		$result = $this->dbm->findAll();
		
		$this->assertEquals($expected, $result);
	}
}