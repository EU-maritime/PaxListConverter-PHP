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

	public function __construct(EncoderFactory $encoderFactory)
	{
		$this->encoderFactory =$encoderFactory;
	}

	public function encodeToFormat ($data, $format)
	{
		$encoder = $this->encoderFactory->createForFormat($format);
		$data = $this->prepareData($data, $format);
		$rtn = $encoder->encode($data);

		return $rtn;
	}

	public function prepareData($data, $format)
	{
		return $data;
	}

}
