<?php
/**
 * Created by PhpStorm.
 * User: wis
 * Date: 22/07/16
 * Time: 13:41
 */
class GenericFilter
{
	private $filterFactory;

	/**
	 * GenericFilter constructor.
	 * @param FilterFactory $filterFactory
	 */
	public function __construct(/*FilterFactory*/ $params)
	{
		$this->filterFactory = $params;
	}

	/**
	 * @param $data
	 * @param string $format
	 * @return mixed
	 */
	public function filterToFormat ($data, $format)
	{
		$encoder = $this->filterFactory->createForFormat($format);
		$rtn = $encoder->filter($data);

		return $rtn;
	}

	public function test()
	{
		echo __METHOD__.'<br>';
	}
}
