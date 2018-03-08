<?php

namespace SimpleDb\Adapter;

use SimpleDb\Adapter\AdapterInterface;

class JsonFile implements AdapterInterface
{
	/**
	 * @param string $file filepath to the json file that contains the posts 
	 */
	protected $file;

	public function __construct($file)
	{
		$this->file = $file;
	}

	/**
	 * @return array 
	 */
	public function read()
	{
		$contents = @file_get_contents($this->file);

		if ($contents === false) {
			throw new \RuntimeException(
				sprintf('File "%s" could not be read', $this->file)
			);
		}

		$data = json_decode($contents, true);

		if (!is_array($data)) {
			throw new \RuntimeException(
				sprintf('Content of file "%s" is not a valid json file', $this->file)
			);
		}

		return $data;
	}

	/**
	 * @throws \RuntimeException
	 */
	public function write(array $data)
	{
		$content = json_encode($data);
		$result = @file_put_contents($this->file, $content); /* Check if the file could be written */

		if ($result === false) {
			throw new \RuntimeException(
				sprintf('File "%s" could not be written', $this->file)
			);
		}

		return true;
	}
}