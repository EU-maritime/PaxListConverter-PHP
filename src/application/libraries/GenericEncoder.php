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
		$encoder = $this->encoderFactory->createForFormat($data, $format);
		$data = $this->encoder->prepareData($data);
		$rtn = $encoder->encode($data);

		return $rtn;
	}

	public function prepareData($data, $format)
	{//TODO
		return $data;
	}

}
