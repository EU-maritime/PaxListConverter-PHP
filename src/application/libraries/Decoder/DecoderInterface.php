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

/**
 * The Decoder Interface
 *
 * @category Decoder
 * @package  PaxListConverter
 * @author   stephane-wis <on5wis@mac.com>
 * @license  MIT http://choosealicense.com/licenses/mit/
 * @link     github.com:EU-maritime/PaxListConverter-PHP
 */
interface DecoderInterface
{
    /**
     * The main action of the Decoder
     *
     * @param string $format the name of the Decoder
     *
     * @return stdClass|null
     */
    public function decode($format);
}
