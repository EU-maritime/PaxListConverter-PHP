<?php

/**
 * Created by PhpStorm.
 * User: wis
 * Date: 22/07/16
 * Time: 13:41
 */
class GenericDecoder
{
	private $decoderFactory;

	public function __construct(DecoderFactory $decoderFactory)
	{
		$this->decoderFactory =$decoderFactory;
	}

	public function decodeToFormat ($data, $format)
	{
		$decoder = $this->decoderFactory->createForFormat($data, $format);
		$data = $decoder->prepareData($data);
		$rtn = $decoder->decode($data);

		return $rtn;
	}

	public function prepareData($data, $format)
	{
		return $data;
	}

}
