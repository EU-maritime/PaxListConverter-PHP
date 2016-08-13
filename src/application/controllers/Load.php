<?php
require_once LIBRARIES.'Decoder/DecoderInterface.php';
require_once LIBRARIES.'Decoder/ExcelDecoder.php';
require_once LIBRARIES.'Decoder/TxtDecoder.php';
require_once LIBRARIES.'Decoder/CsvDecoder.php';
require_once LIBRARIES.'Encoder/EncoderInterface.php';
require_once LIBRARIES.'Encoder/HtmlEncoder.php';
require_once LIBRARIES.'Encoder/XmlEncoder.php';
require_once LIBRARIES.'Encoder/JsonEncoder.php';
require_once LIBRARIES.'Filter/FilterInterface.php';
require_once LIBRARIES.'Filter/PaxCbsFilter.php';
/**
 * Created by PhpStorm.
 * User: EU-maritime/PaxListConverter
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
		$data['xml']  = '';
		$data['xmlFile'] = '';
		$data['json'] = '';
		$data['allowed'] = 'no';
		//Decoder part
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
						$dataList = $this->decodeData($filedata['tmp_name'], $dataType);
					break;
					default;
						$data['allowed'] = 'no';
				}
			}
		}
		//Filter part (PaxCbsFilter)
		if ($data['allowed'] === 'yes'){
			$format = 'PaxCbs';
			$dataList = $this->filterData($format, $dataList);
		}
		//Encoder part (HtmlEncoder)
		if ($data['allowed'] === 'yes'){
			$now = new DateTime('now', new DateTimeZone('UTC'));
			$now = $now->format('Y-m-d\TH:i:s\Z');
			$data['name'] = $dataName;
			$data['type'] = $dataType;
			$data['error'] = $dataError;
			$data['size'] = $dataSize;
			//output HTML
			$format = 'HTML';
			$dataHTML = $this->encodeData($format, $dataList);
			$data['list'] = $dataHTML;

			//output XML
			$format = 'XML';
			$dataXML = $this->encodeData($format, $dataList);
			$data['xml'] = $dataXML->saveXML();
			//as file
			$paxFileName = 'PaxList'.$now;
			$nbChars = $dataXML->save('/tmp/'.$paxFileName.'.xml');
			$data['xmlFile'] = $paxFileName.'.xml : '.$nbChars.' chars';

			//output JSON
			$format = 'JSON';
			$dataJSON = $this->encodeData($format, $dataList);
			$data['json'] = $dataJSON;
			//as file
			$nbChars = file_put_contents('/tmp/'.$paxFileName.'.json', $dataJSON);
			$data['jsonFile'] = $paxFileName.'.json : '.$nbChars.' chars';
		}
		//show view
		$this->load->view('load', $data);

	}

	/**
	 * @param string $file
	 * @param string $fileFormat
	 * @return mixed|void
	 */
	public function decodeData($file, $fileFormat)
	{
		$this->load->library('DecoderFactory');
		$decoderFactory = new DecoderFactory();
		switch ($fileFormat){
			case 'application/vnd.ms-excel': //excel old Excel5
				$format = 'Excel5';
				$decoderFactory->addDecoderFactory(
					$format,
					function(){return new ExcelDecoder('Excel5');}
				);
			break;
			case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
				$format = 'Excel2007';
				$decoderFactory->addDecoderFactory(
					$format,
					function(){return new ExcelDecoder('Excel2007');}
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

		$this->load->library('GenericDecoder', ['deFac' => $decoderFactory]);
		$genericDecoder = new GenericDecoder($decoderFactory);
		$list = $genericDecoder->decodeToFormat($file, $format);

		return $list;
	}

	public function filterData($format, $dataList)
	{
		$this->load->library('FilterFactory');
		$filterFactory = new FilterFactory();

		switch ($format) {
			case 'PaxCbs':
				$filterFactory->addFiltererFactory(
					$format,
					function(){return new PaxCbsFilter();}
				);
			break;
		}
		$this->load->library('GenericFilter', ['flFac' => $filterFactory]);
		$genericFilter = new GenericFilter($filterFactory);
		$list = $genericFilter->filterToFormat($dataList, $format);

		return $list;
	}

	/**
	 * @param string $format
	 * @param array  $dataList
	 * @return mixed
	 */
	public function encodeData($format, $dataList)
	{
		$this->load->library('EncoderFactory');
		$encoderFactory = new EncoderFactory();

		switch ($format) {
			case 'HTML':
				$encoderFactory->addEncoderFactory(
					$format,
					function(){return new HtmlEncoder();}
				);
			break;
			case 'XML':
				$encoderFactory->addEncoderFactory(
					$format,
					function(){return new XmlEncoder();}
				);
			break;
			case 'JSON':
				$encoderFactory->addEncoderFactory(
					$format,
					function(){return new JsonEncoder();}
				);
		}
		$this->load->library('GenericEncoder', ['enFac' => $encoderFactory]);
		$genericEncoder = new GenericEncoder($encoderFactory);
		$list = $genericEncoder->encodeToFormat($dataList, $format);

		return $list;
	}
}
