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
	 * @param $data the file to be read
	 * @return stdClass|null
	 */
	public function decode($data)
	{
		$rtn = $this->prepareData($data);

		return $rtn;
	}

	/**
	 * @param $data
	 * @return mixed
	 */
	private function prepareData($dataFile)
	{
		$contents = file_get_contents($dataFile);
		$rtn = json_decode($contents, true);

		return $rtn;
	}
}
