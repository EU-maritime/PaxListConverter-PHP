<?php
require_once LIBRARIES.'Decoder/DecoderInterface.php';

/**
 * Created by PhpStorm.
 * User: wis
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
		$str = file_get_contents($dataFile);
		$data = '<table border="1px"><tr><td>';
		$strData = str_replace([",","\r"], ['</td><td>', '</td></tr><tr><td>'], $str);
		$data .= $strData;
		$data .= '</td></tr></table>';

		return $data;
	}
}
