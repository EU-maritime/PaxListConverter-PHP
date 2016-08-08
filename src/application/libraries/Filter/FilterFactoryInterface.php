<?php

/**
 * Created by PhpStorm.
 * User: EU-maritime/PaxListConverter
 * Date: 22/07/16
 * Time: 13:34
 */
interface FilterFactoryInterface
{
	/**
	 * Create a filter for the given format
	 *
	 * @param string $format
	 * @return FilterInterface concrete Class defined by $format
	 */

	public function createForFormat($format);
}
