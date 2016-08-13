<?php

/**
 * Created by PhpStorm.
 * User: EU-maritime/PaxListConverter
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

		return $data;
	}

	/**
	 * @param $data
	 * @return mixed
	 */
	private function prepareData($data)
	{
		$data = json_encode($data);
		$data = str_replace('\"', '', $data);
		return $data;
	}
}
