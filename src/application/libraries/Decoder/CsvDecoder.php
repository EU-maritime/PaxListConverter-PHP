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

require_once LIBRARIES.'Decoder/DecoderInterface.php';

/**
 * The CSV deocder
 *
 * @category Decoder
 * @package  PaxListConverter
 * @author   stephane-wis <on5wis@mac.com>
 * @license  MIT http://choosealicense.com/licenses/mit/
 * @link     github.com:EU-maritime/PaxListConverter-PHP
 */

class CsvDecoder implements DecoderInterface
{
    /**
     * The action to decode
     *
     * @param string $data : the file to be read and decoded
     *
     * @return stdClass|null
     */
    public function decode($data)
    {
        $data = $this->prepareData($data);

        return $data;
    }

    /**
     * A usefull function for de decoder
     *
     * @param string $dataFile : the file to be read and decoded
     *
     * @return mixed
     */
    protected function prepareData($dataFile)
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

