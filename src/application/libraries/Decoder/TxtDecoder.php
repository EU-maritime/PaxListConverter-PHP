<?php
require_once LIBRARIES.'Decoder/DecoderInterface.php';

/**
 * Created by PhpStorm.
 * User: EU-maritime/PaxListConverter
 * Date: 22/07/16
 * Time: 13:33
 */
class TxtDecoder implements DecoderInterface
{
	/**
	 * @param mixed $data
	 * @return stdClass|null
	 */
	public function decode($data)
	{
		$data = $this->prepareData($data);

		return $data;
	}

	/**
	 * @param mixed $data the file to be read and decoded
	 * @return mixed
	 */
	private function prepareData($dataFile)
	{
		$handle = fopen($dataFile, 'rt');
		//read first line
		$keyLine = fgets($handle);
		if ($keyLine){
			//get keys into array
			$keys = explode("\t", $keyLine);
			//verify keys
		}
		$ct = 0;
		while ($nextLine = fgets($handle)){
			$data = explode("\t", $nextLine);
			$dataLine[] = array_combine($keys, $data);
			++$ct;
		}

		return $dataLine;
	}
}
