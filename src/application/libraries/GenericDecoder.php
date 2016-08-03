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

	/**
	 * GenericDecoder constructor.
	 * @param DecoderFactory $decoderFactory
	 */
	public function __construct(/*DecoderFactoryInterface*/ $decoderFactory)
	{
		$this->decoderFactory = $decoderFactory;
	}

	/**
	 * @param $data
	 * @param string $format
	 * @return mixed
	 */
	public function decodeToFormat ($data, $format)
	{
		$decoder = $this->decoderFactory->createForFormat($format);
		$rtn = $decoder->decode($data);

		return $rtn;
	}

	public function test()
	{
		echo __METHOD__.'<br>';
	}
}
