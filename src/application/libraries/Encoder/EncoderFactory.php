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

require_once 'EncoderFactoryInterface.php';

/**
 * The EncoderFactory
 *
 * @category Encoder
 * @package  PaxListConverter
 * @author   stephane-wis <on5wis@mac.com>
 * @license  MIT http://choosealicense.com/licenses/mit/
 * @link     github.com:EU-maritime/PaxListConverter-PHP
 */
class EncoderFactory implements EncoderFactoryInterface
{
    protected $factories = [];

    /**
     * Register a callable returning a EncoderInterface for the given format
     *
     * @param string   $format  : the name of the encoder
     * @param callable $factory : the function to execute the encoder
     *
     * @return void
     */
    public function addEncoderFactory($format, callable $factory)
    {
        $this->factories[$format] = $factory;
    }

    /**
     * The response of a encoder
     *
     * @param string $format : the name of the encoder
     *
     * @return EncoderInterface concrete Class defined by $format
     */
    public function createForFormat($format)
    {
        $factory = $this->factories[$format];
        $encoder = $factory();

        return $encoder;
    }
}
