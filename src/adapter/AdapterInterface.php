<?php

namespace SimpleDb\Adapter;


/**
 * Interface AdapterInterface describes the needed methods to
 * implement on adapters for SimpleDb 
 *  
 * @author Marcelo T. dos Santos <marcelo.teixeira@poli.ufrj.br> 
 */
interface AdapterInterface
{
	/**
	 * @return array
	 */
	public function read();

	/**
	 * @param array $data
	 */
	public function write(array $data);
}