<?php
require_once 'Decoder/DecoderFactoryInterface.php';
/**
 * Created by PhpStorm.
 * User: wis
 * Date: 22/07/16
 * Time: 13:35
 */
class DecoderFactory implements DecoderFactoryInterface
{
	private $factories = array();

	/**
	 * Register a callable that returns an instance of DecoderInterface for the given format
	 * @param string   $format
	 * @param callable $factory
	 */
	public function addDecoderFactory($format, callable $factory)
	{
		$this->factories[$format] = $factory;
	}

	/**
	 * @param string $format
	 * @return DecoderInterface concrete Class defined by $format
	 */
	public function createForFormat ($format)
	{
		$factory = $this->factories[$format];
		$decoder = $factory();

		return $decoder;
	}

	public function test()
	{
		echo __METHOD__.PHP_EOL;
	}
}
