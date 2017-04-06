<?php
/**
 * The main entry point for loading a pax list to be converted
 *
 * PHP Version 5
 *
 * @category Controller
 * @package  PaxListConverter
 * @author   stephane-wis <on5wis@mac.com>
 * @license  MIT http://choosealicense.com/licenses/mit/
 * @link     github.com:EU-maritime/PaxListConverter-PHP
 */
require_once LIBRARIES.'Decoder/DecoderInterface.php';
require_once LIBRARIES.'Decoder/ExcelDecoder.php';
require_once LIBRARIES.'Decoder/TxtDecoder.php';
require_once LIBRARIES.'Decoder/CsvDecoder.php';
require_once LIBRARIES.'Decoder/JsonDecoder.php';
require_once LIBRARIES.'Decoder/XmlDecoder.php';
require_once LIBRARIES.'Encoder/EncoderInterface.php';
require_once LIBRARIES.'Encoder/HtmlEncoder.php';
require_once LIBRARIES.'Encoder/XmlEncoder.php';
require_once LIBRARIES.'Encoder/JsonEncoder.php';
require_once LIBRARIES.'Filter/FilterInterface.php';
require_once LIBRARIES.'Filter/PassengersFilter.php';
/**
 * The main Controller
 *
 * @category Controller
 * @package  PaxListConverter
 * @author   stephane-wis <on5wis@mac.com>
 * @license  MIT http://choosealicense.com/licenses/mit/
 * @link     github.com:EU-maritime/PaxListConverter-PHP
 */

class Load extends CI_Controller
{
    /**
     * Load constructor.
     */
    public function __construct()
    {
        log_message('info', ' entering '.__METHOD__);
        parent::__construct();
        $this->load->helper('file');
    }

    /**
     * The default action of the Load controller
     *
     * @return void
     */
    public function index()
    {
        log_message('info', ' entering '.__METHOD__);
        $data['name'] = '';
        $data['list'] = '';
        $data['xml']  = '';
        $data['xmlFile'] = '';
        $data['json'] = '';
        $data['allowed'] = 'no';
        $dataList = '';
        //Decoder part
        if ($_FILES) {
            echo '<hr>';
            $fileData = $_FILES['filedata'];
            $dataName = $fileData['name'];
            $dataType = $fileData['type'];
            $dataError = $fileData['error'];
            $dataSize = $fileData['size'];
            if ($dataError == 0) {
                switch ($dataType) {
                    case 'text/plain': //tab separated
                    case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'://excel new
                    case 'application/vnd.ms-excel': //excel old Excel5
                    case 'application/json': // json text file
                    case 'text/csv': //comma separated
                    case 'text/xml': //xml in a text file
                        $data['allowed'] = 'yes';
                        $dataList = $this->decodeData($fileData['tmp_name'], $dataType);
                        break;
                    case 'application/octet-stream':
                        $mime = get_mime_by_extension($dataName);
                        if ($mime) {
                            $data['allowed'] = 'yes';
                            $dataList = $this->decodeData($fileData['tmp_name'], $mime);
                        } else {
                            if (substr($dataName, -4) == '.xls') {
                                $data['allowed'] = 'yes';
                                $mime = 'application/vnd.ms-excel';
                                $dataList = $this->decodeData($fileData['tmp_name'], $mime);
                            }
                        }
                        break;
                    default;
                        $data['allowed'] = 'no';
                }
            }
        }
        //Filter part (PassengersFilter)
        if ($data['allowed'] === 'yes') {
            $format = 'Pax';
            $dataList = $this->filterData($format, $dataList);
        }

        //Encoder part (HtmlEncoder)
        if ($data['allowed'] === 'yes') {
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
     * The decoding part
     *
     * @param string $file       : the file containing the pax list
     * @param string $fileFormat : the format of the file
     *
     * @return array|null
     */
    public function decodeData($file, $fileFormat)
    {
        log_message('info', ' entering '.__METHOD__.' for: '.$fileFormat);
        $this->load->library('Decoder/DecoderFactory');
        $decoderFactory = new DecoderFactory();
        switch ($fileFormat) {
            case 'application/vnd.ms-excel': //excel old Excel5
                $format = 'Excel5';
                $decoderFactory->addDecoderFactory(
                    $format,
                    function () {
                        return new ExcelDecoder('Excel5');
                    }
                );
                break;
            case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
                $format = 'Excel2007';
                $decoderFactory->addDecoderFactory(
                    $format,
                    function () {
                        return new ExcelDecoder('Excel2007');
                    }
                );
                break;
            case 'application/json':
                $format = 'Json';
                $decoderFactory->addDecoderFactory(
                    $format,
                    function () {
                        return new JsonDecoder('Json');
                    }
                );
                break;
            case 'text/plain': //tab separated
                $format = 'Txt';
                $decoderFactory->addDecoderFactory(
                    $format,
                    function () {
                        return new TxtDecoder();
                    }
                );
                break;
            case 'text/csv': //comma separated value
                $format = 'Csv';
                $decoderFactory->addDecoderFactory(
                    $format,
                    function () {
                        return new CsvDecoder();
                    }
                );
                break;
            case 'text/xml': //comma separated value
                $format = 'Xml';
                $decoderFactory->addDecoderFactory(
                    $format,
                    function () {
                        return new XmlDecoder();
                    }
                );
                break;
           default:
                log_message('INFO', 'Unsupported format: '.$fileFormat);
                return null;
        }

        $this->load->library('Decoder/GenericDecoder', ['deFac' => $decoderFactory]);
        $genericDecoder = new GenericDecoder($decoderFactory);
        $list = $genericDecoder->decodeToFormat($file, $format);

        return $list;
    }

    /**
     * The filter part
     *
     * @param string $format   : the name of the filter to be used
     * @param array  $dataList : the actual pax list
     *
     * @return mixed
     */
    public function filterData($format, $dataList)
    {
        log_message('info', ' entering '.__METHOD__);
        $this->load->library('Filter/FilterFactory');
        $filterFactory = new FilterFactory();

        switch ($format) {
        case 'Pax':
            $filterFactory->addFilterFactory(
                $format,
                function () {
                    return new PassengersFilter();
                }
            );
            break;
        }
        $this->load->library('Filter/GenericFilter', ['flFac' => $filterFactory]);
        $genericFilter = new GenericFilter($filterFactory);
        $list = $genericFilter->filterToFormat($dataList, $format);

        return $list;
    }

    /**
     * The encode part
     *
     * @param string $format   : the name of the encoder to be used
     * @param array  $dataList : the actual pax list
     *
     * @return mixed
     */
    public function encodeData($format, $dataList)
    {
        log_message('info', ' entering '.__METHOD__);
        $this->load->library('Encoder/EncoderFactory');
        $encoderFactory = new EncoderFactory();

        switch ($format) {
        case 'HTML':
            $encoderFactory->addEncoderFactory(
                $format,
                function () {
                    return new HtmlEncoder();
                }
            );
            break;
        case 'XML':
            $encoderFactory->addEncoderFactory(
                $format,
                function () {
                    return new XmlEncoder();
                }
            );
            break;
        case 'JSON':
            $encoderFactory->addEncoderFactory(
                $format,
                function () {
                    return new JsonEncoder();
                }
            );
        }
        $this->load->library('Encoder/GenericEncoder', ['enFac' => $encoderFactory]);
        $genericEncoder = new GenericEncoder($encoderFactory);
        $list = $genericEncoder->encodeToFormat($dataList, $format);

        return $list;
    }
}
