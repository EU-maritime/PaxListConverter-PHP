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
 * The Decoder for Text file
 *
 * @category Decoder
 * @package  PaxListConverter
 * @author   stephane-wis <on5wis@mac.com>
 * @license  MIT http://choosealicense.com/licenses/mit/
 * @link     github.com:EU-maritime/PaxListConverter-PHP
 */

class TxtDecoder implements DecoderInterface
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
        $data = $this->prepareData($data);

        return $data;
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
        $handle = fopen($dataFile, 'rt');
        //read first line
        $keyLine = fgets($handle);
        if ($keyLine) {
            //get rid to LF and CR
            $keyLine = str_replace(["\n", "\r"], '', $keyLine);
            //get keys into array
            $keys = explode("\t", $keyLine);
            //verify keys
        }
        $ct = 0;
        while ($nextLine = fgets($handle)) {
            //get rid to LF and CR
            $nextLine = str_replace(["\n", "\r"], '', $nextLine);
            //get data into array
            $data = explode("\t", $nextLine);
            $dataLine[] = array_combine($keys, $data);
            ++$ct;
        }

        return $dataLine;
    }
}
