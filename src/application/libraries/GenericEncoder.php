<?php

/**
 * Created by PhpStorm.
 * User: wis
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
	public function __construct(EncoderFactory $encoderFactory)
	{
		$this->encoderFactory = $encoderFactory;
	}

	/**
	 * @param $data
	 * @param string $format
	 * @return mixed
	 */
	public function encodeToFormat ($data, $format)
	{
		$encoder = $this->encoderFactory->createForFormat($data, $format);
		$rtn = $encoder->encode($data);

		return $rtn;
	}
}
