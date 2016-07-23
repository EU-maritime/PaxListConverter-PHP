<?php

/**
 * Created by PhpStorm.
 * User: wis
 * Date: 22/07/16
 * Time: 13:34
 */
interface EncoderFactoryInterface
{
	/**
	 * Create a encoder for the given format
	 *
	 * @param string $format
	 * @return EncoderInterface concrete Class defined by $format
	 */

	public function createForFormat($format);
}
