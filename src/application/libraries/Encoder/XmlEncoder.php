<?php

/**
 * Created by PhpStorm.
 * User: wis
 * Date: 22/07/16
 * Time: 13:32
 */
class XmlEncoder implements EncoderInterface
{
	/**
	 * @param $data
	 * @return mixed
	 */
	public function encode ($data)
	{
		$data = $this->prepareData($data);
		//TODO encode xml
		$xml = $data;//fake

		return $xml;
	}

	/**
	 * @param $data
	 * @return mixed
	 */
	private function prepareData($data)
	{
		// TODO: Implement prepareData() method.
		return $data;
	}
}
