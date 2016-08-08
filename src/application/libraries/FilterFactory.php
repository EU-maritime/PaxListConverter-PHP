<?php
require_once 'Filter/FilterFactoryInterface.php';
/**
 * Created by PhpStorm.
 * User: EU-maritime/PaxListConverter
 * Date: 22/07/16
 * Time: 13:35
 */
class FilterFactory implements FilterFactoryInterface
{
	private $factories = [];

	/**
	 * Register a callable that returns an instance of EncoderInterface for the given format
	 *
	 * @param string   $format
	 * @param callable $factory
	 */
	public function addFiltererFactory($format, callable $factory)
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

	public function test()
	{
		echo __METHOD__.'<br>';
	}
}
