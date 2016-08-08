<?php
/**
 * Created by PhpStorm.
 * User: EU-maritime/PaxListConverter
 * Date: 22/07/16
 * Time: 13:41
 */
class GenericEncoder
{
	private $encoderFactory;

	/**
	 * GenericEncoder constructor.
	 * @param EncoderFactory $encoderFactory
	 */
	public function __construct(/*EncoderFactory*/ $params)
	{
		$this->encoderFactory = $params;
	}

	/**
	 * @param $data
	 * @param string $format
	 * @return mixed
	 */
	public function encodeToFormat ($data, $format)
	{
		$encoder = $this->encoderFactory->createForFormat($format);
		$rtn = $encoder->encode($data);

		return $rtn;
	}

	public function test()
	{
		echo __METHOD__.'<br>';
	}
}
