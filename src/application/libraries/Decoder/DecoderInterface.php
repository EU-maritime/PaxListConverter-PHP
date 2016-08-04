<?php

/**
 * Created by PhpStorm.
 * User: wis
 * Date: 22/07/16
 * Time: 13:31
 */
interface DecoderInterface
{
	/**
	 * @param string $format
	 * @return stdClass|null decode $data
	 */
	public function decode($format);
}
