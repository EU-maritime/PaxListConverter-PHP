<?php
require_once 'Encoder/EncoderFactoryInterface.php';

/**
 * Created by PhpStorm.
 * User: wis
 * Date: 22/07/16
 * Time: 13:35
 */
class EncoderFactory implements EncoderFactoryInterface
{
	private $factories = array();

	/**
	 * Register a callable that returns an instance of EncoderInterface for the given format
	 *
	 * @param          $format
	 * @param callable $factory
	 */
	public function addEncoderFactory($format, callable $factory)
	{
		$this->factories[$format] = $factory;
	}

	/**
	 * @param string $format
	 * @return EncoderInterface concrete Class defined by $format
	 */
	public function createForFormat ($format)
	{
		$factory = $this->factories[$format];
		$encoder = $factory();

		return $encoder;
	}
}
