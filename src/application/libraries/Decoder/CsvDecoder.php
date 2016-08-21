<?php
require_once LIBRARIES.'Decoder/DecoderInterface.php';
/**
 * Created by PhpStorm.
 * User: EU-maritime/PaxListConverter
 * Date: 22/07/16
 * Time: 13:33
 */
class CsvDecoder implements DecoderInterface
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
		$dataLine = [];
		$handle = fopen($dataFile, 'rt');
		if ($handle) {
			//read first line
			$keys = fgetcsv($handle);
			if ($keys) {
				//verify keys
			}
			$ct = 0;
			while ($nextLine = fgetcsv($handle)) {
				$dataLine[] = array_combine($keys, $nextLine);
				++$ct;
			}
			//create std struct
			//return std struct
		}
		return $dataLine;
	}
}

