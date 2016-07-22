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
		if ($_FILES) {
			//print_r($_FILES);
			echo '<hr>';
			$filedata = $_FILES['filedata'];
			$dataName = $filedata['name'];
			$dataType = $filedata['type'];
			$dataError = $filedata['error'];
			$dataSize = $filedata['size'];
			if ($dataError == 0) {
	//			echo $filedata['tmp_name'];
//				$file = fopen($filedata['tmp_name'], 'rb');
//				if ($file) {
//					//TODO
//					fclose($file);
//				}
				switch ($dataType) {
					case 'application/vnd.ms-excel':
					break;
				}
			}
		}
		$data['name'] = $dataName;
		$data['type'] = $dataType;
		$data['error'] = $dataError;
		$data['size'] = $dataSize;
		$this->load->view('Load', $data);
	}
}
