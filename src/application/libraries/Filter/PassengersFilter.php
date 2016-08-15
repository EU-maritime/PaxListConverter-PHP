<?php

/**
 * Created by PhpStorm.
 * User: EU-maritime/PaxListConverter
 * Date: 22/07/16
 * Time: 13:32
 */
class PassengersFilter implements FilterInterface
{
	public $fields;
	public $dateFormats;

	public function __construct()
	{
		$this->fields = [
			'CPS'           => 'CPS',
			'FIRSTNAME'     => 'CP',
		    'LASTNAME'      => 'CP',
		    'NATIONALITY'   => 'CP',
		    'RANKORRATING'  => 'C',
		    'TYPEOFID'      => 'CP',
		    'SERIALNRID'    => 'CP',
		    'SERIALNRVISA'  => 'P',     //necessary ev. empty
		    'EXPDATE_'      => 'CP',
		    'BIRTHDATE_'    => 'CP',
		    'PLACEOFBIRTH'  => 'CP',
		    'EMBARKATION'   => 'P',
		    'DISEMBARKATION'=> 'P',
		];
		$this->dateFormats = [
			'YYYY-MM-DD' => 'Y-m-d',  'YY-MM-DD' => 'y-m-d',
			'YYYY/MM/DD' => 'Y/m/d',  'YY/MM/DD' => 'y/m/d',
			'DD-MM-YYYY' => 'd-m-Y',  'DD-MM-YY' => 'd-m-y',
			'DD/MM/YYYY' => 'd/m/Y',  'DD/MM/YY' => 'd/m/y',
			'MM-DD-YYYY' => 'm-d-Y',  'MM-DD-YY' => 'm-d-y',
			'MM/DD/YYYY' => 'm/d/Y',  'MM/DD/YY' => 'm/d/y',
			'EXCEL'      => 'EXCEL',
		];
	}

	/**
	 * @param array $data
	 * @return array
	 */
	public function filter (array $data)
	{
		//read first line
		$firstLine = $data[0];
		//check if the required fields are present
		$foundFormat = [];
		$missingPFields = $this->findMissingFields('P', $firstLine, $foundFormat);
		$missingCFields = $this->findMissingFields('C', $firstLine, $foundFormat);
		print_r($foundFormat);
		echo '<br/>missing fields for P ';
		print_r($missingPFields);
		echo '<br/>missing fields for C ';
		print_r($missingCFields);

		$filteredC = $this->prepareData('C', $data);
		$filteredP = $this->prepareData('P', $data);
		return array_merge($filteredC, $filteredP);
	}


	/**
	 * @param string $cat
	 * @param array of dict $data
	 * @return array
	 */
	private function prepareData(/* string */$cat, array $data)
	{
		$dataOut = [];
		foreach ($data as $row){
			if ($row['CPS'] != $cat)
				continue;

			$rowOut = [];
			foreach($row as $key => $val)
			{
				$key = strtoupper($key);
				$pos = strpos($key, '_');
				if ($pos !== false){
					$fmt = substr($key, $pos + 1);
					$fmt = $this->dateFormats[$fmt];
					$key = substr($key, 0, $pos);
				}
				switch ($key){
					case 'EXPDATE':
					case 'BIRTHDATE':
						if ($fmt == 'EXCEL'){
							$rowOut[$key] = $val;
						} else {
							$date = DateTime::createFromFormat($fmt, $val);
							$rowOut[$key] = $date->format('Y-m-d');//canonic date for CBS
						}
					break;
					default:
						$rowOut[$key] = strtoupper($val);
				}
			}
			$dataOut[] = $rowOut;
		}
		return $dataOut;
	}

	/**
	 * @param string $cat
	 * @return array
	 */
	private function getFieldsFor(/* string */$cat)
	{
		$fields = [];
		foreach ($this->fields as $k => $v){
			if (strpos($v, $cat) !== false){
				$fields[] = $k;
			}
		}

		return $fields;
	}

	/**
	 * @param string $cat
	 * @param string $firstLine
	 * @param &array $foundFormat
	 * @return array
	 */
	private function findMissingFields($cat, $firstLine, &$foundFormat)
	{
		$mandatory = $this->getFieldsFor($cat);
		$keys = array_keys($firstLine);
		foreach($keys as &$k){
			$k = strtoupper($k);
			$pos = strpos($k, '_');
			if ($pos !== false){
				$dateFormat = substr($k, $pos+1);
				$k = substr($k, 0, $pos+1);
				$foundFormat[$k] = $this->dateFormats[$dateFormat];
			}
		}
		asort($keys);
		asort($mandatory);
		$result = array_diff($mandatory, $keys);
		return $result;
	}
}
