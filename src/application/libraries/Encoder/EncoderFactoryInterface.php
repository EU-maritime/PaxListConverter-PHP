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
 * The Interface for the Encoder Factory
 *
 * @category Encoder
 * @package  PaxListConverter
 * @author   stephane-wis <on5wis@mac.com>
 * @license  MIT http://choosealicense.com/licenses/mit/
 * @link     github.com:EU-maritime/PaxListConverter-PHP
 */
interface EncoderFactoryInterface
{
    /**
     * Create a encoder for the given format
     *
     * @param string $format : the name of the Encoder
     *
     * @return EncoderInterface concrete Class defined by $format
     */
    public function createForFormat($format);
}
