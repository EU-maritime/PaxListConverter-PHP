<?php

/**
 * Created by PhpStorm.
 * User: EU-maritime/PaxListConverter
 * Date: 22/07/16
 * Time: 13:32
 */
class XmlDecoder implements DecoderInterface
{
	/**
	 * @param $data
	 * @return mixed
	 */
	public function decode ($data)
	{
		$data = $this->prepareData($data);
		return $data;
	}

	/**
	 * @param $data
	 * @return mixed
	 */
	private function prepareData($dataFile)
	{
		$data = [];
		$xml = simplexml_load_file($dataFile);
		$paxArray = $xml->pax;
		foreach($paxArray as $row) {
			foreach($row as $k => $v) {
				$line[$k] = $v;
			}
			$data[] = $line;
			unset($line);
		}

		return $data;
	}
}
