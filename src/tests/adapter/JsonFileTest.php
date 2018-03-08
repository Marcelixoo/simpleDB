<?php

namespace SimpleDb\Test\Adapter;

use \PHPUnit\Framework\TestCase;
use SimpleDb\Adapter\JsonFile;

class JsonFileTest extends TestCase
{
	/**
	 * @var JsonFile
	 */
	protected $adapter;

	public function setUp()
	{
		@unlink('/tmp/posts.json'); /* Apenas para teste, remove o arquivo caso exista! */
		$this->adapter = new JsonFile('/tmp/posts.json');
	}

	public function testIfAdapterIsInstanceOfAdapterInterface()
	{
		$this->assertInstanceOf('SimpleDb\Adapter\AdapterInterface', $this->adapter);
	}

	public function testIfCanReadDataFromJsonFile()
	{
		$content = '{"table":"value"}';
		file_put_contents('/tmp/posts.json', $content);
		
		$expected = array("table" => "value");
		$result = $this->adapter->read();

		$this->assertEquals($expected, $result);
	}

	/**
	 * @expectedException \RuntimeException
	 * @expectedExceptionMessage File "/tmp/posts.json" could not be read
	 */
	public function testIfThrowsAnExceptionWhenFileCannotBeRead()
	{
		@unlink('/tmp/posts.json'); /* Remove o arquivo para gerar um erro */
		$this->adapter->read();
	}

	/**
	 * @expectedException \RuntimeException
	 * @expectedExceptionMessage Content of file "/tmp/posts.json" is not a valid json file 
	 */
	public function testIfThrowsAnExceptionWhenContentCannotBeConvertedToArray()
	{
		file_put_contents('/tmp/posts.json', 'invalid json content');
		$this->adapter->read();
	}

	public function testIfCanSaveDataOnJsonFile()
	{
		$content = array("table" => "value");
		$this->adapter->write($content);

		$expected = '{"table":"value"}';
		$actualContent = file_get_contents('/tmp/posts.json');

		$this->assertEquals($expected, $actualContent);
	}

	/**
	 * @expectedException \RuntimeException
	 * @expectedExceptionMessage File "/posts.json" could not be written
	 */
	public function testIfThrowsAnExceptionWhenFileCannotBeWritten()
	{
		$adapter = new JsonFile('/posts.json'); /* Could have root credentials */
		
		$adapter->write(array());
	}

	public function testIfReturnsAnEmptyArrayWhenContentIsBlank()
	{
		exec('touch /tmp/posts.json'); /*Create an empty file*/
		
		$data = $this->adapter->read();

		$this->assertEquals(array(), $data);
	}
}