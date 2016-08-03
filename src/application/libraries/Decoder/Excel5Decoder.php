<?php
require_once LIBRARIES.'Decoder/DecoderInterface.php';
require_once VENDOR . 'phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php';
/**
 * Created by PhpStorm.
 * User: wis
 * Date: 22/07/16
 * Time: 13:33
 */
class Excel5Decoder implements DecoderInterface
{
	/**
	 * @param $data
	 * @return stdClass|null
	 */
	public function decode($data)
	{
		$data = $this->prepareData($data);

		return $data;
	}

	/**
	 * @param $data the file to be read and decoded
	 * @return mixed
	 */
	private function prepareData($data)
	{
		$fields = [];
		$dbFields = [];

		$objReader = PHPExcel_IOFactory::createReader('Excel5');
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

						//	echo '<br>';
							print_r($wh);
							echo '<br>';
						}
					}//row iter
				}
		} else {
			log_message('INFO', 'file '.$data.' is not an Excel5 format');
		}

		// TODO: Implement prepareData() method.
		return $data;
	}

	private function match(array $fields)
	{
		print_r($fields);
		echo '<br>';
		return $fields;
	}
}
