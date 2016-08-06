<?php
require_once LIBRARIES.'Decoder/DecoderInterface.php';
require_once VENDOR . 'phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php';
/**
 * Created by PhpStorm.
 * User: wis
 * Date: 22/07/16
 * Time: 13:33
 */
class ExcelDecoder implements DecoderInterface
{
	public function __construct($excelVersion)
	{
		$this->ExcelVersion = $excelVersion;
		$this->excelFirst = '1900-01-01';
	}

	/**
	 * @param $data
	 * @return stdClass|null
	 */
	public function decode($data)
	{
		$data = $this->prepareData($data);
		$data = $this->fixDate($data);
		return $data;
	}

	/**
	 * @param array $data
	 * @return array
	 */
	public function fixDate($data)
	{
		foreach($data as &$line){
			foreach ($line as $k => &$v){
				if (strtoupper(substr($k, -5)) == 'EXCEL'){
					$v = $this->convertDate($v);
				}
			}
		}
		return $data;//TODO change me
	}

	/**
	 * @param integer $exceldate
	 * @return string
	 */
	public function convertDate($exceldate)
	{
		$firstDate = new DateTime($this->excelFirst);	//get date of first excel date
		$firstDate->add(new DateInterval('P'.$exceldate.'D'));		    //add $exceldate days to first excel date
		$rtn = $firstDate->format('Y-m-d');     		//return YYYY-MM-DD datum

		return $rtn;
	}

	/**
	 * @param $data the file to be read and decoded
	 * @return mixed
	 */
	private function prepareData($data)
	{
		$fields = [];
		$dbFields = [];

		$objReader = PHPExcel_IOFactory::createReader($this->ExcelVersion);
		$objPHPExcel = $objReader->load($data);
		if ($objPHPExcel) {
			foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
					foreach ($worksheet->getRowIterator() as $row) {
						$rowIdx = $row->getRowIndex();
						$cellIterator = $row->getCellIterator();
						$cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
						if($rowIdx == 1) {//get columns name
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
									if (array_key_exists($colIdx, $dbFields)){
										$wh[$dbFields[$colIdx]] = $cellValue;
									}
								}//cell
							}//cell iter data

							$dataLine[] = $wh;
						}
					}//row iter
				}
		} else {
			log_message('INFO', 'file '.$data.' is not an Excel5 format');
		}
		return $dataLine;
	}

	private function match(array $fields)
	{
//		print_r($fields);
//		echo '<br>';
		return $fields;
	}
}
