<?php
/**
 * PHP Version 5
 *
 * @category Encoder
 * @package  PaxListConverter
 * @author   stephane-wis <on5wis@mac.com>
 * @license  MIT http://choosealicense.com/licenses/mit/
 * @link     github.com:EU-maritime/PaxListConverter-PHP
 */
/**
 * Generic Encoder
 *
 * @category Encoder
 * @package  PaxListConverter
 * @author   stephane-wis <on5wis@mac.com>
 * @license  MIT http://choosealicense.com/licenses/mit/
 * @link     github.com:EU-maritime/PaxListConverter-PHP
 */
class GenericEncoder
{
    protected $encoderFactory;

    /**
     * GenericEncoder constructor.
     *
     * @param EncoderFactory $params : the encoder factory to be used
     *
     * @return void
     */
    public function __construct(/*EncoderFactory*/ $params)
    {
        $this->encoderFactory = $params;
    }

    /**
     * The main action for encoding
     *
     * @param string $data   : pax list
     * @param string $format : the name of the decoder
     *
     * @return mixed
     */
    public function encodeToFormat($data, $format)
    {
        $encoder = $this->encoderFactory->createForFormat($format);
        $rtn = $encoder->encode($data);

        return $rtn;
    }
}
