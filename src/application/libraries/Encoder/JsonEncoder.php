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
 * Encoder for Json
 *
 * @category Encoder
 * @package  PaxListConverter
 * @author   stephane-wis <on5wis@mac.com>
 * @license  MIT http://choosealicense.com/licenses/mit/
 * @link     github.com:EU-maritime/PaxListConverter-PHP
 */
class JsonEncoder implements EncoderInterface
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
        $data = json_encode($data);
        $data = str_replace('\"', '', $data);
        return $data;
    }
}
