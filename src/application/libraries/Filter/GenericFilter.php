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
 * The Generic Filter
 *
 * @category Filter
 * @package  PaxListConverter
 * @author   stephane-wis <on5wis@mac.com>
 * @license  MIT http://choosealicense.com/licenses/mit/
 * @link     github.com:EU-maritime/PaxListConverter-PHP
 */
class GenericFilter
{
    protected $filterFactory;

    /**
     * GenericFilter constructor.
     *
     * @param FilterFactory $params : the filter factory to be used
     *
     * @return void
     */
    public function __construct(/*FilterFactory*/ $params)
    {
        $this->filterFactory = $params;
    }

    /**
     * The main action for the filter
     *
     * @param string $data   : pax list
     * @param string $format : the name of the filter
     *
     * @return mixed
     */
    public function filterToFormat($data, $format)
    {
        $encoder = $this->filterFactory->createForFormat($format);
        $rtn = $encoder->filter($data);

        return $rtn;
    }
}
