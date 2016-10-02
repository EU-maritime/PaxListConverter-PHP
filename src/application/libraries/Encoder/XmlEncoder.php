<?php
/**
 * PHP Version 5
 *
 * @category Encoder
 * @package  PaxListConverter
 * @author   stephane-wis <on5wis@mac.com>
 * @license  MIT http://choosealicense.com/licenses/mit/
 * @link     github.com:EU-maritime/PaxListConverter-PHP
 */
/**
 * Encoder for Xml
 *
 * @category Encoder
 * @package  PaxListConverter
 * @author   stephane-wis <on5wis@mac.com>
 * @license  MIT http://choosealicense.com/licenses/mit/
 * @link     github.com:EU-maritime/PaxListConverter-PHP
 */
class XmlEncoder implements EncoderInterface
{
    /**
     * The concrete function for encoding
     *
     * @param array $data : the content of the Pax List
     *
     * @return stdClass|null
     */
    public function encode($data)
    {
        $data = $this->prepareData($data);
        //TODO encode xml
        return $data;
    }

    /**
     * Preparing the content
     *
     * @param string $data : the file to be encoded and written
     *
     * @return mixed
     */
    protected function prepareData($data)
    {
        // TODO: Implement prepareData() method.
        $dom = new DOMDocument('1.0', 'UTF-8');
        //root element
        $xmlRoot = $dom->createElement('Passengers');
        $xmlRoot = $dom->appendChild($xmlRoot);
        //other elements
        foreach ($data as $pax) {
            $paxElement = $dom->createElement('pax');
            $paxElement = $xmlRoot->appendChild($paxElement);
            foreach ($pax as $key => $val) {
                $paxElement->appendChild($dom->createElement($key, $val));
            }
        }

        return $dom;
    }
}
