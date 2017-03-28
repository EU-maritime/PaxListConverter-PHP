<?php

/**
 * Created for PaxListConverter.
 * User: wis
 * Date: 19/03/2017
 * Time: 12:12
 */
class ExcelFal5SpnDecoder implements DecoderInterface
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
        $this->excelFirst = '1904-01-01';
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
        $firstDate = new DateTime($this->excelFirst);
        //add $exceldate days to first excel date
        $firstDate->add(new DateInterval('P'.$exceldate.'D'));
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
