<?php
/**
 * PHP Version 5
 *
 * @category Decoder
 * @package  PaxListConverter
 * @author   stephane-wis <on5wis@mac.com>
 * @license  MIT http://choosealicense.com/licenses/mit/
 * @link     github.com:EU-maritime/PaxListConverter-PHP
 */

require_once 'DecoderFactoryInterface.php';

/**
 * Decoder Factory
 *
 * @category Decoder
 * @package  PaxListConverter
 * @author   stephane-wis <on5wis@mac.com>
 * @license  MIT http://choosealicense.com/licenses/mit/
 * @link     github.com:EU-maritime/PaxListConverter-PHP
 */
class DecoderFactory implements DecoderFactoryInterface
{
    protected $factories = [];

    /**
     * Register a callable returning a DecoderInterface for the given format
     *
     * @param string   $format  : the name of the decoder
     * @param callable $factory : the function to execute the decoder
     *
     * @return void
     */
    public function addDecoderFactory($format, callable $factory)
    {
        $this->factories[$format] = $factory;
    }

    /**
     * The main function of the decoder
     *
     * @param string $format : the name of the decoder
     *
     * @return DecoderInterface concrete Class defined by $format
     */
    public function createForFormat($format)
    {
        $factory = $this->factories[$format];
        $decoder = $factory();

        return $decoder;
    }
}
