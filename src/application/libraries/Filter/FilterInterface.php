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
 * The Filter Interface
 *
 * @category Filter
 * @package  PaxListConverter
 * @author   stephane-wis <on5wis@mac.com>
 * @license  MIT http://choosealicense.com/licenses/mit/
 * @link     github.com:EU-maritime/PaxListConverter-PHP
 */
interface FilterInterface
{
    /**
     * The main action of the Filter
     *
     * @param array $data : the content of the pax list
     *
     * @return array
     */
    public function filter(array $data);
}
