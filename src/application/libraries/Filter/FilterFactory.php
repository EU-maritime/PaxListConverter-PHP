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
require_once 'FilterFactoryInterface.php';
/**
 * Filter Factory
 *
 * @category Filter
 * @package  PaxListConverter
 * @author   stephane-wis <on5wis@mac.com>
 * @license  MIT http://choosealicense.com/licenses/mit/
 * @link     github.com:EU-maritime/PaxListConverter-PHP
 */
class FilterFactory implements FilterFactoryInterface
{
    protected $factories = [];

    /**
     * Register a callable returning a FilterInterface for the given format
     *
     * @param string   $format  : the name of the decoder
     * @param callable $factory : the function to execute the decoder
     *
     * @return void
     */
    public function addFiltererFactory($format, callable $factory)
    {
        $this->factories[$format] = $factory;
    }

    /**
     * The main function of the filter
     *
     * @param string $format : the name of the filter
     *
     * @return FilterInterface concrete Class defined by $format
     */
    public function createForFormat($format)
    {
        $factory = $this->factories[$format];
        $encoder = $factory();

        return $encoder;
    }

}
