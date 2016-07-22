<?php

/**
 * Created by PhpStorm.
 * User: wis
 * Date: 22/07/16
 * Time: 13:34
 */
interface EncoderFactoryInterface
{
	public function createForFormat($format);
}
