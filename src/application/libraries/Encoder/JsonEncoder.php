<?php

/**
 * Created by PhpStorm.
 * User: wis
 * Date: 22/07/16
 * Time: 13:33
 */
class JsonEncoder implements EncoderInterface
{
	/**
	 * @param $data
	 * @return string
	 */
	public function encode($data)
	{
		$data = $this->prepareData($data);

		return json_encode($data);
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
