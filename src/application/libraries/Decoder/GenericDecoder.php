<?php
/**
 * The Generic Decoder
 *
 * PHP Version 5
 *
 * @category Decoder
 * @package  PaxListConverter
 * @author   stephane-wis <on5wis@mac.com>
 * @license  MIT http://choosealicense.com/licenses/mit/
 * @link     github.com:EU-maritime/PaxListConverter-PHP
 */

/**
 * The Generic Decoder
 *
 * @category Decoder
 * @package  PaxListConverter
 * @author   stephane-wis <on5wis@mac.com>
 * @license  MIT http://choosealicense.com/licenses/mit/
 * @link     github.com:EU-maritime/PaxListConverter-PHP
 */
class GenericDecoder
{
    protected $decoderFactory;

    /**
     * GenericDecoder constructor.
     *
     * @param DecoderFactory $params : the decoder factory to be used
     *
     * @return void
     */
    public function __construct(/*DecoderFactory*/ $params)
    {
        $this->decoderFactory = $params;
    }

    /**
     * The main action for decoding
     *
     * @param string $data   : pax list
     * @param string $format : the name of the decoder
     *
     * @return array|null
     */
    public function decodeToFormat($data, $format)
    {
        $decoder = $this->decoderFactory->createForFormat($format);
        $rtn = $decoder->decode($data);

        return $rtn;
    }
}
