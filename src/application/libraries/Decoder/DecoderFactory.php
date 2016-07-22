<?php

/**
 * Created by PhpStorm.
 * User: wis
 * Date: 22/07/16
 * Time: 13:35
 */
class DecoderFactory implements DecoderFactoryInterface
{
	private $factories = array();

	public function addDecoderFactory($format, callable $factory)
	{
		$this->factories[$format] = $factory;
	}

	public function createFromFormat ($format)
	{
		$factory = $this->factories[$format];
		$encoder = $factory();

		return $encoder;
	}
}
