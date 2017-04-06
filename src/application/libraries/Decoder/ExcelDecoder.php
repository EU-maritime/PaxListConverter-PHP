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

require_once VENDOR . 'phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php';

/**
 * The Decoder for Excel files
 *
 * @category Decoder
 * @package  PaxListConverter
 * @author   stephane-wis <on5wis@mac.com>
 * @license  MIT http://choosealicense.com/licenses/mit/
 * @link     github.com:EU-maritime/PaxListConverter-PHP
 */
class ExcelDecoder implements DecoderInterface
{
    /**
     * ExcelDecoder constructor.
     *
     * @param string $excelVersion : the identifier of the Excel version
     *
     * @return void
     */
    public function __construct($excelVersion)
    {
        $this->excelVersion = $excelVersion;

    }

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
        $data = $this->fixDate($data);
        return $data;
    }

    /**
     * Fixing the format of the dates
     *
     * @param array $data : the content of the Pax List
     *
     * @return array
     */
    public function fixDate($data)
    {
        foreach ($data as &$line) {
            foreach ($line as $k => &$v) {
                if (strtoupper(substr($k, -5)) == 'EXCEL') {
                    $v = $this->convertDate($v);
                }
            }
        }
        return $data;//TODO change me
    }

    /**
     * Converting dates
     *
     * @param integer $exceldate : the actual date
     *
     * @return string : the converted date
     */
    public function convertDate($exceldate)
    {
        //get date of first excel date:
        $firstDate = new DateTime($this->excelFirst); // Day 1
        //add $exceldate days to first excel date
        $nbDaysAfterDayOne = $exceldate - 1; // relative to Day 1 (not date 'zero')
        $firstDate->add(new DateInterval('P'.$nbDaysAfterDayOne.'D'));
        //return YYYY-MM-DD datum
        $rtn = $firstDate->format('Y-m-d');

        return $rtn;
    }

    /**
     * Preparing the content
     *
     * @param string $data : the file to be read and decoded
     *
     * @return mixed
     */
    protected function prepareData($data)
    {
        $fields = [];
        $dbFields = [];

        $objReader = PHPExcel_IOFactory::createReader($this->excelVersion);
        $objPHPExcel = $objReader->load($data);
        if ($objPHPExcel) {
            //set date format after successful load
            $basedate = PHPExcel_Shared_Date::getExcelCalendar();
            switch ($basedate) {
                case PHPExcel_Shared_Date::CALENDAR_WINDOWS_1900:
                    $this->excelFirst = '1900-01-01'; // Day 1 (day after day 'zero')
                    break;
                case PHPExcel_Shared_Date::CALENDAR_MAC_1904:
                    $this->excelFirst = '1904-01-02'; // Day 1 (day after day 'zero')
                    break;
            }
            foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                foreach ($worksheet->getRowIterator() as $row) {
                    $rowIdx = $row->getRowIndex();
                    $cellIterator = $row->getCellIterator();
                    // Loop all cells, even if it is not set
                    $cellIterator->setIterateOnlyExistingCells(false);
                    if ($rowIdx == 1) {//get columns name
                        foreach ($cellIterator as $cell) {
                            $colIdx = $cell->getColumn();
                            if (!is_null($cell)) {
                                $fields[$colIdx] = $cell->getCalculatedValue();
                            }
                        }//cell iter columns name
                        $dbFields = $this->match($fields);
                    } else { //get the data
                        foreach ($cellIterator as $cell) {
                            if (!is_null($cell)) {
                                $colIdx = $cell->getColumn();
                                $cellValue = $cell->getCalculatedValue();
                                if (array_key_exists($colIdx, $dbFields)) {
                                    $wh[$dbFields[$colIdx]] = $cellValue;
                                }
                            }//cell
                        }//cell iter data

                        $dataLine[] = $wh;
                    }
                }//row iter
            }
        } else {
            $msg = 'file '.$data.' is not an '.$this->excelVersion.' format';
            log_message('INFO', $msg);
        }
        return $dataLine;
    }

    /**
     * Converting Pax List fields
     *
     * @param array $fields : the fields
     *
     * @return array
     */
    protected function match(array $fields)
    {
        //		print_r($fields);
        //		echo '<br>';
        return $fields;
    }
}
