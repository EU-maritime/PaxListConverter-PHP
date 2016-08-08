<?php

/**
 * Created by PhpStorm.
 * User: EU-maritime/PaxListConverter
 * Date: 22/07/16
 * Time: 13:33
 */
class JsonDecoder implements DecoderInterface
{
	/**
	 * @param $data
	 * @return stdClass|null
	 */
	public function decode($data)
	{
		$data = $this->prepareData($data);

		return json_decode($data);
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
