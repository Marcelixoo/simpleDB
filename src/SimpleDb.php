<?php

namespace SimpleDb;

use SimpleDb\Adapter\AdapterInterface;

class SimpleDb
{
	/**
	 * @var AdapterInterface
	 */
	protected $adapter;

	public function __construct(AdapterInterface $adapter)
	{
		$this->adapter = $adapter;
	}

	public function findAll()
	{
		$data = $this->adapter->read();

		return $data;
	}
}