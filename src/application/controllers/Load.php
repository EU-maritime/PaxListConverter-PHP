<?php
require_once LIBRARIES.'Decoder/Excel5Decoder.php';
require_once LIBRARIES.'Decoder/Excel2007Decoder.php';
require_once LIBRARIES.'Decoder/TxtDecoder.php';
require_once LIBRARIES.'Decoder/CsvDecoder.php';
require_once LIBRARIES.'Decoder/DecoderInterface.php';
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
		$data['list'] = '';
		if ($_FILES) {
			//print_r($_FILES);
			echo '<hr>';
			$filedata = $_FILES['filedata'];
			$dataName = $filedata['name'];
			$dataType = $filedata['type'];
			$dataError = $filedata['error'];
			$dataSize = $filedata['size'];
			$dataList = '';

			if ($dataError == 0) {
				switch ($dataType) {
					case 'text/plain': //tab separated
					case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'://excel new
					case 'application/vnd.ms-excel': //excel old Excel5
					case 'text/csv': //comma separated
						$data['allowed'] = 'yes';
						$dataList = $this->convertData($filedata['tmp_name'], $dataType);
					break;
					default;
						$data['allowed'] = 'no';
				}
			}
			$data['name'] = $dataName;
			$data['type'] = $dataType;
			$data['error'] = $dataError;
			$data['size'] = $dataSize;
			$data['list'] = $dataList;
		}
		$this->load->view('Load', $data);
	}

	public function convertData($file, $fileFormat)
	{
		$this->load->library('DecoderFactory');
		$decoderFactory = new DecoderFactory();
		$decoderFactory->test();
		switch ($fileFormat){
			case 'application/vnd.ms-excel': //excel old Excel5
				$format = 'Excel5';
				$decoderFactory->addDecoderFactory(
					$format,
					function(){return new Excel5Decoder();}
				);
			break;
			case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
				$format = 'Excel2007';
				$decoderFactory->addDecoderFactory(
					$format,
					function(){return new Excel2007Decoder();}
				);
			break;
			case 'text/plain': //tab separated
				$format = 'Txt';
				$decoderFactory->addDecoderFactory(
					$format,
					function(){return new TxtDecoder();}
				);
			break;
			case 'text/csv': //comma separated value
				$format = 'Csv';
				$decoderFactory->addDecoderFactory(
					$format,
					function(){return new CsvDecoder();}
				);
			break;
			default:
				log_message('INFO', 'Unsupported format: '.$fileFormat);
				return;
		}

		$this->load->library('GenericDecoder', [$decoderFactory]);
		$genericDecoder = new GenericDecoder($decoderFactory);
		$genericDecoder->test();
		$list = $genericDecoder->decodeToFormat($file, $format);

		return $list;
	}
}
