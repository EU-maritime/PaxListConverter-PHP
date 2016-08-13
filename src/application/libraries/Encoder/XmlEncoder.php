<?php

/**
 * Created by PhpStorm.
 * User: EU-maritime/PaxListConverter
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
		return $data;
	}

	/**
	 * @param $data
	 * @return mixed
	 */
	private function prepareData($data)
	{
		// TODO: Implement prepareData() method.
		$dom = new DOMDocument('1.0', 'UTF-8');
		//root element
		$xmlRoot = $dom->createElement('Passengers');
		$xmlRoot = $dom->appendChild($xmlRoot);
		//other elements
		foreach ($data as $pax){
			echo '<br/>';
			$paxElement = $dom->createElement('pax');
			$paxElement = $xmlRoot->appendChild($paxElement);
			foreach($pax as $key => $val){
				//echo 'key : ' . $key . ' val : ' . $val.'<br/>';
				$paxElement->appendChild($dom->createElement($key, $val));
				//echo htmlentities($dom->saveXML());
				//echo '<br/>';
			}
		}
		return $dom;
	}
}
