<?php

/**
 * Created by PhpStorm.
 * User: EU-maritime/PaxListConverter
 * Date: 22/07/16
 * Time: 13:31
 */
interface FilterInterface
{
	/**
	 * @param array $data
	 * @return array
	 */
	public function filter(array $data);
}
