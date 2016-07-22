<?php

/**
 * Created by PhpStorm.
 * User: wis
 * Date: 22/07/16
 * Time: 13:35
 */
class EncoderFactory implements EncoderFactoryInterface
{
	private $factories = array();

	public function addEncoderFactory($format, callable $factory)
	{
		$this->factories[$format] = $factory;
	}

	public function createForFormat ($format)
	{
		$factory = $this->factories[$format];
		$encoder = $factory();

		return $encoder;
	}
}
