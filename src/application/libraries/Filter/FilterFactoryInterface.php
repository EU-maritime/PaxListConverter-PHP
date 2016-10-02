<?php
/**
 * PHP Version 5
 *
 * @category Filter
 * @package  PaxListConverter
 * @author   stephane-wis <on5wis@mac.com>
 * @license  MIT http://choosealicense.com/licenses/mit/
 * @link     github.com:EU-maritime/PaxListConverter-PHP
 */

/**
 * The Interface for the Filter Factory
 *
 * @category Filter
 * @package  PaxListConverter
 * @author   stephane-wis <on5wis@mac.com>
 * @license  MIT http://choosealicense.com/licenses/mit/
 * @link     github.com:EU-maritime/PaxListConverter-PHP
 */
interface FilterFactoryInterface
{
    /**
     * Create a filter for the given format
     *
     * @param string $format : the name of the Filter
     *
     * @return FilterInterface concrete Class defined by $format
     */
    public function createForFormat($format);
}
