<?php
/**
 * PHP Version 5
 *
 * @category Decoder
 * @package  PaxListConverter
 * @author   stephane-wis <on5wis@mac.com>
 * @license  MIT http://choosealicense.com/licenses/mit/
 * @link     github.com:EU-maritime/PaxListConverter-PHP
 */

/**
 * The Decoder for Json files
 *
 * @category Decoder
 * @package  PaxListConverter
 * @author   stephane-wis <on5wis@mac.com>
 * @license  MIT http://choosealicense.com/licenses/mit/
 * @link     github.com:EU-maritime/PaxListConverter-PHP
 */
class JsonDecoder implements DecoderInterface
{
    /**
     * The concrete function for decoding
     *
     * @param array $data : the content of the Pax List
     *
     * @return stdClass|null
     */
    public function decode($data)
    {
        log_message('info', ' entering '.__METHOD__);
        $rtn = $this->prepareData($data);
        return $rtn;
    }

    /**
     * Preparing the content
     *
     * @param string $dataFile : the file to be read and decoded
     *
     * @return mixed
     */
    protected function prepareData($dataFile)
    {
        $contents = file_get_contents($dataFile);
        $rtn = json_decode($contents, true);

        return $rtn;
    }
}
