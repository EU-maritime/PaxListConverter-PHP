<?php
/**
 * Created by PhpStorm.
 * User: wis
 * Date: 21/07/16
 * Time: 14:08
 */

class Load extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['name'] = '';
		if ($_FILES) {
			//print_r($_FILES);
			echo '<hr>';
			$filedata = $_FILES['filedata'];
			$dataName = $filedata['name'];
			$dataType = $filedata['type'];
			$dataError = $filedata['error'];
			$dataSize = $filedata['size'];
			if ($dataError == 0) {

				switch ($dataType) {
					case 'text/plain': //tab separated
					case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'://excel new
					case 'application/vnd.ms-excel': //excel old
					case 'text/csv': //comma separated
						$data['allowed'] = 'yes';
						$this->convertData($filedata['tmp_name'], $dataType);
					break;
					default;
						$data['allowed'] = 'no';
				}
			}
			$data['name'] = $dataName;
			$data['type'] = $dataType;
			$data['error'] = $dataError;
			$data['size'] = $dataSize;
		}
		$this->load->view('Load', $data);
	}

	public function convertData($file, $format)
	{
		$this->load->library('DecoderFactory');

		$str = file_get_contents($file);
		echo '<table border="1px"><tr><td>';
		$strData = str_replace(["\t","\n"], ['</td><td>', '</td></tr><tr><td>'], $str);
		echo $strData;
		echo '</td></tr></table>';

	}
}
